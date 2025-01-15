<x-app-layout title="Riwayat" bodyClass="bg-tertiery3 w-full items-center overflow-hidden max-h-screen">
    <div class="flex w-full px-10 h-screen overflow-hidden flex-col">
        {{-- Sidebar Component --}}
        <div class="flex flow-row mt-2">
            <div class="w-full text-start font-bold text-4xl text-secondary2 p-3">
                Transaction History
            </div>

            <form id="filter-form" method="GET" action="{{ route('admin.history') }}" class="h-full mb-4 flex items-center gap-4">
                <!-- Filter Status -->
                <select name="status" class="p-2 rounded-lg border border-gray-300" onchange="document.getElementById('filter-form').submit()"  @change="Alpine.store('loadingState').showLoading();">
                    <option value="">All Status</option>
                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="process" {{ request('status') == 'process' ? 'selected' : '' }}>Process</option>
                    <option value="ready_pickup" {{ request('status') == 'ready_pickup' ? 'selected' : '' }}>Pickup Ready</option>
                    <option value="renting" {{ request('status') == 'renting' ? 'selected' : '' }}>Renting</option>
                    <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>Order Num.</th>
                        <th>Pickup Date</th>
                        <th>Return Date</th>
                        <th>Customer Name</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($rents as $rent)
                    <tr class="bg-white hover:bg-blue-100">
                        <td>{{ $rent->id }}</td>
                        <td>{{ $rent->pickup_date }}</td>
                        <td>{{ $rent->return_date }}</td>
                        <td>{{ $rent->full_name }}</td>
                        <td>Rp. {{ number_format($rent->total_price, 0, ',', '.') }}</td>
                        <td>
                            {{  ($rent->status_rent == "done" ? 'Done' :
                                ($rent->status_rent == 'ready_pickup' ? 'Ready Pickup':
                                ($rent->status_rent == 'renting' ? 'Renting':
                                ($rent->status_rent == 'process' ? 'Process':
                                ($rent->status_rent == 'unpaid' ? 'Unpaid': 'Cancelled')))))}}</td>
                        <td>
                            <x-button as="a" variant="secondary" href="{{ route('admin.show', $rent->id) }}">
                                Detail
                            </x-button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No data was found</td>
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
            Alpine.store('loadingState').showLoading();
            document.getElementById('filter-form').submit();
        }, 300);
    }
</script>
