import mysql from 'mysql';

// const db = mysql.createConnection({
//   host: 'mysql',
//   user: 'root',
//   password: 'passw',
//   database: 'loyalty_app',
// });
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'inventory',
});

export default db;  