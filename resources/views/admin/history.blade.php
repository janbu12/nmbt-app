<x-app-layout title="Riwayat" bodyClass="bg-tertiery3 w-full items-center overflow-hidden max-h-screen">
    <div class="flex w-full px-10 h-screen overflow-hidden flex-col">

        {{-- Sidebar Component --}}
        <div class="flex flow-row mt-2">
            <div class="w-full text-start font-bold text-4xl text-secondary2 p-3">
                Transaction History
            </div>

            <form id="filter-form" method="GET" action="{{ route('admin.history') }}" class="h-full mb-4 flex items-center gap-4">
                <!-- Filter Status -->
                <select name="status" class="p-2 rounded-lg border border-gray-300" onchange="document.getElementById('filter-form').submit()">
                    <option value="">All Status</option>
                    <option value="process" {{ request('status') == 'process' ? 'selected' : '' }}>Process</option>
                    <option value="ready_pickup" {{ request('status') == 'ready_pickup' ? 'selected' : '' }}>Pickup Ready</option>
                    <option value="renting" {{ request('status') == 'renting' ? 'selected' : '' }}>Renting</option>
                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                </select>
            
                <!-- Input Pencarian -->
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name or ID"
                    class="p-2 rounded-lg border border-gray-300 focus"
                    oninput="filterDelay()"
                >
            </form> 
        </div>
        
        <div class="bg-white mr-8 my-4 rounded-3xl drop-shadow-md py-8 px-6 flex-col w-full h-full overflow-y-auto">
            <table class="table-auto w-full h-full text-left bg-white">
                <thead class="bg-blue-200 text-center">
                    <tr>
                        <th class="px-4 py-2">Order Num.</th>
                        <th class="px-4 py-2">Pickup Date</th>
                        <th class="px-4 py-2">Return Date</th>
                        <th class="px-4 py-2">Customer Name</th>
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
                        <td class="px-4 py-2">{{ $rent->full_name }}</td>
                        <td class="px-4 py-2">Rp. {{ number_format($rent->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            {{  ($rent->status_rent == "done" ? 'Done' :
                                ($rent->status_rent == 'ready_pickup' ? 'Ready Pickup':
                                ($rent->status_rent == 'renting' ? 'Renting':
                                ($rent->status_rent == 'process' ? 'Process': 'else'))))}}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('admin.show', $rent->id) }}" class="p-2 rounded-md bg-secondary3 text-bg3 hover:bg-bg1 hover:text-secondary3 hover:border-bg1">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-2 text-center">Tidak ada data ditemukan</td>
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

<script>
    let timeout = null;

    function filterDelay() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            document.getElementById('filter-form').submit();
        }, 300);
    }
</script>
