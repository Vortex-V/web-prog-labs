<?php

declare(strict_types=1);

require '../../functions.php';

$attributes = ['name', 'price', 'category_id', 'brand_id'];
$post = array_filter(jsonDecode(file_get_contents('php://input')) + array_fill_keys($attributes, false));
if (empty($post) || count($post) < count($attributes)) {
    send('Ошибка входных данных', 403);
}

$stmt = db()->prepare(/** @lang PostgreSQL */
    "select count(*) 
    from categories
    where id = :id"
);
$stmt->bindParam("id", $post['category_id']);
$stmt->execute();
if ($stmt->fetchObject()->count === 0) {
    send('Категория не найдена.', 404);
}
unset($stmt);

$stmt = db()->prepare(/** @lang PostgreSQL */
    "select count(*) 
    from brands
    where id = :id"
);
$stmt->bindParam("id", $post['brand_id']);
$stmt->execute();
if ($stmt->fetchObject()->count === 0) {
    send('Бренд не найден.', 404);
}
unset($stmt);

$stmt = db()->prepare(/** @lang PostgreSQL */
    "insert into products 
    (name, price, category_id, brand_id)
    values (:name, :price, :category_id, :brand_id)")
    ->execute(array_intersect_key($post, array_flip($attributes)));

unset($stmt);

send();
