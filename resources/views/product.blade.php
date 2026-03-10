<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenMart Product</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .form-input:focus { outline: none; }
    </style>
</head>
<body class="bg-gray-50 p-6 md:p-10 font-sans text-gray-800 tracking-tight">

    <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl border border-gray-100 overflow-hidden">
        
        <div class="bg-green-600 p-6 text-white flex justify-between items-center shadow-inner">
            <h1 class="text-2xl font-bold tracking-wide">GreenMart Product Entry</h1>
            <svg class="w-8 h-8 opacity-90 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
        </div>

        <form method="POST" action="/products" enctype="multipart/form-data" class="p-8">
            @csrf
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-3 font-medium">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    <ul class="list-disc ml-5 text-sm font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="w-full border-collapse bg-white" id="productTable">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider border-b-2 border-gray-200">
                            <th class="p-4 border-r font-bold w-16 text-center">No</th>
                            <th class="p-4 border-r font-bold w-1/4 text-center">Produk</th>
                            <th class="p-4 border-r font-bold text-center">Deskripsi Produk</th>
                            <th class="p-4 border-r font-bold w-56 text-center">Gambar Produk</th>
                            <th class="p-4 border-r font-bold w-32 text-center">Aksi</th>
                            <th class="p-4 bg-gray-50 border-transparent w-16"></th>
                        </tr>
                    </thead>
                    
                    @if(isset($products) && $products->isNotEmpty())
                        @foreach ($products as $product)
                            <tbody class="product-group existing-product bg-white hover:bg-gray-50 transition-colors border-b">
                                @if ($product->descriptions->isNotEmpty())
                                    @foreach ($product->descriptions as $index => $desc)
                                        <tr class="desc-row">
                                            @if ($index === 0)
                                                <td class="border-r border-b p-4 text-center product-number align-middle font-bold text-gray-700 text-lg" rowspan="{{ $product->descriptions->count() }}"></td>
                                                <td class="border-r border-b p-4 align-middle text-gray-800 font-semibold" rowspan="{{ $product->descriptions->count() }}">{{ $product->name }}</td>
                                            @endif
                                            
                                            <td class="border-r border-b p-4 text-gray-600 font-medium">{{ $desc->description }}</td>
                                            <td class="border-r border-b p-4 text-center">
                                                @if ($desc->image)
                                                    <img src="{{ asset('storage/' . $desc->image) }}" class="w-20 h-20 object-cover mx-auto rounded-md shadow-sm border border-gray-200 bg-white p-0.5">
                                                @else
                                                    <span class="text-gray-400 text-sm font-medium italic">-</span>
                                                @endif
                                            </td>
                                            <td class="border-r border-b p-4 text-center">
                                                <span class="text-gray-300">-</span>
                                            </td>
                                            
                                            @if ($index === 0)
                                                <td class="border-0 p-4 align-top text-center" rowspan="{{ $product->descriptions->count() }}">
                                                    <span class="text-gray-300 inline-block mt-2" title="Produk statis (Database)">
                                                        <svg class="w-6 h-6 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                    </span>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="desc-row">
                                        <td class="border-r border-b p-4 text-center product-number align-middle font-bold text-gray-700 text-lg" rowspan="1"></td>
                                        <td class="border-r border-b p-4 align-middle text-gray-800 font-semibold" rowspan="1">{{ $product->name }}</td>
                                        <td class="border-r border-b p-4 text-gray-400 font-medium italic">-</td>
                                        <td class="border-r border-b p-4 text-center text-gray-400 font-medium italic">-</td>
                                        <td class="border-r border-b p-4 text-center"><span class="text-gray-300">-</span></td>
                                        <td class="border-0 p-4 align-middle text-center" rowspan="1">
                                            <span class="text-gray-300" title="Produk statis (Database)">
                                                <svg class="w-6 h-6 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        @endforeach
                    @endif
                </table>
            </div>

            <div class="mt-8 flex items-center gap-4 justify-between pt-2">
                <button type="button" id="addProductBtn" class="flex items-center gap-2 bg-white border-2 border-green-600 text-green-700 hover:bg-green-50 px-6 py-2.5 rounded-lg font-bold transition-all shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Produk
                </button>

                <button type="submit" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg font-bold transition-all shadow-md shadow-blue-200">
                    Submit Data
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Custom Delete UI Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900/60 hidden flex items-center justify-center z-50 transition-opacity backdrop-blur-sm">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4 shadow-2xl transform transition-transform scale-100 border border-gray-100">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">Konfirmasi Penghapusan</h3>
            <p class="text-gray-500 text-center mb-8 font-medium">Apakah Anda yakin untuk menghapus gambar ini?</p>
            
            <div class="flex gap-4 mt-2">
                <button type="button" onclick="closeModal()" class="flex-1 w-full px-4 py-3 rounded-lg text-white font-bold transition-all shadow-sm hover:shadow-md hover:scale-[1.02]" style="background-color: #808080">
                    Batalkan
                </button>
                <button type="button" onclick="confirmDeleteImage()" class="flex-1 w-full px-4 py-3 rounded-lg text-white font-bold transition-all shadow-sm hover:shadow-md hover:scale-[1.02]" style="background-color: #D22B2B">
                    Hapus
                </button>
            </div>
        </div>
    </div>

</body>
</html>