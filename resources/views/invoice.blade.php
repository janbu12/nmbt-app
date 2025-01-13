<x-app-layout title="Invoice" bodyClass="bg-tertiery3 gap-1 flex-col items-center justify-center h-fit">
    <div class="pt-3 text-4xl font-semibold text-secondary2">
        Invoice
    </div>

    {{-- Invoice Card --}}
    <div class="bg-white rounded-lg shadow-md p-4 h-4/5 w-3/6 flex flex-col justify-between overflow-auto">
        <div class="gap-3">
            <div class="flex flex-row justify-between">
                ID Pesanan
                <div>
                    {{ $rent->id }}
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Nama Pemesan
                <div>
                    {{ $user }}
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Tanggal Mulai
                <div>
                    {{ $rent->pickup_date }}
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Tanggal Selesai
                <div>
                    {{ $rent->return_date }}
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Jumlah hari
                <div>
                    {{ $rent->days }} hari
                </div>
            </div>

            <div class="text-start">
                Detail
            </div>
            <div class="bg-blue-300 drop-shadow-md flex-col w-full h-full overflow-y-auto">
                <table class="table-auto w-full h-full text-left bg-white">
                    <thead class="bg-blue-200 text-center sticky top-0 z-10">
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2 font-normal text-center">Nama Barang</th>
                        <th class="border border-gray-300 p-2 font-normal text-center">Kuantitas</th>
                        <th class="border border-gray-300 p-2 font-normal text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rent->rent_details as $detail)
                    <tr>
                        <td class="border border-gray-300 p-2">{{ $detail->product->name }}</td>
                        <td class="border border-gray-300 p-2">{{ $detail->quantity }}</td>
                        <td class="border border-gray-300 p-2">Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        <div>
            <div class="flex flex-row justify-between items-center mt-4">
                Total + Pajak
                <div>
                    Rp. {{ number_format($rent->total_price, 0, ',', '.') }}
                </div>
            </div>
            <div class="flex flex-row justify-between mt-2">
                Keterangan
                <div>
                    {{ $rent->status_rent }}
                </div>
            </div>
        </div>
    </div>

    {{-- Button --}}
    @if (Auth::user() && Auth::user()->role == 'admin')
        <div class="w-3/6 text-center gap-10 flex flex-row">
            <x-button variant="secondary" class="py-2 my-3 w-full text-center" 
            as="a" 
            href="{{ route('admin.status', ['id' => $rent->id]) }}">
            @switch($rent->status_rent)
                @case('process')
                    Ubah ke process
                    @break
                @case('ready_pickup')
                    Ubah ke renting
                    @break
                @case('renting')
                    Ubah ke done
                    @break
                @case('done')
                    Pesanan Selesai
                    @break
                @default
                    Status Tidak Diketahui
            @endswitch
        </x-button>
            <x-button variant="secondary" class="py-2 my-3 w-full text-center" as="a" href="{{ route('admin.history') }}">
                Kembali
            </x-button>
        </div>
    @else
        <div class="w-3/6 text-center pt-5">
        <x-button variant="secondary" class="py-2 my-3 w-full" as="a" href="{{ route('history.index') }}">
            Kembali
        </x-button>
        </div>
    @endif
</x-app-layout>
