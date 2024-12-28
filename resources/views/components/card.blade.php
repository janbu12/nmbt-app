<div class="2xl:max-w-xs rounded-xl p-2 overflow-hidden shadow-lg bg-white hover:scale-90 transition transform duration-300">
    <!-- Gambar -->
    <img
      src="{{ $image }}"
      alt="Product Image"
      class="w-full h-48 object-cover"
    />

    <!-- Konten Card -->
    <div class="p-4">
      <!-- Judul -->
      <h2 class="text-lg font-semibold text-gray-800 mb-2">
        {{ $title }}
      </h2>
      <!-- Deskripsi -->
      <p class="text-gray-600 text-sm mb-4">
        {{ $description }}
      </p>

      <!-- Harga dan Badge -->
      <div class="flex justify-between items-center">
        <span class="text-primary text-xl font-bold">
          Rp. {{ number_format($price, 2, ',', '.') }}
        </span>
        <span class="bg-blue-100 text-blue-600 text-xs font-medium px-3 py-1 rounded">
          {{ $category }}
        </span>
      </div>
    </div>

    <!-- Aksi -->
    <div class="p-4 border-t border-gray-200">
      <button
        class="w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 px-4 rounded transition">
        Tambahkan ke Keranjang
      </button>
    </div>
</div>
