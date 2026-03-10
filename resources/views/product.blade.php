<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenMart Product</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .form-control:focus {
            outline: none;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
            border-color: #198754;
        }
    </style>
</head>

<body class="bg-light p-3 p-md-5 text-dark" style="font-family: system-ui, -apple-system, sans-serif;">

    <div class="container bg-white shadow rounded-3 border overflow-hidden p-0" style="max-width: 80rem;">

        <div class="bg-success p-4 text-white d-flex justify-content-between align-items-center">
            <h1 class="h4 mb-0 fw-bold">GreenMart Product Entry</h1>
            <svg class="opacity-75" style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
        </div>

        <form method="POST" action="/products" enctype="multipart/form-data" class="p-4 p-md-5">
            @csrf

            @if(session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                    <svg class="me-2" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive border rounded-3 mb-4">
                <table class="table table-bordered mb-0 bg-white" id="productTable">
                    <thead class="table-light text-secondary text-uppercase" style="font-size: 0.875rem;">
                        <tr>
                            <th class="p-3 text-center align-middle" style="width: 4rem;">No</th>
                            <th class="p-3 text-center align-middle" style="width: 25%;">Produk</th>
                            <th class="p-3 text-center align-middle">Deskripsi Produk</th>
                            <th class="p-3 text-center align-middle" style="width: 14rem;">Gambar Produk</th>
                            <th class="p-3 text-center align-middle" style="width: 8rem;">Aksi</th>
                            <th class="p-3 bg-light border-0" style="width: 4rem;"></th>
                        </tr>
                    </thead>

                    @if(isset($products) && $products->isNotEmpty())
                        @foreach ($products as $product)
                            <tbody class="product-group existing-product">
                                <x-product-row :product="$product" />
                            </tbody>
                        @endforeach
                    @endif
                </table>
            </div>

            <div class="d-flex align-items-center justify-content-between pt-2">
                <button type="button" id="addProductBtn"
                    class="btn btn-outline-success fw-bold d-flex align-items-center gap-2 px-4 py-2">
                    <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Produk
                </button>

                <button type="submit"
                    class="btn btn-primary fw-bold text-white d-flex align-items-center gap-2 px-4 py-2">
                    Submit Data
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap Modal for Delete Confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 1rem;">
                <div class="modal-body p-4 text-center">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4"
                        style="width: 4rem; height: 4rem;">
                        <svg style="width: 2rem; height: 2rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <p class="text-secondary mb-4 small">Apakah Anda yakin untuk menghapus gambar ini?</p>

                    <div class="d-flex gap-2 mt-2">
                        <button type="button" class="btn btn-secondary w-100 fw-bold py-2" data-bs-dismiss="modal">
                            Batalkan
                        </button>
                        <button type="button" class="btn btn-danger w-100 fw-bold py-2" id="confirmDeleteBtn">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>