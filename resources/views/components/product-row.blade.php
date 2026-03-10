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
                <td class="p-3 align-top text-center border-0" rowspan="{{ $product->descriptions->count() }}">
                    <span class="text-secondary opacity-25 d-inline-block mt-2" title="Produk statis (Database)">
                        <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </span>
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
            <span class="text-secondary opacity-25" title="Produk statis (Database)">
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </span>
        </td>
    </tr>
@endif