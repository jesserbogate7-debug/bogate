<?php
require_once __DIR__ . '/includes/functions.php';

$allRecords = get_records();

$keyword = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
$brand   = isset($_GET['brand']) ? trim((string)$_GET['brand']) : 'all';
$brands  = get_brands($allRecords);

$records = search_records($allRecords, $keyword);
$records = filter_by_brand($records, $brand);

$pageTitle = 'Bogate Phone Store';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <h1>Bogate Phone Store</h1>
    <p class="hero-sub">Browse our collection of smartphones — <?= count_records($allRecords) ?> models available.</p>
</section>

<section class="stats">
    <div class="stat-card">
        <div class="stat-label">Total Models</div>
        <div class="stat-value"><?= count_records($allRecords) ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Units In Stock</div>
        <div class="stat-value"><?= total_stock($allRecords) ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Inventory Value</div>
        <div class="stat-value"><?= e(format_price(inventory_value($allRecords))) ?></div>
    </div>
</section>

<form class="toolbar" method="get" action="index.php">
    <label class="sr-only" for="q">Search products</label>
    <input id="q" type="search" name="q" value="<?= e($keyword) ?>" placeholder="Search by name, brand, storage, or color">

    <label class="sr-only" for="brand">Filter by brand</label>
    <select id="brand" name="brand">
        <option value="all" <?= $brand === 'all' ? 'selected' : '' ?>>All brands</option>
        <?php foreach ($brands as $b): ?>
            <option value="<?= e($b) ?>" <?= strcasecmp($brand, $b) === 0 ? 'selected' : '' ?>><?= e(format_name($b)) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Search</button>
    <?php if ($keyword !== '' || $brand !== 'all'): ?>
        <a class="reset" href="index.php">Clear</a>
    <?php endif; ?>
</form>

<?php if (count($records) === 0): ?>
    <p class="empty">No products match your search. Try a different keyword or clear the filter.</p>
<?php else: ?>
    <p class="result-count">Showing <?= count($records) ?> of <?= count($allRecords) ?> products</p>
    <section class="grid">
        <?php foreach ($records as $record): ?>
            <?php render_card($record); ?>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>