@props(['product'])

@if ($product->descriptions->isNotEmpty())
    @foreach ($product->descriptions as $index => $desc)
        <tr class="desc-row">
            @if ($index === 0)
                <td class="p-3 text-center product-number align-middle fw-bold text-secondary fs-5"
                    rowspan="{{ $product->descriptions->count() }}"></td>
                <td class="p-3 align-middle text-dark fw-bold" rowspan="{{ $product->descriptions->count() }}">{{ $product->name }}
                </td>
            @endif

            <td class="p-3 text-secondary align-middle">{{ $desc->description }}</td>
            <td class="p-3 text-center align-middle">
                @if ($desc->image)
                    <img src="{{ asset('storage/' . $desc->image) }}"
                        class="object-fit-cover mx-auto rounded shadow-sm border bg-white p-1" style="width: 5rem; height: 5rem;">
                @else
                    <span class="text-secondary opacity-50 small fst-italic">-</span>
                @endif
            </td>
            <td class="p-3 text-center align-middle">
                <span class="text-secondary opacity-25">-</span>
            </td>

            @if ($index === 0)
                <td class="p-3 align-middle text-center border-0" rowspan="{{ $product->descriptions->count() }}">
                    <button type="button" class="btn btn-outline-danger rounded-circle p-2 shadow-sm border delete-db-product-btn"
                        data-product-id="{{ $product->id }}" title="Permanently Delete Product from Database">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </td>
            @endif
        </tr>
    @endforeach
@else
    <tr class="desc-row">
        <td class="p-3 text-center product-number align-middle fw-bold text-secondary fs-5" rowspan="1"></td>
        <td class="p-3 align-middle text-dark fw-bold" rowspan="1">{{ $product->name }}</td>
        <td class="p-3 text-secondary opacity-50 fst-italic align-middle">-</td>
        <td class="p-3 text-center text-secondary opacity-50 fst-italic align-middle">-</td>
        <td class="p-3 text-center align-middle"><span class="text-secondary opacity-25">-</span></td>
        <td class="p-3 align-middle text-center border-0" rowspan="1">
            <button type="button" class="btn btn-outline-danger rounded-circle p-2 shadow-sm border delete-db-product-btn"
                data-product-id="{{ $product->id }}" title="Permanently Delete Product from Database">
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </button>
        </td>
    </tr>
@endif