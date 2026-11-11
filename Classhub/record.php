<?php
require_once __DIR__ . '/includes/functions.php';

$id     = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$record = find_record(get_records(), $id);

$pageTitle = $record ? format_name($record['name']) . ' | Bogate Phone Store' : 'Product not found';
require __DIR__ . '/includes/header.php';
?>

<a class="back" href="index.php">&larr; Back to all products</a>

<?php if ($record === null): ?>
    <p class="empty">That product does not exist. Go back and pick one from the catalog.</p>
<?php else: ?>
    <?php $name = format_name($record['name']); $stock = (int)$record['stock']; ?>
    <section class="detail">
        <img class="detail-photo" src="<?= e(image_path($record)) ?>" alt="Photo of <?= e($name) ?>">

        <div class="detail-info">
            <p class="card-code"><?= e(record_code((int)$record['id'])) ?></p>
            <span class="badge-lg"><?= e(format_brand($record['brand'])) ?></span>
            <h1><?= e($name) ?></h1>
            <p class="detail-price"><?= e(format_price((float)$record['price'])) ?></p>
            <p class="detail-stock stock <?= e(stock_class($stock)) ?>"><?= e(stock_label($stock)) ?> &middot; <?= e((string)$stock) ?> units available</p>

            <dl>
                <dt>Brand</dt>
                <dd><?= e(format_name($record['brand'])) ?></dd>

                <dt>Category</dt>
                <dd><?= e(format_name($record['category'])) ?></dd>

                <dt>Storage</dt>
                <dd><?= e($record['storage']) ?></dd>

                <dt>Color</dt>
                <dd><?= e(format_name($record['color'])) ?></dd>

                <dt>Price</dt>
                <dd><?= e(format_price((float)$record['price'])) ?></dd>

                <dt>Stock</dt>
                <dd><?= e((string)$stock) ?> units</dd>

                <dt>Added</dt>
                <dd><?= e(format_date($record['added'])) ?></dd>

                <dt>Description</dt>
                <dd><?= e($record['notes']) ?></dd>
            </dl>
        </div>
    </section>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>