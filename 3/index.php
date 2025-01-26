<?php
require 'functions.php';
startPage();

$stmt = db()->query(/** @lang PostgreSQL */
    "select p.*, 
       c.name as category_name,
       b.name as brand_name
    from products p
    left join public.brands b on b.id = p.brand_id
    left join public.categories c on c.id = p.category_id"
);
?>
<h1>Магазин техники</h1>
<table>
    <thead>
        <tr>
            <th>Модель</th>
            <th>Бренд</th>
            <th>Категория</th>
            <th>Цена</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $category = '';
        while ($obj = $stmt->fetchObject()) {
            if ($category !== $obj->category_name) {
                $category = $obj->category_name;
                ?>
                <tr>
                    <th><?= $category ?></th>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td><?= $obj->name ?></td>
                <td><?= $obj->brand_name ?></td>
                <td><?= $obj->category_name ?></td>
                <td><?= $obj->price ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
    <a href="productCreate.php">
        <button>Добавить</button>
    </a>
<?php
endPage();
?>