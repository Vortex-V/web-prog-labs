<?php
require 'functions.php';
startPage();
?>
<h1>Создать продукт</h1>
<form action="actions/productStore.php" method="post" style="max-width: 300px">
    <div class="df jcb mb-2">
        <label for="name">Название</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="df jcb mb-2">
        <label for="price">Цена</label>
        <input type="text" id="price" name="price" required>
    </div>
    <div class="df jcb mb-2">
        <label for="category_id">Категория</label>
        <select id="category_id" name="category_id" required>
            <option value>Выберите категорию</option>
            <?php
            $stmt = db()->query("select * from categories");
            while ($obj = $stmt->fetchObject()) {
            ?>
                <option value="<?= $obj->id ?>"><?= $obj->name ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="df jcb mb-2">
        <label for="brand_id">Бренд</label>
        <select id="brand_id" name="brand_id" required>
            <option value>Выберите бренд</option>
            <?php
            $stmt = db()->query("select * from brands");
            while ($obj = $stmt->fetchObject()) {
            ?>
                <option value="<?= $obj->id ?>"><?= $obj->name ?></option>
            <?php } ?>
        </select>
    </div>
    <div>
        <button type="submit">Сохранить</button>
    </div>
</form>
<?php
endPage();
?>