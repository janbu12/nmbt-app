<x-app-layout title="Invoice" bodyClass="bg-tertiery3 gap-4 h-screen items-center">
    <div class="pt-3 text-4xl font-semibold text-secondary2">
        Pesanan
    </div>

    {{-- @dump($pickup); --}}

    {{-- Invoice card --}}
    <div class="bg-white rounded-lg shadow-md p-4 h-screen w-3/6 flex flex-col justify-between">
        <div class="gap-3">
            <div class="flex flex-row justify-between">
                Nama Pemesan
                <div>
                    {{ $userName }}
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Tanggal Mulai
                <div>
                    {{ $pickup }}
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Tanggal Selesai
                <div>
                    {{ $return }}
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Jumlah hari
                <div>
                    {{ $days ?? 0 }} hari - Rp. {{ number_format($totalDays, 0, ',', '.') }}
                </div>
            </div>

                <div class="text-start">
                    Detail
                </div>
                <table class="w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 font-normal text-center">Nama Barang</th>
                            <th class="border border-gray-300 p-2 font-normal text-center">Kuantitas</th>
                            <th class="border border-gray-300 p-2 font-normal text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td class="border border-gray-300 p-2">{{ $item->product->name }}</td>
                            <td class="border border-gray-300 p-2">{{ $item->quantity }}</td>
                            <td class="border border-gray-300 p-2">Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>

        <div>
            <div class="flex flex-row justify-between items-center mt-4">
                Total + Pajak (11%)
                <div>
                    {{-- Rp. {{ number_format($subtotal, 0, ',', '.') }} --}}
                    Rp. {{ number_format($grandtotal, 0, ',', '.') }}
                </div>
            </div>
            {{-- <div class="flex flex-row justify-between mt-2">
                Keterangan
                <div>
                    Lunas
                </div>
            </div> --}}
        </div>
    </div>

    {{-- Button --}}
    <div class="w-3/6 flex flex-row gap-5">
        {{-- <button class="bg-secondary2 py-2 w-full text-white rounded-lg my-3">Bayar!</button> --}}
        <x-button as="a" href="{{ route('cart.index') }}" variant="danger" class="py-2 text-center w-full text-white rounded-lg my-3">Kembali</x-button>
        <x-button id="payButton" variant='secondary' class="py-2 w-full text-white rounded-lg my-3">Bayar!</x-button>
    </div>

    {{-- Modal Konfirmasi Pembayaran --}}
    <div id="paymentModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-xl font-semibold mb-4">Konfirmasi Pembayaran</h2>
            <p>Apakah Anda yakin ingin melanjutkan pembayaran?</p>
            <form id="paymentForm" action="{{ route('payment') }}" method="POST">
                @csrf
                <input type="hidden" name="pickup_date" value="{{ $pickup }}">
                <input type="hidden" name="return_date" value="{{ $return }}">
                <input type="hidden" name="grandtotal" value="{{ $grandtotal }}">
                @foreach ($items as $item)
                    <input type="hidden" name="selected_items[]" value="{{ $item->id }}">
                @endforeach
                <div class="flex justify-end mt-4">
                    <button type="submit" class="bg-secondary2 text-white px-4 py-2 rounded-lg">Ya, Bayar</button>
                    <button id="cancelPayment" type="button" class="ml-2 bg-gray-300 text-black px-4 py-2 rounded-lg">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            document.getElementById('payButton').onclick = function () {
                // Tampilkan modal konfirmasi
                document.getElementById('paymentModal').classList.remove('hidden');
            };

            document.getElementById('cancelPayment').onclick = function () {
                // Sembunyikan modal konfirmasi
                document.getElementById('paymentModal').classList.add('hidden');
            };
        </script>
    </x-slot>
</x-app-layout>
