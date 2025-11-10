<?php
require_once __DIR__ . '/../class/Product.php';
require_once __DIR__ . '/../config/db.php';

$product = new Product();
$db = (new Database())->conn;
$categories = $db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
  $product->addProduct($_POST['name'], $_POST['category_id'], $_POST['description'], $_POST['price'], $_POST['stock']);
  header("Location: products.php"); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
  $product->updateProduct($_POST['id'], $_POST['name'], $_POST['category_id'], $_POST['description'], $_POST['price'], $_POST['stock']);
  header("Location: products.php"); exit;
}

if (isset($_GET['delete'])) {
  $product->deleteProduct($_GET['delete']);
  header("Location: products.php"); exit;
}

$products = $product->getAllProducts();
include __DIR__ . '/partials/header.php';
?>

<h3 class="mb-3">Kelola Produk</h3>

<!-- Form Tambah Produk -->
<form method="POST" class="card card-body mb-4 shadow-sm">
  <h5>Tambah Produk</h5>
  <input type="hidden" name="create" value="1">
  <div class="row mb-2">
    <div class="col-md-4"><input name="name" class="form-control" placeholder="Nama Produk" required></div>
    <div class="col-md-3">
      <select name="category_id" class="form-select" required>
        <option value="">Pilih Kategori</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2"><input name="price" type="number" class="form-control" placeholder="Harga" required></div>
    <div class="col-md-2"><input name="stock" type="number" class="form-control" placeholder="Stok" required></div>
  </div>
  <textarea name="description" class="form-control mb-2" placeholder="Deskripsi Produk"></textarea>
  <button class="btn btn-primary">Tambah</button>
</form>

<!-- Tabel Produk -->
<table class="table table-striped shadow-sm bg-white">
  <thead>
    <tr><th>ID</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
  </thead>
  <tbody>
  <?php foreach ($products as $p): ?>
    <tr>
      <td><?= $p['id'] ?></td>
      <td><?= htmlspecialchars($p['name']) ?></td>
      <td><?= htmlspecialchars($p['category_name']) ?></td>
      <td>Rp <?= number_format($p['price'],0,',','.') ?></td>
      <td><?= $p['stock'] ?></td>
      <td>
        <a href="products.php?edit=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
        <a href="products.php?delete=<?= $p['id'] ?>" onclick="return confirm('Yakin hapus produk?')" class="btn btn-sm btn-outline-danger">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<!-- Form Edit -->
<?php if (isset($_GET['edit'])):
  $edit = $product->getProductById($_GET['edit']); ?>
  <hr>
  <form method="POST" class="card card-body shadow-sm mt-3">
    <h5>Edit Produk ID #<?= $edit['id'] ?></h5>
    <input type="hidden" name="update" value="1">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <input name="name" class="form-control mb-2" value="<?= htmlspecialchars($edit['name']) ?>" required>

    <select name="category_id" class="form-select mb-2" required>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['id'] ?>" <?= $edit['category_id'] == $cat['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($cat['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <input name="price" class="form-control mb-2" value="<?= $edit['price'] ?>" required>
    <input name="stock" class="form-control mb-2" value="<?= $edit['stock'] ?>" required>
    <textarea name="description" class="form-control mb-2"><?= htmlspecialchars($edit['description']) ?></textarea>

    <button class="btn btn-primary">Simpan Perubahan</button>
  </form>
<?php endif; ?>

<?php include __DIR__ . '/partials/footer.php'; ?>
