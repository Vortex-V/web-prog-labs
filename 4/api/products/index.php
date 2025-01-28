<?php

declare(strict_types=1);

require '../../functions.php';

$attributes = ['category_id', 'brand_id'];
$get = array_filter($_GET + array_fill_keys($attributes, false));

$queryString = /** @lang PostgreSQL */
    "select p.*,
        c.name as category_name,
        b.name as brand_name
    from products p
    left join public.brands b on b.id = p.brand_id
    left join public.categories c on c.id = p.category_id";

$conditions = [];
$valuesToBind = [];

if (!empty($get['category_id'])) {
    $conditions[] = "p.category_id = :category_id";
    $valuesToBind['category_id'] = $get['category_id'];
}

if (!empty($get['brand_id'])) {
    $conditions[] = "p.brand_id = :brand_id";
    $valuesToBind['brand_id'] = $get['brand_id'];
}

if (!empty($conditions)) {
    $conditions = join(' and ', $conditions);
    $queryString .= " where {$conditions}";
}

$stmt = db()->prepare($queryString);

$stmt->execute($valuesToBind);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$data = array_reduce($data, function (array $carry, array $item) {
    $carry[$item['id']] = $item;
    return $carry;
}, []);

send(jsonEncode($data));
