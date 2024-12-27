<x-app-layout title="Sewa" bodyClass="bg-tertiery3 w-full items-center">
    <div class="flex w-full px-10 justify-end">
        <div class="bg-white mr-8 my-8 rounded-3xl drop-shadow-md py-8 px-12 w-1/4 h-fit z-10">
            <label class="border py-2.5 px-4 rounded-lg border-tertiery1 flex items-center gap-2 hover:cursor-text text-tertiery1 group">
                <input class="w-full focus:outline-none group/Focus:" type="text" class="grow" placeholder="Search" />
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
                <div class="flex w-full gap-2">
                    <div class="flex flex-col gap-2">
                        <label for="">Harga Awal</label>
                        <input
                            class="w-full focus:outline-none border border-tertiery1 border-opacity-50 focus:border-opacity-100 transition p-2 rounded-lg"
                            type="text"
                            name=""
                            id=""
                            placeholder="Masukan Harga"
                        >
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="">Harga Akhir</label>
                        <input
                            class="w-full focus:outline-none border border-tertiery1 border-opacity-50 focus:border-opacity-100 transition p-2 rounded-lg"
                            type="text"
                            name=""
                            id=""
                            placeholder="Masukan Harga"
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white my-8 rounded-3xl drop-shadow-md p-8 w-3/4 flex flex-col gap-5">
            <div class="border-b">
                Header
            </div>
            <div class="grid grid-cols-3 gap-5">
                @foreach ( $products as $product)
                    <div class="card bg-base-100 w-96 shadow-xl cursor-pointer hover:scale-90 transition">
                        <figure>
                            <img
                                src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                                alt="Shoes" />
                        </figure>
                        <div class="card-body">
                            <h2 class="card-title">{{ $product->name }}</h2>
                            <p>{{ $product->teaser }}</p>
                            <div class="card-actions justify-end">
                                <button class="btn btn-primary">Buy Now</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
