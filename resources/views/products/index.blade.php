<x-app-layout title="Sewa" bodyClass="bg-tertiery3 w-full items-center lg:overflow-hidden max-h-full lg:max-h-screen">
    <div class="flex flex-col lg:flex-row w-full mt-[100px] md:mt-4 lg:mt-0 px-4 lg:px-10 min-h-screen lg:min-h-full lg:h-screen lg:overflow-hidden">

        {{-- Sidebar Component --}}
        <div class="bg-white mr-0 lg:mr-8 lg:my-8 rounded-2xl drop-shadow-md py-8 px-6 lg:max-w-sm w-full">

            {{-- Search Bar --}}
            <form action="{{ route('products.index') }}" method="GET">
                <label class="border py-2.5 px-4 rounded-lg border-tertiery1 flex items-center gap-2 hover:cursor-text text-tertiery1 group">
                    <input @keydown.enter="Alpine.store('loadingState').showLoading();" class="w-full focus:outline-none group/Focus:" name="search" value="{{ request('search') }}" placeholder="Search" />
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="h-6 w-6 opacity-50 group-hover:opacity-100 transition">
                        <path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" />
                    </svg>
                </label>
            </form>
            {{-- Search Bar End --}}
            @auth
                @if (Auth::check() && Auth::user()->role == 'admin')
                    <a href="{{ route('products.create') }}">
                        <x-button variant='secondary' class="w-full px-2 mt-2 flex flex-row justify-between">
                            <div>Add Item</div>
                            <div>+</div>
                        </x-button>
                    </a>
                    <form action="{{ route('admin.hargasewa.update') }}" method="POST" class="mt-4">
                        @csrf
                        @method('PATCH')
                        <label for="" class=" text-sm w-full flex flex-col mb-1.5">Rental Price of All Products <span class="text-xs text-slate-400">Please press enter to edit</span></label>
                        <x-input-text type="text" name="harga_sewa" value="{{ $rules->harga_sewa }}"
                            class=""
                        />
                    </form>
                @endif
            @endauth


            {{-- Kategori Bar --}}
            <div class="hidden md:flex flex-col items-center mt-5 gap-5">
                <h1 class="text-tertiery1 font-medium text-2xl">Category</h1>
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    @foreach ($categories as $category)
                        @php
                        // Ambil query tanpa parameter 'page'
                        $query = array_filter(request()->query(), fn($key) => $key !== 'page', ARRAY_FILTER_USE_KEY);
                        $selectedCategories = (array) request('category', []);
                        $isSelected = in_array($category->id, $selectedCategories);
                        $newCategories = $isSelected ? array_diff($selectedCategories, [$category->id]) : array_merge($selectedCategories, [$category->id]);
                        $query['category'] = $newCategories;
                        @endphp

                        <a href="{{ route('products.index', $query) }}" @click="Alpine.store('loadingState').showLoading();">
                            <button class="px-3 text-sm p-2 rounded-lg {{ $isSelected ? 'bg-tertiery3 text-secondary3' : 'bg-secondary3 text-bg3 hover:bg-tertiery3 hover:text-secondary3' }}">
                                {{ $category->category_name }}
                            </button>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col items-center mt-8 gap-5">
                <h1 class="hidden md:block text-tertiery1 font-medium text-2xl">Sort By</h1>
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    @foreach ($filters as $filter)
                        <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => $filter])) }}" @click="Alpine.store('loadingState').showLoading();">
                            <button class="px-3 text-sm p-2 rounded-lg {{ request('sort') == $filter ? 'bg-tertiery3 text-secondary3' : 'bg-secondary3 text-bg3 hover:bg-tertiery3 hover:text-secondary3' }}">
                                {{ $filter }}
                            </button>
                        </a>
                    @endforeach
                </div>
            </div>
            {{-- Kategori Bar End --}}

        </div>
        {{-- Sidebar Component End --}}

        {{-- Main Content --}}
        <div class="lg:bg-white my-4 lg:my-8 rounded-2xl drop-shadow-md w-full flex flex-col lg:gap-5">

            {{-- Pagination --}}
            <div class="bg-white rounded-2xl border-b px-4 lg:px-14 py-4">
                {{ $products->appends(request()->query())->links('pagination::custom-pagination') }}
            </div>
            {{-- Pagination End --}}
            {{-- @dump($products) --}}
            {{-- Card Item --}}
            <div class="flex md:grid md:grid-cols-2 lg:flex flex-shrink flex-wrap w-full gap-5 overflow-auto py-4 justify-center">
                @foreach ($products as $product)
                    <a @click="Alpine.store('loadingState').showLoading();" href="{{ route('products.show', $product->id) }}" class="card bg-white w-full lg:w-80 xl:w-1/3 2xl:w-96 max-xl:h-auto shadow-lg drop-shadow cursor-pointer hover:scale-90 transition group">
                        <figure>
                            @if ($product->images->isNotEmpty())
                                <div class="h-48 h-62 pt-4 px-4">
                                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="Product Image" class="w-full h-full object-cover" />
                                </div>
                            @else
                                <div class="h-48 h-62 pt-4 px-4">
                                    <img src="{{ asset('images/produk-icon-dummy.png') }}" alt="Shoes" class="w-full h-full object-cover" />
                                </div>
                            @endif
                        </figure>
                        <div class="card-body text-tertiery1">
                            <h2 class="card-title lg:text-base">{{ $product->name }}</h2>
                            <p class="lg:text-sm 2xl:text-base">{{ Str::limit($product->teaser, 100, ' ...') }}</p>
                            <div class="flex items-center gap-2">
                                <div class="flex space-x-1 lg:text-xl 2xl:text-3xl">
                                    @php $averageRatingProduct = round($product->average_rating); @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $averageRatingProduct)
                                            <span class="text-yellow-500">&#9733;</span>
                                        @else
                                            <span class="text-gray-300">&#9733;</span>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-sm">{{ number_format($product->average_rating, 1) }}</span>
                            </div>
                            <div class="flex flex-col items-end gap-2 mt-2">
                                <span class="font-medium lg:text-lg 2xl:text-2xl">Rp. {{ number_format($product->price ?? 0, 2, ',', '.') }}</span>
                                <div class="card-actions justify-end">
                                    <div class="badge badge-outline 2xl:text-sm lg:text-xs">{{ $categories[$product->category_id - 1]->category_name }}</div>
                                    <div class="badge badge-outline 2xl:text-sm lg:text-xs {{ $product->stock > 0 ? 'text-green-400' : 'text-red-400' }}">
                                        @if ($product->stock > 0)
                                            Ready
                                        @else
                                            Out of Stock
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if (auth()->user() && (auth()->user()->role == "admin"))
                                <div class="w-full flex gap-2">
                                    <form action="{{ route('products.edit', $product->id) }}" class="w-full">
                                        @csrf
                                        <x-button type="submit" variant="secondary" class="w-full">Edit</x-button>
                                    </form>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="danger" class="w-full">Delete</x-button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            {{-- Card Item End --}}
            <div class="block lg:hidden bg-white rounded-2xl border-b px-4 lg:px-14 py-4">
                {{ $products->appends(request()->query())->links('pagination::custom-pagination') }}
            </div>
        </div>
        {{-- Main Content End --}}

    </div>
    <x-slot name="scripts">
        <script>
            @if (session('delete'))
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "{{ session('delete') }}",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                });
            @endif
        </script>
    </x-slot>
</x-app-layout>
