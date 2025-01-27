<?php
require 'functions.php';
startPage();
?>
<h1>Магазин техники</h1>

<div class="mb-2">
    <form class="js--search-form"
          style="max-width: 250px">
        <div class="df jcb mb-1">
            <label for="search-category_id">Категория</label>
            <select id="search-category_id" name="category_id" required>
                <option value>Выберите категорию</option>
            </select>
        </div>
        <div class="df jcb mb-1">
            <label for="search-brand_id">Бренд</label>
            <select id="search-brand_id" name="brand_id" required>
                <option value>Выберите бренд</option>
            </select>
        </div>
    </form>
</div>

<div class="mb-2">
    <table>
        <thead>
        <tr>
            <th>Модель</th>
            <th>Цена</th>
            <th></th>
        </tr>
        </thead>
        <tbody class="js--table-body">
        </tbody>
    </table>
    <span class="js--placeholder">Необходимо выбрать категорию и бренд.</span>
</div>

<div class="mb-2">
    <button id="product-add-button" type="button">Добавить</button>
</div>

<div style="display: none">
    <form class="js--product-form"
          method="post" style="max-width: 300px">
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
            </select>
        </div>
        <div class="df jcb mb-2">
            <label for="brand_id">Бренд</label>
            <select id="brand_id" name="brand_id" required>
                <option value>Выберите бренд</option>
            </select>
        </div>
        <div>
            <button class="js--product-save-button" type="button">Сохранить</button>
        </div>
    </form>
</div>

<?php
endPage();
?>