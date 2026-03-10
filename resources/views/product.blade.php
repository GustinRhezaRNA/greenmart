<!DOCTYPE html>
<html>

<head>

<title>GreenMart Product</title>

</head>

<body>

<h2>Product Page</h2>

<form method="POST" action="/products" enctype="multipart/form-data">

@csrf

<table border="1">

<thead>

<tr>

<th>No</th>
<th>Produk</th>
<th>Deskripsi</th>
<th>Gambar</th>
<th>Aksi</th>

</tr>

</thead>

<tbody id="productTable">

</tbody>

</table>

<br>

<button type="button" id="addProduct">+ Add Product</button>

<br><br>

<button type="submit">Submit</button>

</form>

<script src="/js/product.js"></script>

</body>

</html>