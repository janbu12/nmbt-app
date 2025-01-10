<x-app-layout title="Sewa" bodyClass="bg-tertiery3 w-full items-center min-h-screen text-tertiery1">
    <div class="w-full px-10 ">
        <div class="breadcrumbs text-sm text-tertiery1 mt-4">
            <ul>
                <li><a href="/products">NMBT</a></li>
                <li><a href="/products?category[0]={{ $product->category->id }}">{{ $product->category->category_name }}</a></li>
                <li>{{ $product->name }}</li>
            </ul>
        </div>
        {{-- Main Content --}}
        <div class="bg-white rounded mt-2 drop-shadow-md w-full mb-6">

            {{-- Product Content --}}
            <div class="flex gap-8 border-b p-10 flex-wrap justify-center lg:flex-nowrap">

                {{-- Carousel --}}
                <div class="w-full md:w-2/4">
                    <div class="relative w-full mx-auto">
                        <!-- Main Image -->
                        <div class="overflow-hidden rounded-lg">
                            <img id="main-image" src="{{ isset($product->images[0]) ? asset('storage/' . $product->images[0]->image_path) : asset('images/produk-icon-dummy.png') }}"
                                 alt="{{ $product->name }}"
                                 class="w-full aspect-square object-cover transition-all duration-300">
                        </div>

                        <!-- Controls -->
                        <div class="flex mt-4 gap-2 py-2 justify-center overflow-y-auto">
                            <button id="prev" class="bg-base-100 p-2 hidden lg:block rounded-md drop-shadow hover:bg-base-200">
                                &#8592;
                            </button>
                            <!-- Thumbnails -->
                            <div class="flex space-x-2 justify-center">
                                @if ($product->images->isNotEmpty())
                                    @foreach ($product->images as $image)
                                        <img
                                            id="images-{{ $loop->index }}"
                                            src="{{ asset('storage/' . $image->image_path) }}"
                                            alt="Thumbnail {{ $loop->index }}"
                                            class="thumbnail w-16 h-16 object-cover rounded-md cursor-pointer border-2 border-transparent hover:outline-none hover:ring-2 hover:ring-secondary3 transition-all">
                                    @endforeach
                                @else
                                    <img
                                        id="images-0"
                                        src="{{ asset('images/produk-icon-dummy.png') }}"
                                        alt="Thumbnail Dummy"
                                        class="thumbnail w-16 h-16 object-cover rounded-md cursor-pointer border-2 border-transparent hover:border-primary transition-all">
                                @endif
                            </div>
                            <button id="next" class="bg-base-100 p-2 hidden lg:block rounded-md drop-shadow hover:bg-base-200">
                                &#8594;
                            </button>
                        </div>
                    </div>
                </div>
                {{-- Carousel End --}}

                {{-- Description Content --}}
                <form class="w-full h-full" action="{{ route('product.cart', $product->id) }}" method="POST">
                    @csrf
                    <div class="text-3xl font-medium">
                        {{ $product->name }}
                    </div>
                    {{-- @dump($product->ratingsDistribution()) --}}
                    <div class="flex gap-3 mt-2 flex-wrap">
                        <div class="flex items-center gap-2">
                            <span class="border-b-2 w-full min-w-6 text-center">{{number_format($product->average_rating,1)}}</span>
                            <div class="flex space-x-1 lg:text-xl 2xl:text-3xl">
                                @php $averageRatingProduct = round($product->average_rating); @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $averageRatingProduct)
                                        <span class="text-xl text-yellow-500 }}">&#9733;</span>
                                    @else
                                        <span class="text-xl text-gray-300 }}">&#9733;</span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="border-b-2 w-full min-w-6 text-center">{{$product->reviews->count() }}</span>
                            <p>Reviews</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="border-b-2 w-full min-w-6 text-center">{{ $product->total_rented }}</span>
                            <p>Rent</p>
                        </div>
                    </div>
                    <div class="py-5 text-balance">
                        {{ $product->description }}
                    </div>
                    <div class="flex flex-wrap lg:flex-nowrap gap-4 justify-between text-secondary3">
                        <span class="font-medium text-3xl">
                            Rp. {{ number_format($product->price ?? 0, 2, ',', '.') }}
                        </span>
                        @if (auth()->user()->role != "admin")
                            <div class="flex items-center space-x-2 h-9 lg:h-auto">
                                <button type="button" id="decrease" class="bg-base-100 px-3 border border-secondary3 h-full rounded-md hover:bg-secondary3 hover:text-bg3 transition">
                                    -
                                </button>
                                <input
                                    id="quantity"
                                    name="quantity"
                                    type="text"
                                    value="1"
                                    class="w-10 h-full focus:outline-none text-center border border-secondary3 rounded-md"
                                    readonly
                                    >
                                <button type="button" id="increase" class="bg-base-100 px-3 rounded-md border border-secondary3 h-full hover:bg-secondary3 hover:text-bg3 transition">
                                    +
                                </button>
                            </div>
                        @else
                            <div class="flex gap-2">
                                <x-button variant="secondary" as="a" href="{{ route('products.edit', $product->id) }}">Edit</x-button>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger">Hapus</x-button>
                                </form>
                            </div>
                        @endif
                    </div>
                    @if (auth()->user()->role != "admin")
                        <div class="w-full flex justify-start md:justify-end mt-5">
                            <x-button type="submit" variant="secondary">Add To Cart</x-button>
                        </div>
                    @endif
                </form>
                {{-- Description Content End--}}

            </div>

            {{-- Review Sections --}}
            <div class="flex flex-col p-10" id="reviews-container">
                {{-- Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="text-3xl font-medium">Penilaian Produk</div>
                    <div class="text-sm text-gray-500">{{number_format($product->average_rating,1)}} dari 5</div>
                </div>

                {{-- Rating Summary --}}
                <div class="flex items-center flex-wrap gap-4 mb-6">
                    <div class="text-5xl font-bold text-yellow-500">{{number_format($product->average_rating,1)}}</div>
                    <div class="flex flex-col gap-2">
                        @foreach (range(5, 1) as $star)
                            @php
                                $rating = $product->ratingsDistribution()[$star] ?? ['percentage' => 0, 'count' => 0];
                                $formatedCount = $product->formatCountRating($rating['count']);
                            @endphp
                            <div class="flex items-center flex-wrap gap-2">
                                <span class="text-sm">{{ $star }} Bintang</span>
                                <progress
                                    class="progress progress-warning w-56"
                                    value="{{ $rating['percentage'] }}"
                                    max="100"
                                ></progress>
                                <span class="text-sm text-gray-500">({{ $formatedCount }})</span>
                            </div>
                        @endforeach
                    </div>
                </div>


                {{-- Review List --}}
                <div class="space-y-6">
                    <!-- Filter Rating -->
                    <div class="flex gap-4 mb-4">
                        <form action="{{ route('products.show', $product->id) }}" method="GET">
                            <div class="flex gap-2">
                                @foreach (range(1, 5) as $star)
                                    <button
                                        type="submit"
                                        name="rating"
                                        value="{{ $star }}"
                                        class="px-4 py-2 border rounded-lg {{ request()->get('rating') == $star ? 'bg-yellow-500 text-white' : 'bg-white text-gray-800'}} hover:bg-slate-100 hover:text-gray-800 transition">
                                        {{ $star }} Bintang
                                    </button>
                                @endforeach
                            </div>
                        </form>
                    </div>

                    <!-- Ulasan Produk -->
                    @foreach ($reviews as $review)
                        <div class="p-4 bg-gray-50 rounded-lg shadow-sm">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 bg-gray-200 rounded-full">
                                    <img src="{{ $review->user->imageUser ?? asset('images/boy.png') }}" alt="User Avatar" class="w-full h-full object-cover rounded-full">
                                </div>
                                <div>
                                    <div class="text-sm font-medium">{{ $review->user->lastname }}</div>
                                    <div class="text-xs text-gray-500">{{ $review->created_at }}</div>
                                    <div class="flex items-center gap-2">
                                        <div>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <span class="text-yellow-500 }}">&#9733;</span>
                                                @else
                                                    <span class="text-gray-300 }}">&#9733;</span>
                                                @endif
                                             @endfor
                                        </div>
                                        <span class="text-xs">{{ number_format($review->rating,1)  }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-sm">
                                <p>{{ $review->comment }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Main Content End --}}
    </div>

    <x-slot name="scripts">
        <script>
            const quantityInput = document.getElementById("quantity");
            const increaseBtn = document.getElementById("increase");
            const decreaseBtn = document.getElementById("decrease");


            increaseBtn.addEventListener("click", () => {
                const currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
            });

            decreaseBtn.addEventListener("click", () => {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            document.addEventListener("DOMContentLoaded", () => {
                const images = @json($product->images);
                const mainImage = document.getElementById("main-image");
                const thumbnails = document.querySelectorAll(".thumbnail");
                const prevBtn = document.getElementById("prev");
                const nextBtn = document.getElementById("next");
                const urlParams = new URLSearchParams(window.location.search);
                const ratingParam = urlParams.get('rating');

                let currentIndex = 0;

                // Update main image and active thumbnail
                const updateMainImage = (index) => {
                    mainImage.src = `{{ asset('storage/') }}/${images[index].image_path}`;

                    // Remove 'border-primary' class from all thumbnails
                    thumbnails.forEach((thumbnail) => thumbnail.classList.remove("ring-2"));

                    // Add 'border-primary' class to the active thumbnail
                    thumbnails[index].classList.add("ring-2","ring-secondary3");
                };

                // Add click event to thumbnails
                thumbnails.forEach((thumbnail, index) => {
                    thumbnail.addEventListener("click", () => {
                        currentIndex = index;
                        updateMainImage(currentIndex);
                    });
                });

                // Prev button click
                prevBtn.addEventListener("click", () => {
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                    updateMainImage(currentIndex);
                });

                // Next button click
                nextBtn.addEventListener("click", () => {
                    currentIndex = (currentIndex + 1) % images.length;
                    updateMainImage(currentIndex);
                });

                // Jika parameter 'rating' ada
                if (ratingParam) {
                    // Scroll ke elemen dengan id 'reviews-container'
                    const reviewsContainer = document.getElementById('reviews-container');
                    if (reviewsContainer) {
                        reviewsContainer.scrollIntoView({ behavior: 'smooth' });
                    }
                }

                // Initialize with the first image and active thumbnail
                updateMainImage(currentIndex);
            });
        </script>
    </x-slot>
</x-app-layout>
