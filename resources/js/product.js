import $ from 'jquery';

let productIndex = Date.now();
const MAX_PRODUCTS = 5;
const MAX_DESC = 3;
let imageToDeleteInput = null;
let imagePreviewToHide = null;

$(document).ready(function () {
    checkProductLimit();

    $('#addProductBtn').on('click', function () {
        const groups = $('.product-group');
        if (groups.length >= MAX_PRODUCTS) {
            alert("Anda Sudah Mencapai Maksimum Input");
            return;
        }

        productIndex++;
        const currIdx = productIndex;

        const rowHtml = `
            <tbody class="product-group bg-white">
                <tr class="desc-row">
                    <td class="p-3 text-center align-middle fw-bold text-secondary fs-5 product-number" rowspan="1"></td>
                    <td class="p-3 align-middle" rowspan="1">
                        <input class="form-control" name="products[${currIdx}][name]" placeholder="Ketik nama produk" required>
                    </td>
                    <td class="p-3">
                        <input class="form-control" name="products[${currIdx}][descriptions][0][text]" placeholder="Ketik deskripsi produk" required>
                    </td>
                    <td class="p-3 text-center">
                        <div class="position-relative d-inline-block image-upload-wrapper w-100">
                            <!-- Default Upload Button UI -->
                            <label class="d-flex align-items-center justify-content-center bg-light w-100 p-2 rounded border image-upload-label" style="height: 5rem; cursor: pointer; border-style: dashed !important;">
                                <svg class="text-secondary opacity-50" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <input type="file" class="d-none image-input" accept="image/png,image/jpeg,image/jpg" name="products[${currIdx}][descriptions][0][image]">
                            </label>
                            
                            <!-- Image Preview UI (Hidden initially) -->
                            <div class="image-preview d-none position-relative mx-auto w-100 h-100">
                                <img class="object-fit-cover rounded border bg-white p-1" style="width: 5rem; height: 5rem;">
                                <button type="button" class="btn btn-light text-danger position-absolute p-1 rounded-circle shadow border delete-img-btn" style="bottom: -8px; right: 2rem; line-height: 1;" title="Hapus Gambar">
                                    <svg style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="p-3 text-center align-middle">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <button type="button" class="btn btn-outline-danger p-2 border-0 delete-desc-btn d-none" data-prodidx="${currIdx}" title="Hapus Deskripsi">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <button type="button" class="btn btn-success p-2 add-desc-btn shadow-sm" data-prodidx="${currIdx}" title="Tambah Deskripsi">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </td>
                    <td class="p-3 align-middle text-center border-0" rowspan="1">
                        <button type="button" class="btn btn-outline-danger rounded-circle p-2 shadow-sm border remove-product-btn" title="Hapus Produk">
                            <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        `;

        $('#productTable').append(rowHtml);

        renumber();
        updateDescButtons($('#productTable tbody').last());
        checkProductLimit();

        if ($('.product-group').length === MAX_PRODUCTS) {
            setTimeout(() => alert("Anda Sudah Mencapai Maksimum Input"), 100);
        }
    });

    // Event Delegation for dynamically added elements
    $('#productTable').on('click', '.remove-product-btn', function () {
        $(this).closest('.product-group').remove();
        renumber();
        checkProductLimit();
    });

    $('#productTable').on('click', '.add-desc-btn', function () {
        const btn = $(this);
        const prodIdx = btn.data('prodidx');
        const tbody = btn.closest('.product-group');
        const descRows = tbody.find('.desc-row');

        if (descRows.length >= MAX_DESC) {
            alert("Anda Sudah Mencapai Maksimum Input");
            return;
        }

        const descCount = Date.now();

        const newRowHtml = `
            <tr class="desc-row">
                <td class="p-3">
                    <input class="form-control" name="products[${prodIdx}][descriptions][${descCount}][text]" placeholder="Ketik deskripsi produk" required>
                </td>
                <td class="p-3 text-center">
                    <div class="position-relative d-inline-block image-upload-wrapper w-100">
                        <!-- Default Upload Button UI -->
                        <label class="d-flex align-items-center justify-content-center bg-light w-100 p-2 rounded border image-upload-label" style="height: 5rem; cursor: pointer; border-style: dashed !important;">
                            <svg class="text-secondary opacity-50" style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            <input type="file" class="d-none image-input" accept="image/png,image/jpeg,image/jpg" name="products[${prodIdx}][descriptions][${descCount}][image]">
                        </label>
                        
                        <!-- Image Preview UI -->
                        <div class="image-preview d-none position-relative mx-auto w-100 h-100">
                            <img class="object-fit-cover rounded border bg-white p-1" style="width: 5rem; height: 5rem;">
                            <button type="button" class="btn btn-light text-danger position-absolute p-1 rounded-circle shadow border delete-img-btn" style="bottom: -8px; right: 2rem; line-height: 1;" title="Hapus Gambar">
                                <svg style="width: 1rem; height: 1rem;" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                            </button>
                        </div>
                    </div>
                </td>
                <td class="p-3 text-center align-middle">
                    <div class="d-flex align-items-center justify-content-center gap-2">
                        <button type="button" class="btn btn-outline-danger p-2 border-0 delete-desc-btn" data-prodidx="${prodIdx}" title="Hapus Deskripsi">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        <button type="button" class="btn btn-success p-2 add-desc-btn shadow-sm" data-prodidx="${prodIdx}" title="Tambah Deskripsi">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </td>
            </tr>
        `;

        tbody.append(newRowHtml);

        const newLength = descRows.length + 1;
        tbody.find('.product-number').attr("rowspan", newLength);
        tbody.find('td[rowspan]').not('.product-number').attr("rowspan", newLength);

        updateDescButtons(tbody);

        if (newLength === MAX_DESC) {
            setTimeout(() => alert("Anda Sudah Mencapai Maksimum Input"), 100);
        }
    });

    $('#productTable').on('click', '.delete-desc-btn', function () {
        const btn = $(this);
        const tbody = btn.closest('.product-group');
        const descRows = tbody.find('.desc-row');

        if (descRows.length <= 1) {
            alert("Minimal harus ada 1 deskripsi.");
            return;
        }

        const rowToRemove = btn.closest('.desc-row');

        if (tbody.children().first()[0] === rowToRemove[0]) {
            const nextRow = rowToRemove.next();
            const noCell = rowToRemove.find('.product-number');
            const nameCell = noCell.next();
            const actionCell = rowToRemove.children().last();

            nextRow.prepend(nameCell);
            nextRow.prepend(noCell);
            nextRow.append(actionCell);
        }

        rowToRemove.remove();

        const newLength = descRows.length - 1;
        tbody.find('.product-number').attr("rowspan", newLength);
        tbody.find('td[rowspan]').not('.product-number').attr("rowspan", newLength);

        updateDescButtons(tbody);
    });

    $('#productTable').on('change', '.image-input', function () {
        const input = this;
        const file = input.files[0];
        const container = $(input).closest('.image-upload-wrapper');
        const label = container.find('.image-upload-label');
        const preview = container.find('.image-preview');
        const img = preview.find('img');

        if (file) {
            if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                alert('File harus berupa JPG, JPEG, atau PNG');
                $(input).val('');
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                img.attr('src', e.target.result);
                label.addClass('d-none');
                preview.removeClass('d-none').addClass('d-flex');
            }
            reader.readAsDataURL(file);
        }
    });

    $('#productTable').on('click', '.delete-img-btn', function () {
        const btn = $(this);
        const container = btn.closest('.image-upload-wrapper');
        imageToDeleteInput = container.find('input[type="file"]');
        imagePreviewToHide = container;

        $('#deleteModal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function () {
        if (imageToDeleteInput) {
            imageToDeleteInput.val('');
        }

        if (imagePreviewToHide) {
            const label = imagePreviewToHide.find('.image-upload-label');
            const preview = imagePreviewToHide.find('.image-preview');
            preview.addClass('d-none').removeClass('d-flex');
            label.removeClass('d-none');
        }

        $('#deleteModal').modal('hide');
        imageToDeleteInput = null;
        imagePreviewToHide = null;
    });

    // Populate initial products numbering
    renumber();
});

function checkProductLimit() {
    const groups = $('.product-group');
    const btn = $('#addProductBtn');

    if (btn.length) {
        if (groups.length >= MAX_PRODUCTS) {
            btn.addClass('d-none');
        } else {
            btn.removeClass('d-none');
        }
    }
}

function renumber() {
    $('.product-number').each(function (i) {
        $(this).text((i + 1) + ".");
    });
}

function updateDescButtons(tbody) {
    const rows = $(tbody).find('.desc-row');
    rows.each(function (i) {
        const addBtn = $(this).find('.add-desc-btn');
        const delBtn = $(this).find('.delete-desc-btn');

        if (rows.length >= MAX_DESC) {
            addBtn.addClass('d-none');
        } else {
            if (i === rows.length - 1) {
                addBtn.removeClass('d-none');
            } else {
                addBtn.addClass('d-none');
            }
        }

        if (rows.length <= 1) {
            delBtn.addClass('d-none');
        } else {
            delBtn.removeClass('d-none');
        }
    });
}