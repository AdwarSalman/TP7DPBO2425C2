<?php
// view/orders.php
require_once __DIR__ . '/../class/Order.php';
require_once __DIR__ . '/../class/Product.php';
require_once __DIR__ . '/../class/Customer.php';

$order = new Order();
$product = new Product();
$customer = new Customer();
$error_msg = '';
$success_msg = '';

// --- HANDLE CREATE ORDER ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_order'])) {
    try {
        $order->createOrder($_POST['customer_id'], $_POST['product_id'], $_POST['qty']);
        $success_msg = "Transaksi berhasil dibuat!";
    } catch (Exception $e) {
        $error_msg = "Gagal membuat transaksi: " . $e->getMessage();
    }
}

$orders = $order->getAll();
$products = $product->getAll();
$customers = $customer->getAll();
?>

<h2 class="mb-4">🛒 Transaksi Pesanan</h2>

<?php if ($error_msg): ?><div class="alert alert-danger"><?= $error_msg ?></div><?php endif; ?>
<?php if ($success_msg): ?><div class="alert alert-success"><?= $success_msg ?></div><?php endif; ?>

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white py-3">
                <h6 class="m-0 font-weight-bold">Buat Transaksi Baru</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?page=orders">
                    <input type="hidden" name="create_order" value="1">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Pelanggan</label>
                        <select name="customer_id" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php foreach ($customers as $c): ?>
                                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Produk</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach ($products as $p): ?>
                                <?php if ($p['stock'] > 0): ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= htmlspecialchars($p['name']) ?> (Stok: <?= $p['stock'] ?>) - Rp <?= number_format($p['price'],0,',','.') ?>
                                </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Beli (Qty)</label>
                        <input type="number" name="qty" class="form-control" min="1" value="1" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
                        <i class="fas fa-shopping-cart me-2"></i> PROSES TRANSAKSI
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi Terakhir</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $o): ?>
                            <tr>
                                <td>#<?= $o['id'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($o['order_date'])) ?></td>
                                <td><strong><?= htmlspecialchars($o['customer_name']) ?></strong></td>
                                <td class="text-end fw-bold text-success">Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info" onclick="alert('Fitur Detail Transaksi belum dibuat. Anda bisa menambahkannya nanti!')">
                                        <i class="fas fa-info-circle"></i> Detail
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>