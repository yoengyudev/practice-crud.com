<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/vendor/bootstrap-icon/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <title>GRUD</title>
</head>

<body>

    <div id="spinner">
        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <main>
        <section class="section-grud py-5">
            <div class="container">
                <div class="row mb-5">
                    <div class="col-8">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            <i class="bi bi-plus-circle"></i> Add New
                        </button>
                    </div>
                    <div class="col-4">
                        <form id="frm-search" method="get">
                            <div class="d-flex gap-2">
                                <input type="search" id="search-input" class="form-control" placeholder="Search by product name">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="data-list">
                    </tbody>
                </table>
                <div id="t-foot">
                </div>
            </div>
        </section>

        <!-- taost message -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast text-bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="toast-body">
                        
                    </div>
                    <button type="button" class="btn border-0" data-bs-dismiss="toast" aria-label="Close">
                        <i class=" bi bi-x text-white fs-4"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Add -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm-info" method="post">
                            <div class="row g-3">
                                <div class="col-12 col-lg-6">
                                    <label for="product-name" class="form-label fw-bold">Product Name</label>
                                    <input type="text" id="product-name" required placeholder="Enter product name" class="form-control">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="brand-name" class="form-label fw-bold">Brand Name</label>
                                    <input type="text" id="brand-name" required placeholder="Enter product brand" class="form-control">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="price" class="form-label fw-bold">Price</label>
                                    <input type="number" id="price" required placeholder="Enter product price" class="form-control">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="stock" class="form-label fw-bold">Stock Quantity</label>
                                    <input type="number" id="stock" required placeholder="Enter stock quantity" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="photo" class="form-label fw-bold fw-bold">Photo</label>
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <div id="dropzone" class="border border-primary rounded d-flex flex-column justify-content-center align-items-center py-4 cursor-pointer">
                                                <div>
                                                    <i class="bi bi-cloud-upload-fill fs-1 text-primary"></i>
                                                </div>
                                                <p class="mb-1">Drag and drop here</p>
                                                <p class="mb-0">or <span class="text-primary cursor-pointer text-decoration-underline">browse</span></p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <img id="display-img" alt="" class="rounded">
                                        </div>
                                    </div>
                                    <input type="file" id="photo" required class="d-none" />
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Update -->
        <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editModalLabel">Edit Product</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="frm-info-edit" method="post">
                            <div class="row g-3">
                                <input type="hidden" id="id">
                                <div class="col-12 col-lg-6">
                                    <label for="product-name-edit" class="form-label fw-bold">Product Name</label>
                                    <input type="text" id="product-name-edit" placeholder="Enter product name" class="form-control">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="brand-name-edit" class="form-label fw-bold">Brand Name</label>
                                    <input type="text" id="brand-name-edit" placeholder="Enter product brand" class="form-control">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="price-edit" class="form-label fw-bold">Price</label>
                                    <input type="number" id="price-edit" placeholder="Enter product price" class="form-control">
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label for="stock-edit" class="form-label fw-bold">Stock Quantity</label>
                                    <input type="number" id="stock-edit" placeholder="Enter stock quantity" class="form-control">
                                </div>
                                <div class="col-12">
                                    <img id="show-img">
                                </div>
                                <div class="col-12">
                                    <label for="photo-edit" class="form-label fw-bold">Photo</label>
                                    <input type="file" id="photo-edit" class="d-none">
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <div id="dropzone-edit" class="border border-primary rounded d-flex flex-column justify-content-center align-items-center py-4 cursor-pointer">
                                                <div>
                                                    <i class="bi bi-cloud-upload-fill fs-1 text-primary"></i>
                                                </div>
                                                <p class="mb-1">Drag and drop here</p>
                                                <p class="mb-0">or <span class="text-primary cursor-pointer text-decoration-underline">browse</span></p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <img id="display-img-edit" alt="" class="rounded">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save change</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="/assets/js/axios.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/script.js"></script>
</body>

</html>