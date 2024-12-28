<x-app-layout title="Cart" bodyClass="bg-tertiery3 gap-1 h-screen">
    @if (session('error'))
        <div class="bg-red-500 text-white p-2 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-5 px-10 flex gap-10 h-full">
        {{-- <div class="p-3 flex flex-col bg-white w-full h-fit rounded-lg drop-shadow-lg text-tertiery1"> --}}
        <div class="p-3 flex flex-col bg-white w-full h-fit max-h-[564px] overflow-y-auto rounded-lg drop-shadow-lg text-tertiery1">
            {{-- <div class="sticky top-0 bg-red-500 z-10"> --}}
                <div class="flex flex-row justify-between pb-3">
                    <div class="text-2xl font-medium">
                        Keranjang ({{ count($cartItems) }} item)
                    </div>
                    <div class="p-2 bg-secondary3 hover:bg-tertiery3 rounded-lg text-white">
                        <button id="check">Pilih semua</button>
                    </div>
                </div>
                <hr class="font-bold bg-black">
            {{-- </div> --}}
            @if ($cartItems->count() > 0)
                @foreach ($cartItems as $item)
                    <div class="flex py-4 ">
                        <div class="flex items-center">
                            <input type="checkbox" name="selected_items[]" id="checkbox" value="{{ $item['id'] }}" class="mr-2">
                        </div>
                        <div class="p-16 border-4 rounded-lg flex flex-col text-center">
                            <img src="{{ $item['image'] }}" alt="{{ $item['image'] }}">
                        </div>

                        <div class="flex flex-col px-3 w-full">
                            <div class="font-medium text-2xl">
                                {{ $item['name'] }}
                            </div>
                                <div class="flex w-full justify-between">
                                    <div class="flex text-lg">
                                        Rp. {{ number_format($item['price'], 0, ',', '.') }}
                                    </div>
                                    <div class="flex flex-row gap-2">
                                        <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="inline">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="quantity" value="{{ $item['quantity']- 1 }}">
                                            <button class="p-2 border-2 rounded-lg">
                                                -
                                            </button>
                                        </form>

                                        <div class="p-2 border-2 rounded-lg">
                                            {{ $item['quantity'] }}
                                        </div>

                                        <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="inline">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                            <button class="p-2 border-2 rounded-lg">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            <div class="flex h-full justify-between items-end">
                                <div class="text-2xl align-baseline">
                                    Rp. {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </div>

                                <form action="{{  route('cart.destroy', $item['id']) }}" method="POST" class="inline">
                                    @csrf
                                    @method('delete')
                                    <div>
                                        <button class="border rounded-xl bg-secondary3 hover:bg-tertiery3 text-white font-medium py-2 px-3" id="hapus">Hapus</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            @else
                <div class="py-4 text-center text-lg font-medium">
                    Keranjang Kosong, Ayo Mendaki!
                </div>
            @endif
        </div>

        <div class="p-3 flex flex-col bg-white w-full h-full rounded-lg drop-shadow-lg text-tertiery1">
            <div class="text-2xl font-medium">
                Pembayaran
            </div>
            <hr>
            <div class="flex flex-col h-full">
                <div class="flex flex-col py-3">
                    Tanggal Penyewaan
                    <div class="flex flex-row py-2 items-center gap-4">
                        <input type="date" name="" id="tanggal_awal" class="border-4 rounded-xl p-2 w-full">
                        -
                        <input type="date" name="" id="tanggal_akhir" class="border-4 rounded-xl p-2 w-full">
                    </div>
                </div>
                <hr>
                <div class="flex py-3 text-2xl flex-row justify-between">
                    Subtotal
                    <div>
                        Rp. {{ number_format($subtotal, 0, ',', '.') }}
                    </div>
                </div>
                <div class="flex py-3 text-2xl flex-row justify-between">
                    <div id="jumlah_hari">
                        Lama pinjam: {{ $days ?? 0 }} hari
                    </div>
                    <div id="harga_hari">
                        Rp. {{ $totalPrice ?? 0 }}
                    </div>
                </div>
                <div class="flex py-3 text-2xl flex-row justify-between">
                    Pajak (11%)
                    <div id="pajak">
                        Rp. 0
                    </div>
                </div>
                <hr>
                <div class="flex py-3 text-2xl flex-row justify-between">
                    Total (Pembulatan)
                    <div id="total">
                        Rp. 0
                    </div>
                </div>
                <div class="flex py-3 text-2xl items-center flex-row justify-between">
                    Subtotal
                    <div>
                        <select name="" id="" class="border rounded-lg p-2">
                            <option value="cod">COD</option>
                            <option value="transfer">Transfer</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                </div>

                <div class=" h-full items-end flex">
                    <button class="p-2 w-full rounded-lg bg-secondary3 hover:bg-primary3 text-white font-medium">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    const checkAllButton = document.querySelector('#check');
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_items[]"]');
    
    checkAllButton.addEventListener('click', function() {
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked; // Toggle semua checkbox
        });
    });

    document.querySelectorAll('#hapus').forEach(form => {
        form.addEventListener('submit', function(e) {
            const confirmed = confirm('Apakah Anda yakin ingin menghapus item ini?');
            if (!confirmed) {
                e.preventDefault(); // Batalkan penghapusan
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const decreaseButtons = document.querySelectorAll('form[action*="cart/update"] button[type="submit"]');

        decreaseButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                const input = e.target.closest('form').querySelector('input[name="quantity"]');
                if (parseInt(input.value) <= 1) {
                    e.preventDefault();
                    alert('Jumlah barang tidak boleh kurang dari 1.');
                }
            });
        });

        const startDateInput = document.getElementById('tanggal_awal');
        const endDateInput = document.getElementById('tanggal_akhir');
        const daysDisplay = document.getElementById('jumlah_hari');
        const hargaHari = document.getElementById('harga_hari');
        const totalPajak = document.getElementById('pajak');

        // const hargaPajak = 0.11;
        const hargaPinjam = 5000;

        function calculateDays() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (!isNaN(startDate) && !isNaN(endDate) && endDate >= startDate) {
                const difference = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                const totalHarga = difference * hargaPinjam;

                daysDisplay.textContent = `Lama Pinjam: ${difference} hari`;
                hargaHari.textContent = `Rp. ${totalHarga.toLocaleString('id-ID')}`;
        //         totalPajak.textContent = `Rp. ${Math.ceil(totalHarga * hargaPajak).toLocaleString('id-ID')}`;
            } else if (endDate < startDate) {
                alert('Tanggal akhir tidak boleh lebih awal dari tanggal awal.');
            } else {
                daysDisplay.textContent = 'Lama Pinjam: 0 hari';
                hargaHari.value = 'Rp. 0';
        //         totalPajak.textContent = 'Rp. 0';
            }
        }

        startDateInput.addEventListener('change', calculateDays);
        endDateInput.addEventListener('change', calculateDays);

        
        
    });

</script>