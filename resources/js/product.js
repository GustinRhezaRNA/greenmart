let productIndex = Date.now();
const MAX_PRODUCTS = 5;
const MAX_DESC = 3;

document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById("productTable");
    const addProductBtn = document.getElementById("addProductBtn");

    checkProductLimit();

    if (addProductBtn) {
        addProductBtn.addEventListener("click", () => {
            const groups = document.querySelectorAll(".product-group");
            if (groups.length >= MAX_PRODUCTS) {
                alert("Anda Sudah Mencapai Maksimum Input");
                return;
            }

            productIndex++;
            const currIdx = productIndex;

            const tbody = document.createElement("tbody");
            tbody.classList.add("product-group", "bg-white", "hover:bg-gray-50", "transition-colors", "border-b", "border-gray-200");

            const row = document.createElement("tr");
            row.classList.add("desc-row");

            row.innerHTML = `
                <td class="border-r border-b p-4 text-center align-middle font-bold text-gray-700 text-lg product-number" rowspan="1"></td>
                <td class="border-r border-b p-4 align-middle" rowspan="1">
                    <input class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 shadow-sm p-2.5 bg-gray-50 form-input transition-all" name="products[${currIdx}][name]" placeholder="Ketik nama produk" required>
                </td>
                <td class="border-r border-b p-4">
                    <input class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 shadow-sm p-2.5 bg-gray-50 form-input transition-all" name="products[${currIdx}][descriptions][0][text]" placeholder="Ketik deskripsi produk" required>
                </td>
                <td class="border-r border-b p-4 text-center">
                    <div class="relative inline-block">
                        <!-- Default Upload Button UI (Only this is visible initially) -->
                        <label class="cursor-pointer flex items-center justify-center bg-gray-100 hover:bg-gray-200 w-full h-full p-2 transition-all image-upload-label group rounded-md">
                            <svg class="w-6 h-6 text-gray-700 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            <input type="file" class="hidden image-input" accept="image/png,image/jpeg,image/jpg" name="products[${currIdx}][descriptions][0][image]" onchange="previewImage(this)">
                        </label>
                        
                        <!-- Image Preview UI (Hidden initially) -->
                        <div class="image-preview hidden relative mx-auto">
                            <img class="w-20 h-20 object-cover rounded-md border border-gray-200 shadow-sm bg-white p-1">
                            <button type="button" class="absolute -bottom-2 -right-2 bg-white text-gray-800 hover:text-red-500 p-1.5 rounded-full shadow-md border hover:bg-red-50 hover:border-red-200 transition-all" onclick="triggerDeleteImage(this)" title="Hapus Gambar">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                            </button>
                        </div>
                    </div>
                </td>
                <td class="border-r border-b p-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <button type="button" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg transition-all delete-desc-btn hidden" onclick="removeDescription(this, ${currIdx})" title="Hapus Deskripsi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        <button type="button" class="text-green-600 hover:text-white bg-green-100 hover:bg-green-600 p-2 rounded-lg transition-all font-bold shadow-sm add-desc-btn" onclick="addDescription(this, ${currIdx})" title="Tambah Deskripsi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </td>
                <td class="border-0 p-4 align-middle text-center" rowspan="1">
                    <button type="button" class="text-gray-400 hover:text-red-600 bg-white p-2.5 rounded-full shadow-sm border border-gray-200 hover:shadow-md hover:border-red-200 hover:bg-red-50 transition-all" onclick="removeProduct(this)" title="Hapus Produk">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </td>
            `;

            tbody.appendChild(row);

            // map inserting to marker
            const marker = document.getElementById("dynamicTableBodyMarker");
            if (marker) {
                table.insertBefore(tbody, marker);
            } else {
                table.appendChild(tbody);
            }

            renumber();
            updateDescButtons(tbody);
            checkProductLimit();

            const newTotal = document.querySelectorAll(".product-group").length;
            if (newTotal === MAX_PRODUCTS) {
                setTimeout(() => alert("Anda Sudah Mencapai Maksimum Input"), 100);
            }
        });
    }
});

function checkProductLimit() {
    const groups = document.querySelectorAll(".product-group");
    const btn = document.getElementById("addProductBtn");
    if (!btn) return;

    if (groups.length >= MAX_PRODUCTS) {
        btn.classList.add("hidden");
    } else {
        btn.classList.remove("hidden");
    }
}

function removeProduct(btn) {
    btn.closest(".product-group").remove();
    renumber();
    checkProductLimit();
}

function renumber() {
    document.querySelectorAll(".product-number").forEach((el, i) => {
        el.innerText = i + 1 + ".";
    });
}

function addDescription(btn, prodIdx) {
    const tbody = btn.closest(".product-group");
    const descRows = tbody.querySelectorAll(".desc-row");

    if (descRows.length >= MAX_DESC) {
        alert("Anda Sudah Mencapai Maksimum Input");
        return;
    }

    const descCount = Date.now();

    const newRow = document.createElement("tr");
    newRow.classList.add("desc-row");
    newRow.innerHTML = `
        <td class="border-r border-b p-4">
            <input class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500 shadow-sm p-2.5 bg-gray-50 form-input transition-all" name="products[${prodIdx}][descriptions][${descCount}][text]" placeholder="Ketik deskripsi produk" required>
        </td>
        <td class="border-r border-b p-4 text-center">
            <div class="relative inline-block">
                <!-- Default Upload Button UI (Only this is visible initially) -->
                <label class="cursor-pointer flex items-center justify-center bg-gray-100 hover:bg-gray-200 w-full h-full p-2 transition-all image-upload-label group rounded-md">
                    <svg class="w-6 h-6 text-gray-700 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <input type="file" class="hidden image-input" accept="image/png,image/jpeg,image/jpg" name="products[${prodIdx}][descriptions][${descCount}][image]" onchange="previewImage(this)">
                </label>
                
                <!-- Image Preview UI (Hidden initially) -->
                <div class="image-preview hidden relative mx-auto">
                    <img class="w-20 h-20 object-cover rounded-md border border-gray-200 shadow-sm bg-white p-1">
                    <button type="button" class="absolute -bottom-2 -right-2 bg-white text-gray-800 hover:text-red-500 p-1.5 rounded-full shadow-md border hover:bg-red-50 hover:border-red-200 transition-all" onclick="triggerDeleteImage(this)" title="Hapus Gambar">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                    </button>
                </div>
            </div>
        </td>
        <td class="border-r border-b p-4 text-center">
            <div class="flex items-center justify-center gap-2">
                <button type="button" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg transition-all delete-desc-btn" onclick="removeDescription(this, ${prodIdx})" title="Hapus Deskripsi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <button type="button" class="text-green-600 hover:text-white bg-green-100 hover:bg-green-600 p-2 rounded-lg transition-all font-bold shadow-sm add-desc-btn" onclick="addDescription(this, ${prodIdx})" title="Tambah Deskripsi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </button>
            </div>
        </td>
    `;

    tbody.appendChild(newRow);

    const newLength = descRows.length + 1;
    tbody.querySelector(".product-number").setAttribute("rowspan", newLength);
    tbody.querySelectorAll("td[rowspan]").forEach(td => {
        if (!td.classList.contains("product-number")) {
            td.setAttribute("rowspan", newLength);
        }
    });

    updateDescButtons(tbody);

    if (newLength === MAX_DESC) {
        setTimeout(() => alert("Anda Sudah Mencapai Maksimum Input"), 100);
    }
}

function removeDescription(btn, prodIdx) {
    const tbody = btn.closest(".product-group");
    const descRows = tbody.querySelectorAll(".desc-row");

    if (descRows.length <= 1) {
        alert("Minimal harus ada 1 deskripsi.");
        return;
    }

    const rowToRemove = btn.closest(".desc-row");

    if (tbody.firstElementChild === rowToRemove) {
        const nextRow = rowToRemove.nextElementSibling;
        const noCell = rowToRemove.querySelector(".product-number");
        const nameCell = noCell.nextElementSibling;
        const actionCell = rowToRemove.lastElementChild;

        nextRow.insertBefore(nameCell, nextRow.firstElementChild);
        nextRow.insertBefore(noCell, nameCell);
        nextRow.appendChild(actionCell);
    }

    rowToRemove.remove();

    const newLength = descRows.length - 1;
    tbody.querySelector(".product-number").setAttribute("rowspan", newLength);
    tbody.querySelectorAll("td[rowspan]").forEach(td => {
        if (!td.classList.contains("product-number")) {
            td.setAttribute("rowspan", newLength);
        }
    });

    updateDescButtons(tbody);
}

function updateDescButtons(tbody) {
    const rows = tbody.querySelectorAll(".desc-row");
    rows.forEach((row, i) => {
        const addBtn = row.querySelector(".add-desc-btn");
        const delBtn = row.querySelector(".delete-desc-btn");

        if (rows.length >= MAX_DESC) {
            addBtn.classList.add("hidden");
        } else {
            if (i === rows.length - 1) {
                addBtn.classList.remove("hidden");
            } else {
                addBtn.classList.add("hidden");
            }
        }

        if (rows.length <= 1) {
            delBtn.classList.add("hidden");
        } else {
            delBtn.classList.remove("hidden");
        }
    });
}

let imageToDeleteInput = null;
let imagePreviewToHide = null;

window.previewImage = function (input) {
    const file = input.files[0];
    const container = input.closest('td');
    const label = container.querySelector('.image-upload-label');
    const preview = container.querySelector('.image-preview');
    const img = preview.querySelector('img');

    if (file) {
        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
            alert('File harus berupa JPG, JPEG, atau PNG');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            label.classList.add('hidden');
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

window.triggerDeleteImage = function (btn) {
    const container = btn.closest('td');
    imageToDeleteInput = container.querySelector('input[type="file"]');
    imagePreviewToHide = container;

    // update delete text conditionally? no need, just standard popup
    document.getElementById('deleteModal').classList.remove('hidden');
}

window.closeModal = function () {
    document.getElementById('deleteModal').classList.add('hidden');
    imageToDeleteInput = null;
    imagePreviewToHide = null;
}

window.confirmDeleteImage = function () {
    if (imageToDeleteInput) {
        imageToDeleteInput.value = '';
    }

    if (imagePreviewToHide) {
        const label = imagePreviewToHide.querySelector('.image-upload-label');
        const preview = imagePreviewToHide.querySelector('.image-preview');
        preview.classList.add('hidden');
        label.classList.remove('hidden');
    }

    closeModal();
}

window.addProduct = function () { document.getElementById('addProductBtn').click(); };
window.removeProduct = removeProduct;
window.renumber = renumber;
window.addDescription = addDescription;
window.removeDescription = removeDescription;