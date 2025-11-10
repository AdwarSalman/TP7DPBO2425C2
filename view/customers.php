<?php
require_once __DIR__ . '/../class/Customer.php';
$customer = new Customer();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
  $customer->addCustomer($_POST['name'], $_POST['email'], $_POST['phone']);
  header("Location: customers.php"); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
  $customer->updateCustomer($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone']);
  header("Location: customers.php"); exit;
}

if (isset($_GET['delete'])) {
  $customer->deleteCustomer($_GET['delete']);
  header("Location: customers.php"); exit;
}

$customers = $customer->getAllCustomers();
include __DIR__ . '/partials/header.php';
?>

<h3 class="mb-3">Kelola Pelanggan</h3>

<form method="POST" class="card card-body mb-4 shadow-sm">
  <h5>Tambah Pelanggan</h5>
  <input type="hidden" name="create" value="1">
  <div class="row mb-2">
    <div class="col-md-4"><input name="name" class="form-control" placeholder="Nama" required></div>
    <div class="col-md-4"><input name="email" type="email" class="form-control" placeholder="Email"></div>
    <div class="col-md-4"><input name="phone" class="form-control" placeholder="Nomor Telepon"></div>
  </div>
  <button class="btn btn-primary">Tambah</button>
</form>

<table class="table table-striped bg-white shadow-sm">
  <thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Telepon</th><th>Aksi</th></tr></thead>
  <tbody>
  <?php foreach ($customers as $c): ?>
    <tr>
      <td><?= $c['id'] ?></td>
      <td><?= htmlspecialchars($c['name']) ?></td>
      <td><?= htmlspecialchars($c['email']) ?></td>
      <td><?= htmlspecialchars($c['phone']) ?></td>
      <td>
        <a href="customers.php?edit=<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
        <a href="customers.php?delete=<?= $c['id'] ?>" onclick="return confirm('Yakin hapus pelanggan?')" class="btn btn-sm btn-outline-danger">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php if (isset($_GET['edit'])):
  $edit = $customer->getCustomerById($_GET['edit']); ?>
  <hr>
  <form method="POST" class="card card-body shadow-sm mt-3">
    <h5>Edit Pelanggan ID #<?= $edit['id'] ?></h5>
    <input type="hidden" name="update" value="1">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <input name="name" class="form-control mb-2" value="<?= htmlspecialchars($edit['name']) ?>" required>
    <input name="email" class="form-control mb-2" value="<?= htmlspecialchars($edit['email']) ?>">
    <input name="phone" class="form-control mb-2" value="<?= htmlspecialchars($edit['phone']) ?>">
    <button class="btn btn-primary">Simpan Perubahan</button>
  </form>
<?php endif; ?>

<?php include __DIR__ . '/partials/footer.php'; ?>
