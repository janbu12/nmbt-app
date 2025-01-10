<x-app-layout title="Invoice" bodyClass="bg-tertiery3 gap-1 h-screen items-center">
    <div class="pt-3 text-4xl font-semibold text-secondary2">
        Pesanan
    </div>

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
        <x-button variant='secondary' class="py-2 w-full text-white rounded-lg my-3">Bayar!</x-button>
    </div>
</x-app-layout>
