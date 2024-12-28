<x-app-layout title="Sewa" bodyClass="bg-tertiery3 w-full items-center overflow-hidden max-h-screen">
    <div class="flex w-full px-10 h-screen overflow-hidden">
        {{-- Main Content --}}
        <div class="bg-white my-8 rounded-3xl drop-shadow-md w-full flex flex-col gap-5">

            {{-- Card Item --}}
            <div class="flex flex-shrink flex-wrap w-full gap-5 overflow-auto py-4 justify-center">
                    {{-- <x-card
                        :image="asset($product->images->isNotEmpty() ? 'storage/' . $product->images->first()->file_path : 'images/produk-icon-dummy.png')"
                        :title="$product->name"
                        :description="$product->teaser"
                        :price="$product->price"
                        :category="$product->category->category_name ?? 'Tidak Ada Kategori'"
                    /> --}}
                    <a href="{{ route('products.show', $product->id) }}" class="card bg-white w-full md:w-80 xl:w-1/3 2xl:w-96 max-xl: h-auto shadow-lg drop-shadow cursor-pointer hover:scale-90 transition group">
                        <figure>
                            @if ($product->images->isNotEmpty())
                            <div class="h-24 w-24">
                                <img src="{{ asset('storage/' . $product->images->first()->file_path) }}" alt="Product Image" class="w-full h-full object-cover"/>
                            </div>
                            @else
                                <div class="lg:h-48 lg:w-62">
                                    <img
                                        src="{{ asset('images/produk-icon-dummy.png') }}"
                                        alt="Shoes"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            @endif
                        </figure>
                        <div class="card-body text-tertiery1">
                            <h2 class="card-title lg:text-base">{{ $product->name }}</h2>
                            <p class="lg:text-sm 2xl:text-base">{{ $product->teaser }}</p>
                            <div class="flex space-x-1 lg:text-xl 2xl:text-3xl">
                                <button type="button" class="text-yellow-500 "
                                    id="star1">&#9733;</button>
                                <button type="button" class="text-yellow-500 "
                                    id="star2">&#9733;</button>
                                <button type="button" class="text-yellow-500 "
                                    id="star3">&#9733;</button>
                                <button type="button" class="text-yellow-500 "
                                    id="star4">&#9733;</button>
                                <button type="button" class="text-yellow-500 "
                                    id="star5">&#9733;</button>
                            </div>
                            <div class="flex flex-col items-end gap-2 mt-2">
                                <span class="font-medium lg:text-lg 2xl:text-2xl">
                                    Rp. {{ number_format($product->price ?? 0, 2, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </a>
            </div>
            {{-- Card Item End--}}

        </div>
        {{-- Main Content End--}}

    </div>
</x-app-layout>
