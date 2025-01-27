<?php

declare(strict_types=1);

require '../../functions.php';

$stmt = db()->query(/** @lang PostgreSQL */
    "select * from brands order by name");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$data = array_reduce($data, function (array $carry, array $item) {
    $carry[$item['id']] = $item['name'];
    return $carry;
}, []);

send(jsonEncode($data));