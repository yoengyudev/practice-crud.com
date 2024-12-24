(() => {
    let frm_info = document.getElementById('frm-info');
    let frm_info_edit = document.getElementById('frm-info-edit');
    let frm_search = document.getElementById('frm-search');
    const live_toast = document.getElementById('liveToast')
    
    // fetch data
    function fetchData() {
        document.getElementById('spinner').style.display = 'flex';
        axios.get('/api/product/index.php')
            .then((res) => {
                listProduct(res.data);
                console.log(res.data.data.products);
                
            })
            .catch((err) => {
                console.log(err);
            })
            .finally(() => {
                document.getElementById('spinner').style.display = 'none';
            });
    }
    fetchData();

    function listProduct(data) {
        if(data.result == false) {
            console.log("no product found.");
            document.getElementById('data-list').innerHTML = "";
            let p = '';
            p = `<p class="text-center">${data.message}</p>`
            document.getElementById('t-foot').innerHTML = p;
            return;
        }
        console.log(data);
        const product = data.data.products;
        let p = '';
        p = `<p class="text-black fw-bold">Total Price: $${data.data.total}</p>`
        document.getElementById('t-foot').innerHTML = p;
        let number = 1;
        document.getElementById('data-list').innerHTML = "";
        product.forEach(e => {
            let tr = document.createElement('tr');
            tr.classList.add('align-middle');
            tr.classList.add('text-center');
            tr.innerHTML = `
                    <th scope="row">${number++}</th>
                    <td>${e.name}</td>
                    <td><img class="list-img" src="${e.image ? e.image : '/assets/image/test.php'}" alt="${e.image}"></td>
                    <td>${e.brand}</td>
                    <td>${e.price}$</td>
                    <td class="${stockColor(e.status)}">${e.status}</td>
                    <td>${e.stock}</td>
                    <td>
                        <button class="btn border-0 btn-product" data-product='${JSON.stringify(e)}'><i class="bi bi-plus-circle-dotted text-dark fs-5"></i></button>
                        <button class="btn border-0" onclick="deleteProduct(${e.id})"><i class="bi bi-trash3 text-danger fs-5"></i></button>
                        <button class="btn border-0" onclick="editProduct(${e.id})"><i class="bi bi-pencil-square text-warning fs-5"></i></button>
                    </td>
                `
            document.getElementById('data-list').appendChild(tr);
        });

        const pro = document.querySelectorAll('.btn-product');
        pro.forEach(btn => {
            btn.addEventListener('click', () => {
                let productObj = btn.getAttribute('data-product');
                let p = JSON.parse(productObj);
                alert("Hello " + p.name + " how are you?");
            });
        })
    }

    function stockColor(status) {
        let result = "";
        if(status === "In Stock") {
            result = "text-success";
        }else if(status === "Low Stock") {
            result = "text-warning";
        }else {
            result = "text-danger";
        }

        return result;
    }

    // upload file
    let dropzone = document.getElementById("dropzone");
    let photo = document.getElementById("photo");
    dropzone.onclick = () => {
        photo.click();
    }

    photo.onchange = () => {
        console.log(photo.files[0]['name']);
        if (photo.files && photo.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                console.log(e);
                document.getElementById('display-img').src = e.target.result;
                document.getElementById('display-img').style.display = "block"; 
            };
            reader.readAsDataURL(photo.files[0]);
        }    
    }

    

    // add product
    frm_info.onsubmit = (e) => {
        e.preventDefault();
        const modalElement = document.getElementById("staticBackdrop");
        const modal = bootstrap.Modal.getInstance(modalElement);

        let product_name = document.getElementById("product-name");
        let price = document.getElementById("price");
        let stock = document.getElementById("stock");
        let photo = document.getElementById("photo");
        let brand = document.getElementById("brand-name");

        frmData = new FormData();

        frmData.append('name', product_name.value);
        frmData.append('brand', brand.value);
        frmData.append('price', price.value);
        frmData.append('stock', stock.value);
        frmData.append('image', photo.files[0]);

        axios.post('/api/product/store.php', frmData)
            .then((res) => {
                console.log(res);
                if (res.data.result == true) {
                    fetchData();
                    modal.hide();
                    frm_info.reset();
                    document.getElementById('display-img').style.display = 'none';
                    document.querySelector('.toast-body').textContent = res.data.message;
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(live_toast);
                    toastBootstrap.show();
                } else {
                    alert(res.data.message)
                }
            })
    }

    // delete
    deleteProduct = (e) => {
        if (confirm("Are you sure you want to delete?")) {
            axios.get('/api/product/destroy.php?productId=' + e)
                .then((res) => {
                    if(res.data.result == true) {
                        fetchData();
                        document.querySelector('.toast-body').textContent = res.data.message;
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(live_toast);
                        toastBootstrap.show();
                    }
                });
        }
    }


    // show & update
    editProduct = (e) => {
        const modal = new bootstrap.Modal(document.getElementById('editModal'))
        axios.get('/api/product/show.php?productId=' + e)
            .then((res) => {
                console.log(res);
                if (res.data.result == false) {
                    alert(res.data.message);
                    return;
                }
                let product = res.data.data;
                console.log(res.data.data.image);
                document.getElementById('id').value = product.id;
                document.getElementById('product-name-edit').value = product.name;
                document.getElementById('brand-name-edit').value = product.brand;
                document.getElementById('price-edit').value = product.price;
                document.getElementById('stock-edit').value = product.stock;
                let photo = product.image;
                document.getElementById('show-img').setAttribute('src', photo);
                document.getElementById('show-img').setAttribute('alt', photo);
                modal.show();
            })
    }

        // upload file
        let dropzone_edit = document.getElementById("dropzone-edit");
        let photo_edit = document.getElementById("photo-edit");
        dropzone_edit.onclick = () => {
            photo_edit.click();
        }
    
        photo_edit.onchange = () => {
            console.log(photo_edit.files[0]['name']);
            if (photo_edit.files && photo_edit.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    console.log(e);
                    document.getElementById('display-img-edit').src = e.target.result;
                    document.getElementById('display-img-edit').style.display = "block"; 
                };
                reader.readAsDataURL(photo_edit.files[0]);
            }
            
        }

    frm_info_edit.onsubmit = (e) => {
        e.preventDefault();
        const modalElement = document.getElementById("editModal");
        const modal = bootstrap.Modal.getInstance(modalElement);
        let id = document.getElementById('id');
        let name = document.getElementById('product-name-edit');
        let brand = document.getElementById('brand-name-edit');
        let price = document.getElementById('price-edit');
        let stock = document.getElementById('stock-edit');
        let photo = document.getElementById('photo-edit');

        const frmData = new FormData();
        frmData.append('id', id.value);
        frmData.append('name', name.value);
        frmData.append('brand', brand.value);
        frmData.append('price', price.value);
        frmData.append('stock', stock.value);
        frmData.append('photo', photo.files[0]);

        axios.post('/api/product/update.php', frmData)
            .then((res) => {
                console.log(res.data.data);
                if (res.data.result == true) {
                    modal.hide();
                    fetchData();
                    frm_info_edit.reset();
                    document.getElementById('display-img-edit').style.display = 'none';
                    document.querySelector('.toast-body').textContent = res.data.message;
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(live_toast);
                    toastBootstrap.show();
                } else {
                    alert(res.data.message);
                }
            })

    }

    // search
    frm_search.onsubmit = (e) => {
        e.preventDefault();
        let search = document.getElementById('search-input').value;
        if(search == "") {
            alert("Please enter a search");
            return;
        }
        console.log(search);
        axios.get('/api/product/search.php?search=' + search)
            .then((res) => {
                listProduct(res.data);
            })
    }

    let search_input = document.getElementById('search-input');
    search_input.oninput = (e) => {
        e.preventDefault();
        console.log(e);
        if(search_input.value == "") {
            console.log("hi empty");
            fetchData();
        }
        
    }




})();