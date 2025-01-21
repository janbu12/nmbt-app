<x-app-layout title="Riwayat" bodyClass="bg-tertiery3 w-full items-center overflow-hidden max-h-screen">
    <div class="flex w-full px-4 lg:px-10 mt-[5rem] md:mt-0 h-screen overflow-hidden flex-col">
        {{-- Sidebar Component --}}
        <div class="flex flex-col lg:flex-row mt-2">
            <div class="w-full text-start font-bold text-base lg:text-4xl text-secondary2 p-3">
                Transaction History
            </div>
            <div class="flex flex-col lg:flex-row text-sm md:text-base">
                <form action="{{ route('admin.history.historyExcel') }}" method="GET" class="h-full w-full lg:w-fit mb-4 flex items-center gap-4 justify-end mr-4">
                    <div x-data="{ showModal: false, startDate: '', endDate: '', allTime: false }" class="relative w-full lg:w-fit">
                        <x-button variant="secondary" class="w-full lg:w-36" x-on:click="showModal = true">
                            History to Excel
                        </x-button>
                    </div>
                    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" x-cloak>
                        <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
                            <h2 class="text-xl font-semibold mb-4">Export History</h2>

                            <!-- Pilihan Jangka Waktu -->
                            <div class="mb-4">
                                <label class="block font-medium mb-2">Jangka Waktu:</label>
                                <div class="flex gap-2 items-center">
                                    <input type="date" x-model="startDate" class="border rounded-lg px-3 py-2 w-full">
                                    <span class="text-gray-600">to</span>
                                    <input type="date" x-model="endDate" class="border rounded-lg px-3 py-2 w-full">
                                </div>
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" x-model="allTime" class="rounded">
                                        <span class="ml-2">All Time</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="flex justify-end gap-2">
                                <x-button variant="secondary" x-on:click="showModal = false">Cancel</x-button>
                                <x-button variant="primary" x-on:click="submitForm">Export</x-button>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="{{ route('admin.history.detailHistoryExcel') }}" target="_blank" method="GET" class="h-full w-full lg:w-fit mb-4 flex items-center gap-4 justify-end mr-4">
                        <!-- Tombol Ekspor -->
                        {{-- <x-button variant='secondary' class="w-48"> --}}
                        <x-button variant='secondary' class="w-full lg:w-48">
                            Detail History to Excel
                        </x-button>
                </form>
            </div>

            <form id="filter-form" method="GET" action="{{ route('admin.history') }}" class="w-full lg:w-fit h-full mb-4 flex items-center gap-2 lg:gap-4">
                <!-- Filter Status -->
                <select name="status" class="p-2 rounded-lg border w-fit border-gray-300" onchange="document.getElementById('filter-form').submit()"  @change="Alpine.store('loadingState').showLoading();">
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
                    class="p-2 rounded-lg border border-gray-300 focus w-full lg:w-fit"
                    oninput="filterDelay()"
                >
            </form>
        </div>

        <div class="bg-white mr-8 lg:my-4 rounded-xl drop-shadow-md py-8 px-6 flex-col w-full h-full overflow-y-auto">
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
                        <td colspan="7" class="px-4 py-2 text-center">No data was found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-b lg:px-14 py-4">
            {{ $rents->appends(request()->query())->links('pagination::custom-pagination') }}
        </div>
    </div>
</x-app-layout>

<script>

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', function () {
            Alpine.store('loadingState').showLoading();
            setTimeout(() => {
                Alpine.store('loadingState').hideLoading();
            }, 3000);
        });
    });

</script>
