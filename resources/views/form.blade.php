<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form with IndexedDB</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2 class="mt-5">Order Form</h2>
    <form id="myForm" class="mb-5">
        <div class="form-group">
            <label for="product_name">Product Name:</label>
            <input type="text" class="form-control" id="product_name" required>
        </div>
        <div class="form-group">
            <label for="customer_name">Customer Name:</label>
            <input type="text" class="form-control" id="customer_name" required>
        </div>
        <div class="form-group">
            <label for="qunatity">Qunatity:</label>
            <input type="text" class="form-control" id="qunatity" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <button id="clearButton" class="btn btn-danger mb-3">Clear Database</button>

    <h2>Order Details</h2>
    <table class="table table-bordered" id="dataTable">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Customer Name</th>
            <th>Qunatity</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let db;
        const request = indexedDB.open('myDatabase', 1);

        request.onerror = function(event) {
            console.error('Database error:', event.target.error);
        };

        request.onsuccess = function(event) {
            db = event.target.result;
            displayData();
        };

        request.onupgradeneeded = function(event) {
            db = event.target.result;
            const objectStore = db.createObjectStore('myObjectStore', { keyPath: 'id', autoIncrement: true });
            objectStore.createIndex('product_name', 'product_name', { unique: false });
            objectStore.createIndex('customer_name', 'customer_name', { unique: false });
            objectStore.createIndex('qunatity', 'qunatity', { unique: false });
        };

        document.getElementById('myForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const product_name = document.getElementById('product_name').value;
            const customer_name = document.getElementById('customer_name').value;
            const qunatity = document.getElementById('qunatity').value;

            const transaction = db.transaction(['myObjectStore'], 'readwrite');
            const objectStore = transaction.objectStore('myObjectStore');
            const request = objectStore.add({ product_name: product_name, customer_name: customer_name, qunatity: qunatity });

            request.onsuccess = function(event) {
                console.log('Data added to database');
                displayData();
            };

            request.onerror = function(event) {
                console.error('Error adding data to database:', event.target.error);
            };
        });

        function displayData() {
            const transaction = db.transaction(['myObjectStore'], 'readonly');
            const objectStore = transaction.objectStore('myObjectStore');
            const request = objectStore.getAll();

            request.onsuccess = function(event) {
                const data = event.target.result;
                const tableBody = document.querySelector('#dataTable tbody');
                tableBody.innerHTML = '';
                data.forEach(item => {
                    const row = tableBody.insertRow();
                    row.insertCell(0).textContent = item.product_name;
                    row.insertCell(1).textContent = item.customer_name;
                    row.insertCell(2).textContent = item.qunatity;
                });
            };

            request.onerror = function(event) {
                console.error('Error retrieving data from database:', event.target.error);
            };
        }

        document.getElementById('clearButton').addEventListener('click', function() {
            const transaction = db.transaction(['myObjectStore'], 'readwrite');
            const objectStore = transaction.objectStore('myObjectStore');
            const request = objectStore.clear();
            request.onsuccess = function(event) {
                console.log('Database cleared');
                displayData();
            };
            request.onerror = function(event) {
                console.error('Error clearing database:', event.target.error);
            };
        });

    });

    

</script>
</body>
</html>
