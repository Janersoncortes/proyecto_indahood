// Conexión a la base de datos MySQL
const mysql = require('mysql');
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'inventario'
});

// Obtener referencias a los elementos del DOM
const productForm = document.getElementById('product-form');
const productTable = document.getElementById('product-table');
const productTableBody = productTable.getElementsByTagName('tbody')[0];

// Función para renderizar los productos en la tabla
function renderProducts() {
    productTableBody.innerHTML = '';
    connection.query('SELECT * FROM productos', (error, results) => {
        if (error) throw error;

        results.forEach(product => {
            const row = document.createElement('tr');

            const codeCell = document.createElement('td');
            codeCell.textContent = product.codigo;
            row.appendChild(codeCell);

            const nameCell = document.createElement('td');
            nameCell.textContent = product.nombre;
            row.appendChild(nameCell);

            const descriptionCell = document.createElement('td');
            descriptionCell.textContent = product.descripcion;
            row.appendChild(descriptionCell);

            const categoryCell = document.createElement('td');
            categoryCell.textContent = product.categoria;
            row.appendChild(categoryCell);

            const priceCell = document.createElement('td');
            priceCell.textContent = `$${product.precio.toFixed(2)}`;
            row.appendChild(priceCell);

            const quantityCell = document.createElement('td');
            quantityCell.textContent = product.cantidad;
            row.appendChild(quantityCell);

            const actionsCell = document.createElement('td');
            actionsCell.classList.add('actions');

            const editButton = document.createElement('button');
            editButton.textContent = 'Editar';
            editButton.addEventListener('click', () => editProduct(product.id));
            actionsCell.appendChild(editButton);

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Eliminar';
            deleteButton.addEventListener('click', () => deleteProduct(product.id));
            actionsCell.appendChild(deleteButton);

            row.appendChild(actionsCell);
            productTableBody.appendChild(row);
        });
    });
}

// Función para agregar un nuevo producto
function addProduct(e) {
    e.preventDefault();

    const code = document.getElementById('code').value;
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const category = document.getElementById('category').value;
    const price = parseFloat(document.getElementById('price').value);
    const quantity = parseInt(document.getElementById('quantity').value);

    connection.query(
        'INSERT INTO productos (codigo, nombre, descripcion, categoria, precio, cantidad) VALUES (?, ?, ?, ?, ?, ?)',
        [code, name, description, category, price, quantity],
        (error, result) => {
            if (error) throw error;
            renderProducts();
            productForm.reset();
        }
    );
}

// Función para editar un producto existente
function editProduct(id) {
    // Obtener los datos del producto de la base de datos
    connection.query('SELECT * FROM productos WHERE id = ?', [id], (error, results) => {
        if (error) throw error;

        const product = results[0];

        document.getElementById('code').value = product.codigo;
        document.getElementById('name').value = product.nombre;
        document.getElementById('description').value = product.descripcion;
        document.getElementById('category').value = product.categoria;
        document.getElementById('price').value = product.precio;
        document.getElementById('quantity').value = product.cantidad;

        productForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const updatedCode = document.getElementById('code').value;
            const updatedName = document.getElementById('name').value;
            const updatedDescription = document.getElementById('description').value;
            const updatedCategory = document.getElementById('category').value;
            const updatedPrice = parseFloat(document.getElementById('price').value);
            const updatedQuantity = parseInt(document.getElementById('quantity').value);

            connection.query(
                'UPDATE productos SET codigo = ?, nombre = ?, descripcion = ?, categoria = ?, precio = ?, cantidad = ? WHERE id = ?',
                [updatedCode, updatedName, updatedDescription, updatedCategory, updatedPrice, updatedQuantity, id],
                (error, result) => {
                    if (error) throw error;
                    renderProducts();
                    productForm.reset();
                }
            );
        });
    });
}

// Función para eliminar un producto
function deleteProduct(id) {
    connection.query('DELETE FROM productos WHERE id = ?', [id], (error, result) => {
        if (error) throw error;
        renderProducts();
    });
}

// Cargar los productos al cargar la página
renderProducts();

// Agregar el evento submit al formulario
productForm.addEventListener('submit', addProduct);

connection.end()