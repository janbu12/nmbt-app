<x-app-layout title="Riwayat" bodyClass="bg-tertiery3 w-full items-center overflow-hidden max-h-screen">
    <div class="flex w-full px-10 h-screen overflow-hidden flex-col">

        {{-- Sidebar Component --}}
        <div class="flex flow-row mt-2">
            <div class="w-full text-start font-bold text-4xl text-secondary2 p-3">
                Riwayat Transaksi
            </div>

            <form action="{{ route('history.index') }}" method="GET" class="p-2 w-2/4 rounded-lg drop-shadow-lg " >
                <div class="flex items-center justify-end h-full w-full">
                    <input 
                    type="text"
                    value="{{ request('search') }}" 
                    class="p-2 w-full rounded-lg drop-shadow-lg border hover:border-primary" 
                    placeholder="Search"
                    name="search">
                </div>
            </form>
                
        </div>
        
        
        <div class="bg-white mr-8 my-4 rounded-3xl drop-shadow-md py-8 px-6 flex-col w-full h-full overflow-y-auto">
            <table class="table-auto w-full h-full text-left bg-white">
                <thead class="bg-blue-200 text-center sticky top-0 z-10">
                    <tr>
                        <th class="px-4 py-2">No Pesanan</th>
                        <th class="px-4 py-2">Tanggal Ambil</th>
                        <th class="px-4 py-2">Tanggal Kembali</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rents as $rent)
                    <tr class="bg-gray-50 hover:bg-blue-100 text-center">
                        <td class="px-4 py-2">{{ $rent->id }}</td>
                        <td class="px-4 py-2">{{ $rent->pickup_date }}</td>
                        <td class="px-4 py-2">{{ $rent->return_date }}</td>
                        <td class="px-4 py-2">Rp. {{ number_format($rent->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">{{ $rent->status_rent }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('history.show', $rent->id) }}" class="p-2 rounded-md bg-secondary3 text-bg3 hover:bg-bg1 hover:text-secondary3 hover:border-bg1">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">Tidak ada data ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>          
        
        <div class="border-b px-14 py-4">
            {{ $rents->appends(request()->query())->links('pagination::custom-pagination') }}
        </div>
    </div>
</x-app-layout>
