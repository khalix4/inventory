document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('itemForm');
    const tableBody = document.querySelector('#itemsTable tbody');
  
    const fields = ['itemId', 'itemName', 'department', 'totalCost', 'quantity', 'profitPercent', 'alertPrice', 'expirationDate', 'email'];
  
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
  
      const data = Object.fromEntries(fields.map(id => [id.replace('itemId', 'id'), document.getElementById(id).value]));
      data.totalCost = parseFloat(data.totalCost);
      data.quantity = parseInt(data.quantity);
      data.profitPercent = parseFloat(data.profitPercent);
      if (data.alertPrice) data.alertPrice = parseFloat(data.alertPrice);
  
      const method = data.id ? 'PUT' : 'POST';
      const url = data.id ? `/items/${data.id}` : '/items';
      if (!data.id) delete data.id;
  
      await fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
  
      form.reset();
      loadItems();
    });
  
    window.loadItems = async () => {
      const res = await fetch('/items');
      const items = await res.json();
  
      tableBody.innerHTML = '';
      items.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${item.itemName}</td>
          <td>${item.department}</td>
          <td>₦${item.totalCost}</td>
          <td>${item.quantity}</td>
          <td>${item.profitPercent}%</td>
          <td>₦${item.sellingPrice}</td>
          <td>${item.expirationDate}</td>
          <td>${item.email}</td>
          <td>
            <button class="btn btn-sm btn-warning me-1" onclick='editItem(${JSON.stringify(item)})'>
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger" onclick='deleteItem("${item.id}")'>
              <i class="fas fa-trash"></i>
            </button>
          </td>
        `;
        tableBody.appendChild(tr);
      });
    };
  
    window.editItem = (item) => {
      fields.forEach(id => {
        const field = document.getElementById(id);
        if (field) field.value = item[id.replace('itemId', 'id')] || item[id];
      });
    };
  
    window.deleteItem = async (id) => {
      if (!confirm('Delete this item?')) return;
      await fetch(`/items/${id}`, { method: 'DELETE' });
      loadItems();
    };
  
    loadItems();
  });
  