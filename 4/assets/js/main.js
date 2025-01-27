window.addEventListener('load', function () {
    axios.defaults.baseURL = 'http://localhost:8080/api';

    const App = function () {
        const form = document.querySelector('.js--search-form');
        const categoryIdSelect = document.getElementById('search-category_id');
        const brandIdSelect = document.getElementById('search-brand_id');

        const tableBody = document.querySelector('.js--table-body');
        const placeholder = document.querySelector('.js--placeholder');

        const productAddButton = document.getElementById('product-add-button');
        const productForm = document.querySelector('.js--product-form');
        const productNameInput = document.getElementById('name');
        const productPriceInput = document.getElementById('price');
        const productCategoryIdSelect = document.getElementById('category_id');
        const productBrandIdSelect = document.getElementById('brand_id');
        const productSaveButton = document.querySelector('.js--product-save-button');

        let products = null;

        categoryIdSelect.addEventListener('change', loadProducts);
        brandIdSelect.addEventListener('change', loadProducts);

        productAddButton.addEventListener('click', function () {
           showProductForm();
        });
        productSaveButton.addEventListener('click', function () {
            let id = productSaveButton.getAttribute('data-product-id') || false;
            if (id) {
                axios.post('/products/update.php', {
                    name: productNameInput.value,
                    price: productPriceInput.value,
                    category_id: productCategoryIdSelect.value,
                    brand_id: productBrandIdSelect.value
                })
                    .then(function (result) {
                        //TODO
                    });
            } else {

            }
        });

        function loadProducts() {
            if (categoryIdSelect.value === '' || brandIdSelect.value === '') {
                return;
            }

            axios.get('/products/index.php', {
                params: {
                    category_id: categoryIdSelect.value,
                    brand_id: brandIdSelect.value,
                }
            })
                .then(function (result) {
                    tableBody.innerHTML = '';

                    products = result.data;
                    if (result.status !== 200 || Object.values(products).length === 0) {
                        placeholder.style.display = 'block';
                        return;
                    }

                    for (const product of Object.values(products)) {
                        const row = document.createElement('tr');
                        addCell(row, product.name);
                        addCell(row, product.price);
                        addCell(row, `<button class='js--product-edit-button' data-product-id="${product.id}">Редактировать</button>`)
                        addCell(row, `<button class='js--product-delete-button data-product-id="${product.id}'>Удалить</button>`)
                        tableBody.append(row);
                    }

                    placeholder.style.display = 'none';
                });

            function addCell(row, content) {
                const cell = row.insertCell();
                cell.innerHTML = content;
            }

            document.querySelectorAll('.js--product-edit-button').forEach(function (button) {
               button.addEventListener('click', function () {
                   showProductForm(button.getAttribute('data-product-id'));
               })
            });
            document.querySelectorAll('.js--product-delete-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    deleteProduct(button.getAttribute('data-product-id'));
                })
            });
        }

        function showProductForm(id = null) {
            if (id === null) {
                productNameInput.value = '';
                productPriceInput.value = '';
                productCategoryIdSelect.value = '';
                productBrandIdSelect.value = '';
                productSaveButton.textContent = 'Создать';
                productSaveButton.removeAttribute('data-product-id');
            } else {
                productNameInput.value = products[id].name;
                productPriceInput.value = products[id].price;
                productCategoryIdSelect.value = products[id].category_id;
                productBrandIdSelect.value = products[id].brand_id;
                productSaveButton.textContent = 'Сохранить';
                productSaveButton.setAttribute('data-product-id', id);
            }
            productForm.parentElement.style.display = 'block';
        }

        function deleteProduct(id) {
            productForm.parentElement.style.display = 'none';

            axios.post(`products/delete?id=${id}`)
                .then(function (result) {
                    if (result !== 200) {
                        alert(result.data);
                        return;
                    }

                    loadProducts();
                })
        }

        function loadCategories() {
            axios.get('/categories/index.php')
                .then(function (result) {
                    if (result.status !== 200) {
                        alert('Категории не найдены.');
                        return;
                    }

                    const data = result.data;

                    for (const [id, name] of Object.entries(data)) {
                        const option = new Option(name, id);
                        categoryIdSelect.append(option);
                        productCategoryIdSelect.append(option);
                    }
                });
        }

        function loadBrands() {
            axios.get('/brands/index.php')
                .then(function (result) {
                    if (result.status !== 200) {
                        alert('Категории не найдены.');
                        return;
                    }

                    const data = result.data;

                    for (const [id, name] of Object.entries(data)) {
                        const option = new Option(name, id);
                        brandIdSelect.append(option);
                        productBrandIdSelect.append(option);
                    }
                });
        }

        function init() {
            loadCategories();
            loadBrands();
        }

        init();
    }

    new App();
})
