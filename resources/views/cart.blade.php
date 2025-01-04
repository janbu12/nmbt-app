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
                    <button id="check" class="p-2 bg-secondary3 hover:bg-tertiery3 rounded-lg text-white">
                        Pilih semua
                    </button>
                </div>
                <hr class="font-bold bg-black">
            {{-- </div> --}}
            @if ($cartItems->count() > 0)
                @foreach ($cartItems as $item)
                    <div class="flex py-4 ">
                        <div class="flex items-center">
                            <input type="checkbox"
                                name="selected_items[]"
                                id="checkbox"
                                value="{{ $item->id }}"
                                data-price="{{ $item->product->price }}"
                                data-quantity="{{ $item->quantity }}"
                                class="mr-2">
                        </div>
                        <div class="h-28 w-36 border-4 rounded-lg flex flex-col text-center">
                            @if($item->product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/produk-icon-dummy.png') }}" alt="icon-dummy.png" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="flex flex-col px-3 w-full">
                            <div class="font-medium text-2xl">
                                {{ $item->product->name }}
                            </div>
                                <div class="flex w-full justify-between">
                                    <div class="flex text-lg">
                                        Rp. {{ number_format($item->product->price, 0, ',', '.') }}
                                    </div>
                                    <div class="flex flex-row gap-2">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="quantity" value="{{ $item->quantity- 1 }}">
                                            <button class="p-2 border-2 rounded-lg">
                                                -
                                            </button>
                                        </form>

                                        <div class="p-2 border-2 rounded-lg">
                                            {{ $item->quantity }}
                                        </div>

                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('patch')
                                            <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                            <button class="p-2 border-2 rounded-lg">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </div>

                            <div class="flex h-full justify-between items-end">
                                <div class="text-2xl align-baseline">
                                    Rp. {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </div>

                                <form action="{{  route('cart.destroy', $item->id) }}" method="POST" class="inline">
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
                    <div id="subtotal">
                        Rp. 0
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
    document.addEventListener('DOMContentLoaded', () => {
        const checkAllButton = document.querySelector('#check');
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_items[]"]');
        const subtotalDisplay = document.getElementById('subtotal');
        const startDateInput = document.getElementById('tanggal_awal');
        const endDateInput = document.getElementById('tanggal_akhir');
        const daysDisplay = document.getElementById('jumlah_hari');
        const hargaHari = document.getElementById('harga_hari');
        const totalPajak = document.getElementById('pajak');
        const totalHargaDisplay = document.getElementById('total');
        const percentPajak = 0.11;

        // Utility function to format currency
        const formatCurrency = (value) => `Rp. ${Math.ceil(value).toLocaleString('id-ID')}`;

        // Calculate the subtotal of selected items
        const calculateSubtotal = () => {
            let subtotal = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .reduce((sum, checkbox) => {
                    const price = parseFloat(checkbox.getAttribute('data-price'));
                    const quantity = parseInt(checkbox.getAttribute('data-quantity'));
                    return sum + (price * quantity);
                }, 0);

            subtotalDisplay.textContent = formatCurrency(subtotal);
            return subtotal;
        };

        // Calculate the total rental cost based on days
        const calculateDays = () => {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const subtotal = calculateSubtotal();

            if (isNaN(startDate) || isNaN(endDate) || endDate < startDate) {
                daysDisplay.textContent = 'Lama Pinjam: 0 hari';
                hargaHari.textContent = formatCurrency(0);
                totalPajak.textContent = formatCurrency(0);
                return 0;
            }

            const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
            const totalHargaHari = days * subtotal;
            const pajak = totalHargaHari * percentPajak;

            daysDisplay.textContent = `Lama Pinjam: ${days} hari`;
            hargaHari.textContent = formatCurrency(totalHargaHari);
            totalPajak.textContent = formatCurrency(pajak);

            return totalHargaHari;
        };

        // Calculate the final total including tax
        const calculateTotal = () => {
            const totalHargaHari = calculateDays();
            const totalWithTax = totalHargaHari + (totalHargaHari * percentPajak);
            totalHargaDisplay.textContent = formatCurrency(totalWithTax);
        };

        // Event listener to toggle all checkboxes
        checkAllButton.addEventListener('click', () => {
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            checkboxes.forEach(checkbox => checkbox.checked = !allChecked);

            calculateTotal();
        });

        // Event listeners for individual checkbox changes
        checkboxes.forEach(checkbox => checkbox.addEventListener('change', calculateTotal));

        // Event listeners for date changes
        [startDateInput, endDateInput].forEach(input => input.addEventListener('change', calculateTotal));

        // Initial calculation
        calculateTotal();
    });
</script>

