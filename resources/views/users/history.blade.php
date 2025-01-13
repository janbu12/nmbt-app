<x-app-layout title="Riwayat" bodyClass="bg-tertiery3 w-full items-center overflow-hidden max-h-screen">
    <div class="flex w-full px-10 h-screen overflow-hidden flex-col">
        {{-- Sidebar Component --}}
        <div class="flex mt-2">
            <div class="w-full text-start font-bold text-2xl text-secondary2 p-3">
                Your Orders
            </div>
        </div>
        <div class="flex justify-between">
            <form class="flex gap-2" action="{{ route('history.index') }}" method="GET">
                <x-button
                    type="submit"
                    name="status"
                    value="unpaid"
                    variant="{{ request()->get('status') == 'unpaid' ? 'secondary' : 'tertiery' }}"
                    class="flex px-4 gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>
                    Unpaid
                </x-button>
                <x-button
                    type="submit"
                    name="status"
                    value="process"
                    variant="{{ request()->get('status') == 'process' ? 'secondary' : 'tertiery' }}"
                    class="flex px-4 gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Processing
                </x-button>
                <x-button
                    type="submit"
                    name="status"
                    value="ready_pickup"
                    variant="{{ request()->get('status') == 'ready_pickup' ? 'secondary' : 'tertiery' }}"
                    class="flex px-4 gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Ready Pickup
                </x-button>
                <x-button
                    type="submit"
                    name="status"
                    value="done"
                    variant="{{ request()->get('status') == 'done' ? 'secondary' : 'tertiery' }}"
                    class="flex px-4 gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Done
                </x-button>
                <x-button
                    type="submit"
                    name="status"
                    value="cancel"
                    variant="{{ request()->get('status') == 'cancel' ? 'secondary' : 'tertiery' }}"
                    class="flex px-4 gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Cancel
                </x-button>
            </form>
            <form action="{{ route('history.index') }}" method="GET">
                <input
                type="text"
                value="{{ request('search') }}"
                class="p-2 w-full rounded-lg drop-shadow-lg border hover:border-primary"
                placeholder="No Order"
                name="search">
            </form>
        </div>


        <div class="bg-white my-4 rounded-xl drop-shadow-md p-4 flex-col w-full h-full overflow-y-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>No Order</th>
                        <th>Pickup Date</th>
                        <th>Return Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rents as $rent)
                    <tr class="bg-gray-50 hover:bg-blue-100">
                        <td >{{ $rent->id }}</td>
                        <td >{{ $rent->pickup_date }}</td>
                        <td >{{ $rent->return_date }}</td>
                        <td >Rp. {{ number_format($rent->total_price, 0, ',', '.') }}</td>
                        <td >{{ ($rent->status_rent == "done" ? 'Done' :
                                ($rent->status_rent == 'ready_pickup' ? 'Ready Pickup':
                                ($rent->status_rent == 'process' ? 'Process': 'else')))}}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('history.show', $rent->id) }}" class="p-2 rounded-md bg-secondary3 text-bg3 hover:bg-bg1 hover:text-secondary3 hover:border-bg1">
                                Detail
                            </a>
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
