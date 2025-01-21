<x-app-layout title="Invoice" bodyClass="bg-tertiery3 min-h-screen">
    <div class="flex mt-[5rem] sm:mt-0 gap-4 flex-col items-center justify-center px-4 md:px-0">
        <div class="pt-3 text-4xl font-semibold text-secondary2">
            Invoice
        </div>

        {{-- Invoice Card --}}
        <div class="bg-white rounded-lg shadow-md p-4 w-full h-4/5 sm:w-3/6 flex flex-col justify-between overflow-auto">
            <div class="gap-3">
                <div class="flex flex-row justify-between">
                    No Order
                    <div>
                        {{ $rent->id }}
                    </div>
                </div>

                <div class="flex flex-row justify-between">
                    Customer Name
                    <div>
                        {{ $user }}
                    </div>
                </div>

                <div class="flex flex-row justify-between">
                    Pickup Date
                    <div>
                        {{ $rent->pickup_date }}
                    </div>
                </div>

                <div class="flex flex-row justify-between">
                    Return Date
                    <div>
                        {{ $rent->return_date }}
                    </div>
                </div>

                <div class="flex flex-row justify-between">
                    Number of Days
                    <div>
                        {{ $rent->days }} Days
                    </div>
                </div>

                <div class="text-start">
                    Details
                </div>
                <div class="bg-blue-300 drop-shadow-md flex-col w-full h-full overflow-y-auto">
                    <table class="table-auto w-full h-full text-left bg-white">
                        <thead class="bg-blue-200 text-center sticky top-0 z-10">
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 font-normal text-center">Product Name</th>
                            <th class="border border-gray-300 p-2 font-normal text-center">Quantity</th>
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
                    Total Price + Tax
                    <div>
                        Rp. {{ number_format($rent->total_price, 0, ',', '.') }}
                    </div>
                </div>
                <div class="flex flex-row justify-between mt-2">
                    Status Order
                    <div>
                        {{ $rent->status_rent }}
                    </div>
                </div>
                @if ($rent->status_rent == 'cancelled')
                    <div class="flex flex-row justify-between mt-2">
                        Reason of Cancelled
                        <div>
                            {{ $rent->cancel_reason }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        {{-- Button --}}
        @if (Auth::user() && Auth::user()->role == 'admin')
            <div class="text-center lg:gap-10 flex flex-col lg:flex-row w-full justify-center">
                @if ($rent->status_rent != 'cancelled' && $rent->status_rent != 'done')
                <x-button variant="secondary" class="py-2 my-3 min-w-fit text-center"
                    as="a"
                    href="{{ route('admin.status', ['id' => $rent->id]) }}">
                    @switch($rent->status_rent)
                        @case ('unpaid')
                            Change Status to Process
                            @break
                        @case('process')
                            Change Status to Ready to Pickup
                            @break
                        @case('ready_pickup')
                            Change Status to Renting
                            @break
                        @case('renting')
                            Change Status to Done
                            @break
                        @default
                            Status Unknown
                    @endswitch
                </x-button>
                @endif
                <x-button variant="secondary" class="py-2 my-3 min-w-fit text-center" as="a" href="{{ route('admin.history') }}">
                    Back
                </x-button>
            </div>
        @else
            <x-button variant="secondary" class="py-2 my-3 w-fit" as="a" href="{{ route('history.index') }}">
                Back
            </x-button>
        @endif
    </div>
    <x-slot name="scripts">
        <script>
            @if (session('success'))
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "{{ session('success') }}",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                });
            @endif
        </script>
    </x-slot>
</x-app-layout>
