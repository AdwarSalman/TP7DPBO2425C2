<?php
require_once __DIR__ . '/../class/Customer.php';
$customer = new Customer();
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $customer->add($_POST['name'], $_POST['email'], $_POST['phone']);
    } elseif (isset($_POST['edit'])) {
        $customer->update($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone']);
    }
    echo "<script>window.location='index.php?page=customers';</script>"; exit;
}

if (isset($_GET['delete'])) {
    try {
        $customer->delete($_GET['delete']);
        echo "<script>window.location='index.php?page=customers';</script>"; exit;
    } catch (Exception $e) {
        $error_msg = $e->getMessage();
    }
}

$dataCustomers = $customer->getAll();
$editData = isset($_GET['edit']) ? $customer->getById($_GET['edit']) : null;
?>

<h2 class="mb-4">👥 Kelola Pelanggan</h2>
<?php if ($error_msg): ?><div class="alert alert-danger"><?= $error_msg ?></div><?php endif; ?>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="POST" action="index.php?page=customers">
                    <?php if ($editData): ?>
                        <input type="hidden" name="edit" value="true"><input type="hidden" name="id" value="<?= $editData['id'] ?>">
                    <?php else: ?>
                        <input type="hidden" name="add" value="true">
                    <?php endif; ?>
                    <div class="mb-2"><label>Nama</label><input name="name" class="form-control" required value="<?= $editData['name'] ?? '' ?>"></div>
                    <div class="mb-2"><label>Email</label><input name="email" class="form-control" value="<?= $editData['email'] ?? '' ?>"></div>
                    <div class="mb-3"><label>HP</label><input name="phone" class="form-control" required value="<?= $editData['phone'] ?? '' ?>"></div>
                    <button class="btn btn-primary w-100"><?= $editData ? 'Update' : 'Tambah' ?></button>
                    <?php if ($editData): ?><a href="index.php?page=customers" class="btn btn-secondary w-100 mt-2">Batal</a><?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-striped">
            <thead class="table-dark"><tr><th>No</th><th>Nama</th><th>Kontak</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php $no=1; foreach ($dataCustomers as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['email'] ?><br><?= $row['phone'] ?></td>
                    <td>
                        <a href="index.php?page=customers&edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="index.php?page=customers&delete=<?= $row['id'] ?>" onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>