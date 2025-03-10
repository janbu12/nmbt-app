<x-app-layout title="Riwayat" bodyClass="bg-tertiery3 w-full items-center overflow-auto lg:overflow-hidden lg:max-h-screen">
    <div class="flex mt-16 md:mt-0 w-full lg:px-10 h-screen overflow-auto flex-col">
        {{-- Sidebar Component --}}
        <div class="flex mt-2">
            <div class="w-full text-start font-bold text-base lg:text-2xl text-secondary2 p-2 lg:p-3">
                Your Orders
            </div>
        </div>
        <div class="flex flex-col gap-2 px-2 lg:p-0 lg:flex-row justify-between">
            <form class="flex w-full gap-2 text-[0.6rem] md:text-base overflow-x-auto" action="{{ route('history.index') }}" method="GET">
                <x-button
                    type="submit"
                    name="status"
                    value="unpaid"
                    variant="{{ request()->get('status') == 'unpaid' ? 'secondary' : 'tertiery' }}"
                    class="flex w-full lg:w-fit items-center justify-center flex-col lg:flex-row px-3 lg:px-4 gap-1"
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
                    class="flex w-full lg:w-fit items-center justify-center flex-col lg:flex-row px-3 lg:px-4 gap-1"
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
                    class="flex w-full lg:w-fit items-center justify-center flex-col lg:flex-row px-3 lg:px-4 gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Ready Pickup
                </x-button>
                <x-button
                    type="submit"
                    name="status"
                    value="renting"
                    variant="{{ request()->get('status') == 'renting' ? 'secondary' : 'tertiery' }}"
                    class="flex w-full lg:w-fit items-center justify-center flex-col lg:flex-row px-3 lg:px-4 gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-hourglass-bottom size-5" viewBox="0 0 16 16">
                        <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702s.18.149.5.149.5-.15.5-.15v-.7c0-.701.478-1.236 1.011-1.492A3.5 3.5 0 0 0 11.5 3V2z"/>
                  </svg>
                    Renting
                </x-button>
                <x-button
                    type="submit"
                    name="status"
                    value="done"
                    variant="{{ request()->get('status') == 'done' ? 'secondary' : 'tertiery' }}"
                    class="flex w-full lg:w-fit items-center justify-center flex-col lg:flex-row px-3 lg:px-4 gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Done
                </x-button>
                <x-button
                    type="submit"
                    name="status"
                    value="cancelled"
                    variant="{{ request()->get('status') == 'cancelled' ? 'secondary' : 'tertiery' }}"
                    class="flex w-full lg:w-fit items-center justify-center flex-col lg:flex-row px-3 lg:px-4 gap-1"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    Cancel
                </x-button>
            </form>
            <form action="{{ route('history.index') }}" method="GET" class="lg:w-1/2">
                <input
                @keydown.enter="Alpine.store('loadingState').showLoading();"
                type="text"
                value="{{ request('search') }}"
                class="p-2 w-full text-sm md:text-base rounded-lg drop-shadow-lg border hover:border-primary"
                placeholder="No Order"
                name="search">
            </form>
        </div>

        <div class="flex lg:mx-0 px-2 lg:px-0 my-4 drop-shadow-md flex-col w-full h-full">

            {{-- Tablet - PC --}}
            <div class="overflow-auto rounded-xl bg-white p-4 w-full h-full">
                <table class="table w-full">
                    <thead class="text-base w-full">
                        <tr>
                            <th>No Order</th>
                            <th>Pickup Date</th>
                            <th>Return Date</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            @if (request()->get('status') == "unpaid")
                                <th>Payment Expires At</th>
                            @endif
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rents as $rent)
                        <tr class="bg-white hover:bg-blue-100">
                            <td >{{ $rent->id }}</td>
                            <td>{{ $rent->pickup_date }}</td>
                            <td >{{ $rent->return_date }}</td>
                            <td >Rp. {{ number_format($rent->total_price, 0, ',', '.') }}</td>
                            <td >{{ ($rent->status_rent == "done" ? 'Done' :
                                    ($rent->status_rent == 'ready_pickup' ? 'Ready Pickup':
                                    ($rent->status_rent == 'process' ? 'Process':
                                    ($rent->status_rent == 'unpaid' ? 'Unpaid':
                                    ($rent->status_rent == 'renting' ? 'Renting': 'Cancel')))))}}</td>
                                    @if (request()->get('status') == "unpaid")
                                      <td id="countdown-{{ $rent->id }}" data-expiry="{{ \Carbon\Carbon::parse($rent->payment_expires_at)->toIso8601String() }}"></td>
                                    @endif
                            <td class="px-4 py-2 flex justify-center">
                                @if (request()->get('status') == 'unpaid')
                                    <div class="flex gap-2">
                                        <button id="pay-button-{{ $rent->id }}" class="p-2 rounded-md bg-secondary3 text-bg3 hover:bg-bg1 hover:text-secondary3 hover:border-bg1" onclick="payOrder('{{ $rent->id }}')">Pay</button>
                                        <button class="p-2 rounded-md bg-red-600 text-bg3 hover:bg-bg1 hover:text-secondary3 hover:border-red-300" onclick="confirmCancel('{{ $rent->id }}')">Cancel</button>
                                        <x-button as="a" variant="secondary" class="sm:px-4" href="{{ route('history.show', $rent->id) }}">
                                            Detail
                                        </x-button>
                                    </div>
                                @elseif(request()->get('status') == 'cancelled' || request()->get('status') == 'renting')
                                    <x-button as="a" variant="secondary" href="{{ route('history.show', $rent->id) }}">
                                        Detail
                                    </x-button>
                                @elseif(request()->get('status') == 'done')
                                    <div class="flex gap-2">
                                        <x-button as="a" variant="danger" href="{{ route('orders.review', $rent->id) }}">
                                            Review
                                        </x-button>
                                        <x-button as="a" variant="secondary" href="{{ route('history.show', $rent->id) }}">
                                            Detail
                                        </x-button>
                                    </div>
                                @else
                                    <div class="flex gap-2">
                                        <button class="p-2 rounded-md bg-red-600 text-bg3 hover:bg-bg1 hover:text-secondary3 hover:border-red-300" onclick="confirmCancel('{{ $rent->id }}')">Cancel</button>
                                        <x-button as="a" variant="secondary" href="{{ route('history.show', $rent->id) }}">
                                            Detail
                                        </x-button>
                                    </div>
                                @endif
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
        </div>

        {{-- Modal Konfirmasi Pembatalan --}}
        <div id="cancelModal" class="fixed px-2 lg:px-0 inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div class="bg-white rounded-lg p-6 w-full lg:w-1/3">
                <h2 class="text-xl font-semibold mb-4">Confirm Cancellation</h2>
                <p>Are you sure you want to cancel this order?</p>

                <div class="mt-4">
                    <label for="cancellationReason" class="block text-sm font-medium text-gray-700">Reason for Cancellation</label>
                    <select id="cancellationReason" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-secondary2 focus:border-secondary2">
                        <option value="" selected disabled>Choose a reason</option>
                        <option value="Not using the equipment">Not using the equipment</option>
                        <option value="Change of plan">Change of plan</option>
                        <option value="Bad weather">Bad weather</option>
                        <option value="Others">Others</option>
                    </select>
                </div>

                <div class="flex justify-end mt-4">
                    <button id="confirmCancelButton" class="bg-secondary2 text-white px-4 py-2 rounded-lg">Ya, Batalkan</button>
                    <button id="cancelCancelButton" class="ml-2 bg-gray-300 text-black px-4 py-2 rounded-lg" onclick="closeCancelModal()">Batal</button>
                </div>
            </div>
        </div>

        <div class="flex px-2 lg:px-0 w-full border-b pb-4">
            {{ $rents->appends(request()->query())->links('pagination::custom-pagination') }}
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            let orderIdToCancel = null;

            function payOrder(orderId) {
                Alpine.store('loadingState').showLoading();
                fetch(`/orders/payment/${orderId}`, { // Ganti dengan route yang sesuai
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(text); });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data yang diterima dari server:', data);
                    if (data.status === 'success') {
                        // Lakukan pembayaran dengan snapToken yang sudah ada
                        window.snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                console.log(result);
                                // Handle success
                                Alpine.store('loadingState').showLoading();
                                fetch(`/orders/payment/${orderId}/success`, {
                                    method: 'PATCH',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        payment_method: result.payment_type
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Failed to update payment');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Payment success:', data);
                                    window.location.href = '/user/history?status=process';
                                })
                                .catch(error => {
                                    console.error('Error updating payment:', error);
                                    alert('Failed to update payment.');
                                });
                            },
                            onPending: function(result) {
                                console.log(result);
                                // Handle pending
                                fetch(`/orders/payment/${orderId}`, {
                                    method: 'PATCH',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        payment_method: result.payment_type
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Failed to update payment method');
                                    }
                                    return response.json();
                                    Alpine.store('loadingState').hideLoading();
                                })
                                .then(data => {
                                    console.log('Payment method updated:', data);
                                })
                                .catch(error => {
                                    console.error('Error updating payment method:', error);
                                    alert('Failed to update payment method.');
                                });
                            },
                            onError: function(result) {
                                console.log(result);
                                if(result.status_code === 407){
                                    alert('token expired');
                                }
                            },
                            onClose: function(result){
                                // alert('You closed the popup without finishing the payment');
                            },
                        })
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses pembayaran: ' + error.message);
                })
                .finally(()=>{
                    Alpine.store('loadingState').hideLoading();
                });
            }

            function confirmCancel(orderId) {
                orderIdToCancel = orderId;
                document.getElementById('cancelModal').classList.remove('hidden');
            }

            function closeCancelModal() {
                document.getElementById('cancelModal').classList.add('hidden'); // Sembunyikan modal konfirmasi
            }

            document.getElementById('confirmCancelButton').onclick = function() {
                const cancellationReason = document.getElementById('cancellationReason').value; // Ambil nilai alasan pembatalan

                if (!cancellationReason) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Please choose a cancellation reason",
                    });
                    return; // Hentikan eksekusi jika alasan tidak diisi
                }
                // Kirim permintaan untuk membatalkan pesanan
                Alpine.store('loadingState').showLoading();
                fetch(`/orders/cancel/${orderIdToCancel}`, { // Ganti dengan route yang sesuai
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ reason: cancellationReason })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data yang diterima dari server:', data);
                    if (data.status === 'success') {
                        // Refresh halaman atau lakukan tindakan lain
                        location.reload();
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat membatalkan pesanan.');
                })
                .finally(() => {
                    Alpine.store('loadingState').hideLoading();
                    closeCancelModal();
                });
            };
        </script>
        <script>
            function updateCountdowns() {
                document.querySelectorAll('td[id^="countdown-"]').forEach(td => {
                    let expiryTime = new Date(td.getAttribute('data-expiry')).getTime();
                    let orderId = td.id.replace("countdown-", "");
                    let interval = setInterval(() => {
                        let now = new Date().getTime();
                        let distance = expiryTime - now;

                        if (distance <= 0) {
                            clearInterval(interval);
                            td.innerText = "Expired";
                            
                            cancelExpiredOrder(orderId);

                            // Matikan tombol bayar
                            let rentId = td.id.replace("countdown-", ""); // Ambil ID dari countdown
                            let payButton = document.querySelector(`#pay-button-${rentId}`);
                            if (payButton) {
                                payButton.disabled = true;
                                payButton.classList.add("opacity-50", "cursor-not-allowed");
                            }
                        } else {
                            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                            td.innerText = `${minutes}m ${seconds}s`;
                        }
                    }, 1000);
                });
            }

            function cancelExpiredOrder(orderId) {
                fetch(`/orders/cancel/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ reason: "Payment expired" })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to cancel expired order');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Order expired and cancelled:', data);
                    location.reload();
                })
                .catch(error => {
                    console.error('Error cancelling expired order:', error);
                });
            }
            document.addEventListener("DOMContentLoaded", updateCountdowns);
        </script>        
    </x-slot>
</x-app-layout>
