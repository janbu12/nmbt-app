<x-app-layout title="Item List" bodyClass="bg-tertiery3 w-full items-center overflow-hidden max-h-screen">
  <div class="flex w-full px-10 py-6 h-screen overflow-hidden flex-col">
    <div class="flex flex-row justify-between">
        <div class="flex">
            <input type="text" name="" id="" placeholder="Search" class="w-full p-2 rounded-lg">
        </div>
        <div class="flex">
            <button class="p-3 bg-secondary3 rounded-lg font-bold text-white hover:bg-secondary1">
                Tambah
            </button>
        </div>
      </div>

    <div class="bg-white my-4 rounded-3xl drop-shadow-md w-full flex flex-col gap-5">
      <div class="grid grid-cols-3 gap-3 overflow-auto py-4 px-8 justify-items-center">
        
        @foreach ($products as $item)
          <div class="card bg-base-100 lg:card-side shadow-xl w-full">
            <figure class="w-full">
              @if ($item->images->isNotEmpty())
                <div class="h-24 w-24">
                  <img src="{{ asset('storage/' . $item->images->first()->file_path) }}" alt="Product Image" class="w-full h-full object-cover"/>
                </div>
              @else
                <div class="h-48 w-62">
                  <img src="{{ asset('images/produk-icon-dummy.png') }}" alt="Shoes" class="w-full h-full object-cover" class="w-full h-full object-cover"/>
                </div>
              @endif
            </figure>
            <div class="card-body w-full">
              <h2 class="card-title text-xl">{{ $item->id }}</h2>
              <div class="flex gap-0 flex-col">
                <p class="text-lg">{{ $item->name }}</p>
                <p>Rp. {{ number_format($item->price?? 0, 2, ',', '.') }}</p>
                <p>{{ $categories[$item->category_id]->category_name }}</p>
              </div>
              <div class="card-actions justify-end pt-3 h-full items-end">
                <button class="text-white font-medium btn bg-secondary3 hover:bg-secondary1">Edit</button>
                <button class="text-white font-medium btn bg-red-600 hover:bg-red-300">Hapus</button>
              </div>
            </div>
          </div>
        @endforeach
        
      </div>
    </div>

    <div class="px-8 py-6">
      {{ $products->appends(request()->query())->links('pagination::custom-pagination') }}
    </div>
  </div>
</x-app-layout>