<?php
require_once __DIR__ . '/../class/Product.php';
require_once __DIR__ . '/../class/Category.php';

$product = new Product();
$category = new Category();
$error_msg = '';

// --- HANDLER ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cat_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null;
    if (isset($_POST['add'])) {
        $product->add($_POST['name'], $cat_id, $_POST['price'], $_POST['stock']);
    } elseif (isset($_POST['edit'])) {
        $product->update($_POST['id'], $_POST['name'], $cat_id, $_POST['price'], $_POST['stock']);
    }
    echo "<script>window.location='index.php?page=products';</script>"; exit;
}

if (isset($_GET['delete'])) {
    try {
        $product->delete($_GET['delete']);
        echo "<script>window.location='index.php?page=products';</script>"; exit;
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

$dataProducts = $product->getAll();
$categories = $category->getAll();
$editData = isset($_GET['edit']) ? $product->getById($_GET['edit']) : null;
?>

<h2 class="mb-4">📦 Kelola Produk</h2>
<?php if ($error_msg): ?><div class="alert alert-danger"><?= $error_msg ?></div><?php endif; ?>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="POST" action="index.php?page=products">
            <?php if ($editData): ?>
                <input type="hidden" name="edit" value="true">
                <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <?php else: ?>
                <input type="hidden" name="add" value="true">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Nama Produk</label>
                    <input type="text" name="name" class="form-control" required value="<?= $editData['name'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label>Kategori</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($editData && $editData['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= $cat['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" required value="<?= $editData['price'] ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <label>Stok</label>
                    <input type="number" name="stock" class="form-control" required value="<?= $editData['stock'] ?? '' ?>">
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary"><?= $editData ? 'Update' : 'Simpan' ?></button>
                <?php if ($editData): ?><a href="index.php?page=products" class="btn btn-secondary">Batal</a><?php endif; ?>
            </div>
        </form>
    </div>
</div>

<table class="table table-striped">
    <thead class="table-dark"><tr><th>No</th><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
    <tbody>
        <?php $no=1; foreach ($dataProducts as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><span class="badge bg-info text-dark"><?= $row['category_name'] ?? '-' ?></span></td>
            <td>Rp <?= number_format($row['price'],0,',','.') ?></td>
            <td><?= $row['stock'] ?></td>
            <td>
                <a href="index.php?page=products&edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="index.php?page=products&delete=<?= $row['id'] ?>" onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>