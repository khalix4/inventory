const express = require('express');
const mysql = require('mysql2/promise');
const cron = require('node-cron');
const nodemailer = require('nodemailer');
const { v4: uuidv4 } = require('uuid');

const app = express();
app.use(express.json());

const dbConfig = {
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'inventory'
};

let db;
(async () => {
  db = await mysql.createConnection(dbConfig);
  await db.execute(`CREATE TABLE IF NOT EXISTS items (
    id VARCHAR(36) PRIMARY KEY,
    itemName VARCHAR(255),
    department VARCHAR(255),
    totalCost DECIMAL(12,2),
    quantity INT,
    profitPercent DECIMAL(5,2),
    expirationDate DATE,
    alertPrice DECIMAL(12,2),
    unitCost DECIMAL(12,2),
    sellingPrice DECIMAL(12,2),
    email VARCHAR(255)
  )`);
})();

function calculate(item) {
  const unitCost = item.totalCost / item.quantity;
  const profit = (item.profitPercent / 100) * unitCost;
  let sellingPrice = unitCost + profit;
  sellingPrice = Math.round(sellingPrice / 10) * 10;
  return { ...item, unitCost, sellingPrice };
}

app.post('/items', async (req, res) => {
  const raw = req.body;
  const item = calculate(raw);
  const id = uuidv4();
  await db.execute(`INSERT INTO items (id, itemName, department, totalCost, quantity, profitPercent, expirationDate, alertPrice, unitCost, sellingPrice, email)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
    [id, item.itemName, item.department, item.totalCost, item.quantity, item.profitPercent, item.expirationDate, item.alertPrice || null, item.unitCost, item.sellingPrice, item.email]);
  res.status(201).json({ message: 'Item saved', item: { id, ...item } });
});

app.get('/items', async (req, res) => {
  const [rows] = await db.execute('SELECT * FROM items');
  res.json(rows);
});

app.put('/items/:id', async (req, res) => {
  const id = req.params.id;
  const item = calculate(req.body);
  await db.execute(`UPDATE items SET itemName=?, department=?, totalCost=?, quantity=?, profitPercent=?, expirationDate=?, alertPrice=?, unitCost=?, sellingPrice=?, email=? WHERE id=?`,
    [item.itemName, item.department, item.totalCost, item.quantity, item.profitPercent, item.expirationDate, item.alertPrice || null, item.unitCost, item.sellingPrice, item.email, id]);
  res.json({ message: 'Item updated', item: { id, ...item } });
});

app.delete('/items/:id', async (req, res) => {
  const id = req.params.id;
  await db.execute('DELETE FROM items WHERE id = ?', [id]);
  res.json({ message: 'Item deleted' });
});

app.get('/items/expiring-soon', async (req, res) => {
  const [rows] = await db.execute(`SELECT * FROM items WHERE expirationDate <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)`);
  res.json(rows);
});

const transporter = nodemailer.createTransport({
  service: 'gmail',
  auth: {
    user: 'your-email@gmail.com',
    pass: 'your-password-or-app-password'
  }
});

async function checkExpirationsAndPriceThresholds() {
  const [items] = await db.execute('SELECT * FROM items');
  const today = new Date();

  for (const item of items) {
    const expiry = new Date(item.expirationDate);
    const diffDays = Math.ceil((expiry - today) / (1000 * 60 * 60 * 24));

    if (diffDays <= 5) {
      sendEmail(item.email, `Expiration alert for ${item.itemName}`, `Item ${item.itemName} expires in ${diffDays} days.`);
    }

    if (item.alertPrice && item.sellingPrice <= item.alertPrice) {
      sendEmail(item.email, `Price alert for ${item.itemName}`, `Selling price ₦${item.sellingPrice} is below alert threshold ₦${item.alertPrice}.`);
    }
  }
}

function sendEmail(to, subject, text) {
  transporter.sendMail({ from: 'your-email@gmail.com', to, subject, text }, (err, info) => {
    if (err) console.error('Email error:', err);
    else console.log('Email sent:', info.response);
  });
}

cron.schedule('0 8 * * *', checkExpirationsAndPriceThresholds);

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
