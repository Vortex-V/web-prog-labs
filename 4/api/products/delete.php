<?php

declare(strict_types=1);

require '../../functions.php';

$attributes = ['id'];
$get = array_filter($_GET + array_fill_keys($attributes, false));

if (empty($get)) {
    send('Ошибка входных данных', 403);
}

$stmt = db()->prepare(/** @lang PostgreSQL */
    "select count(*) 
    from products
    where id = :id"
);
$stmt->execute(['id' => $get['id']]);
if ($stmt->fetchObject()->count === 0) {
    send('Продукт не найден.', 404);
}

$stmt = db()->prepare(/** @lang PostgreSQL */
    "delete from products
    where id = :id"
);
$stmt->execute(['id' => $get['id']]);

send();
