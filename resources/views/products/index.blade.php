<x-app-layout title="Sewa" bodyClass="bg-tertiery3 w-full items-center overflow-hidden max-h-screen">
    <div class="flex w-full px-10 h-screen overflow-hidden">

        {{-- Sidebar Component --}}
        <div class="bg-white mr-8 my-8 rounded-3xl drop-shadow-md py-8 px-6 max-w-sm">

            {{-- Search Bar --}}
            <form action="{{ route('products.index') }}" method="GET">
                <label class="border py-2.5 px-4 rounded-lg border-tertiery1 flex items-center gap-2 hover:cursor-text text-tertiery1 group">
                    <input class="w-full focus:outline-none group/Focus:" name="search" value="{{ request('search') }}" placeholder="Search" />
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 16 16"
                        fill="currentColor"
                        class="h-6 w-6 opacity-50 group-hover:opacity-100 transition">
                        <path
                        fill-rule="evenodd"
                        d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                        clip-rule="evenodd" />
                    </svg>
                </label>
            </form>
            {{-- Search Bar End--}}

            {{-- Kategori Bar --}}
            <div class="flex flex-col items-center mt-8 gap-5">
                <h1 class="text-tertiery1 font-medium text-2xl">Kategori</h1>
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    @foreach ($categories as $category)
                        <x-button variant="secondary"  class="px-3 text-sm">{{ $category->category_name }}</x-button>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col items-center mt-8 gap-5">
                <h1 class="text-tertiery1 font-medium text-2xl">Urutkan Berdasarkan</h1>
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    @foreach ($filters as $filter)
                        <x-button variant="secondary"  class="px-3 text-sm">{{ $filter }}</x-button>
                    @endforeach
                </div>
            </div>
            {{-- Kategori Bar End--}}

        </div>
        {{-- Sidebar Component End --}}

        {{-- Main Content --}}
        <div class="bg-white my-8 rounded-3xl drop-shadow-md w-full flex flex-col gap-5">

            {{-- Pagination --}}
            <div class="border-b px-14 py-4">
                    {{ $products->appends(request()->query())->links('pagination::custom-pagination') }}
            </div>
            {{-- Pagination End--}}

            {{-- Card Item --}}
            <div class="grid grid-cols-3 gap-5 overflow-auto py-4 px-8 justify-items-center">
                @foreach ( $products as $product)
                    <div class="card bg-base-100 w-96 shadow-lg cursor-pointer hover:scale-90 transition group">
                        <figure>
                            @if ($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->file_path) }}" alt="Product Image" />
                            @else
                                <img
                                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                                    alt="Shoes"
                                />
                            @endif
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">{{ $product->name }}</h2>
                            <p>{{ $product->teaser }}</p>
                            <div class="flex space-x-1">
                                <button type="button" class="text-yellow-500 text-3xl"
                                    id="star1">&#9733;</button>
                                <button type="button" class="text-yellow-500 text-3xl"
                                    id="star2">&#9733;</button>
                                <button type="button" class="text-yellow-500 text-3xl"
                                    id="star3">&#9733;</button>
                                <button type="button" class="text-yellow-500 text-3xl"
                                    id="star4">&#9733;</button>
                                <button type="button" class="text-yellow-500 text-3xl"
                                    id="star5">&#9733;</button>
                            </div>
                            <div class="card-actions w-full items-center justify-between ">
                                <button class="w-full py-2 rounded-xl border border-secondary3 text-secondary3 group-hover:text-bg3 group-hover:bg-secondary3 transition">
                                    <span class="font-medium text-2xl">Rp. {{ number_format($product->price, 2, ',', '.') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- Card Item End--}}

        </div>
        {{-- Main Content End--}}

    </div>
</x-app-layout>
