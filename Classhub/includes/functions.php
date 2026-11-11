<?php
/**
 * Helper functions for the Bogate Phone Store project.
 */

function get_records(): array
{
    return require __DIR__ . '/../data/records.php';
}

function find_record(array $records, int $id): ?array
{
    foreach ($records as $record) {
        if ((int)$record['id'] === $id) {
            return $record;
        }
    }
    return null;
}

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function format_name(string $name): string
{
    return ucwords(strtolower(trim($name)));
}

function format_brand(string $brand): string
{
    return strtoupper(trim($brand));
}

function format_price(float $price): string
{
    return '₱' . number_format($price, 2);
}

function shorten_text(string $text, int $max = 70): string
{
    $text = trim($text);
    if (strlen($text) <= $max) {
        return $text;
    }
    return rtrim(substr($text, 0, $max)) . '...';
}

function record_code(int $id): string
{
    return 'PH-' . str_pad((string)$id, 3, '0', STR_PAD_LEFT);
}

function format_date(string $date): string
{
    return date('M j, Y', strtotime($date));
}

function image_path(array $record): string
{
    $file = 'images/' . ($record['image'] ?? '');
    if ($file !== 'images/' && is_file(__DIR__ . '/../' . $file)) {
        return $file;
    }
    return 'assets/images/default.svg';
}

function search_records(array $records, string $keyword): array
{
    $keyword = trim($keyword);
    if ($keyword === '') {
        return $records;
    }
    $needle = strtolower($keyword);
    return array_values(array_filter($records, function ($record) use ($needle) {
        $haystack = strtolower($record['name'] . ' ' . $record['brand'] . ' ' . $record['category'] . ' ' . $record['color'] . ' ' . $record['storage']);
        return strpos($haystack, $needle) !== false;
    }));
}

function filter_by_brand(array $records, string $brand): array
{
    if ($brand === 'all' || $brand === '') {
        return $records;
    }
    return array_values(array_filter($records, function ($record) use ($brand) {
        return strcasecmp(trim((string)$record['brand']), trim($brand)) === 0;
    }));
}

function get_brands(array $records): array
{
    $brands = [];
    foreach ($records as $record) {
        $b = trim((string)$record['brand']);
        if ($b === '') continue;
        $key = strtolower($b);
        if (!isset($brands[$key])) {
            $brands[$key] = $b;
        }
    }
    $list = array_values($brands);
    sort($list, SORT_NATURAL | SORT_FLAG_CASE);
    return $list;
}

function count_records(array $records): int
{
    return count($records);
}

function total_stock(array $records): int
{
    $total = 0;
    foreach ($records as $record) {
        $total += (int)$record['stock'];
    }
    return $total;
}

function inventory_value(array $records): float
{
    $total = 0.0;
    foreach ($records as $record) {
        $total += (float)$record['price'] * (int)$record['stock'];
    }
    return $total;
}

function stock_label(int $stock): string
{
    if ($stock <= 10) return 'Low Stock';
    return 'In Stock';
}

function stock_class(int $stock): string
{
    return $stock <= 10 ? 'low' : 'in';
}

function render_card(array $record): void
{
    $name = format_name($record['name']);
    $url = 'record.php?id=' . (int)$record['id'];
    $stock = (int)$record['stock'];
    ?>
    <article class="card">
        <a class="card-link" href="<?= e($url) ?>">
            <div class="card-photo">
                <img src="<?= e(image_path($record)) ?>" alt="Photo of <?= e($name) ?>" loading="lazy">
                <span class="badge"><?= e(format_brand($record['brand'])) ?></span>
            </div>
            <div class="card-body">
                <p class="card-code"><?= e(record_code((int)$record['id'])) ?></p>
                <h3><?= e($name) ?></h3>
                <p class="card-specs"><?= e(format_name($record['storage'])) ?> &middot; <?= e(format_name($record['color'])) ?></p>
                <p class="card-notes"><?= e(shorten_text($record['notes'], 65)) ?></p>
                <div class="card-footer">
                    <span class="price"><?= e(format_price((float)$record['price'])) ?></span>
                    <span class="stock <?= e(stock_class($stock)) ?>"><?= e(stock_label($stock)) ?> (<?= e((string)$stock) ?>)</span>
                </div>
            </div>
        </a>
    </article>
    <?php
}
?>