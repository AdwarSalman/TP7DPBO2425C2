<?php
require_once __DIR__ . '/../class/Order.php';
require_once __DIR__ . '/../class/Customer.php';
$order = new Order();
$customer = new Customer();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
  $order->addOrder($_POST['customer_id'], $_POST['total']);
  header("Location: orders.php"); exit;
}

if (isset($_GET['delete'])) {
  $order->deleteOrder($_GET['delete']);
  header("Location: orders.php"); exit;
}

$orders = $order->getAllOrders();
$customers = $customer->getAllCustomers();
include __DIR__ . '/partials/header.php';
?>

<h3 class="mb-3">Kelola Pesanan</h3>

<form method="POST" class="card card-body mb-4 shadow-sm">
  <h5>Tambah Pesanan</h5>
  <input type="hidden" name="create" value="1">
  <div class="row mb-2">
    <div class="col-md-6">
      <select name="customer_id" class="form-select">
        <?php foreach ($customers as $c): ?>
          <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6"><input name="total" type="number" class="form-control" placeholder="Total Harga" required></div>
  </div>
  <button class="btn btn-primary">Tambah</button>
</form>

<table class="table table-striped bg-white shadow-sm">
  <thead><tr><th>ID</th><th>Pelanggan</th><th>Total</th><th>Tanggal</th><th>Aksi</th></tr></thead>
  <tbody>
  <?php foreach ($orders as $o): ?>
    <tr>
      <td><?= $o['id'] ?></td>
      <td><?= htmlspecialchars($o['customer_name']) ?></td>
      <td>Rp <?= number_format($o['total'], 0, ',', '.') ?></td>
      <td><?= $o['order_date'] ?></td>
      <td>
        <a href="orders.php?delete=<?= $o['id'] ?>" onclick="return confirm('Yakin hapus pesanan?')" class="btn btn-sm btn-outline-danger">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?php include __DIR__ . '/partials/footer.php'; ?>
