<x-app-layout title="Invoice" bodyClass="gap-4 h-screen items-center" x-data="{ isLoading: false }">
    {{-- Item Card --}}
    <div class="w-full flex">
        <div class="hidden md:block w-full h-screen overflow-y-auto">
            <div class="flex flex-col space-y-4 mt-2">
                @foreach ($items as $item)
                    <div class="flex flex-row items-center border-b border-gray-300 p-2">
                        <div class="w-1/4">
                            <img src="{{ $item->product->images->first()->url ?? asset('images/produk-icon-dummy.png') }}" alt="{{ $item->product->name }}" class="w-full h-auto rounded">
                        </div>
                        <div class="flex-1 flex flex-col justify-between ml-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold">{{ $item->product->name }}</span>
                                <span class="font-semibold">Rp. {{ number_format($item->total, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Invoice --}}
        <div class="bg-white rounded-lg shadow-md p-4 h-screen w-full md:w-3/6 flex flex-col justify-between">
            <div>
                <div class="flex flex-col gap-2">
                        <div class="flex flex-row justify-between">
                            <span>Name</span>
                            <span>{{ $userName }}</span>
                        </div>
                        <div class="flex flex-row justify-between">
                            <span>Pickup Date</span>
                            <span>{{ $pickup }}</span>
                        </div>
                        <div class="flex flex-row justify-between">
                            <span>Return Date</span>
                            <span>{{ $return }}</span>
                        </div>
                        <div class="flex flex-row justify-between">
                            <span>Total Days Renting</span>
                            <span>{{ $days ?? 0 }} Days</span>
                        </div>
                </div>

                <div class="text-start mt-4">
                    <span class="font-semibold">Order Details</span>
                </div>
                <div class="w-full h-[350px] md:h-80 overflow-y-auto">
                    <div class="flex flex-col space-y-2 mt-2">
                        @foreach ($items as $item)
                            <div class="flex flex-row">
                                <div class="w-1/4 block md:hidden">
                                    <img src="{{ $item->product->images->first()->url ?? asset('images/produk-icon-dummy.png') }}" alt="{{ $item->product->name }}" class="w-full h-auto rounded">
                                </div>
                                <div class="flex-1 flex flex-col ml-4 md:ml-0">
                                    <div class="flex flex-col md:flex-row justify-between">
                                        <div class="flex gap-2">
                                            <span class="text-sm md:font-normal  font-semibold">{{ $item->product->name }}</span>
                                            <p class="text-sm text-gray-600">x {{ $item->quantity }}</p>
                                        </div>
                                        <span class="md:font-medium font-normal">Rp. {{ number_format($item->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <div class="flex flex-row justify-between items-center text-sm md:text-base">
                        <span class="font-semibold">Subtotal</span>
                        <span class="font-semibold">Rp. {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex flex-row justify-between items-center text-sm md:text-base">
                        <span class="font-semibold">Tax (11%)</span>
                        <span class="font-semibold">Rp. {{ number_format($tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex flex-row justify-between items-center text-sm md:text-base">
                        <span class="font-semibold">Total + Pajak (11%)</span>
                        <span class="font-semibold">Rp. {{ number_format($grandtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                {{-- Button --}}
                <div class="flex gap-2 text-xs md:text-base">
                    <x-button as="a" href="{{ route('cart.index') }}" variant="danger" class="text-center w-fit md:w-full text-white rounded-lg">Kembali</x-button>
                    <x-button id="payButton" variant='secondary' class="w-full text-white rounded-lg">Pilih Pembayaran!</x-button>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            function sendToEmail(userName, pickupDate, returnDate, items, grandtotal, email, orderId) {
                Alpine.store('loadingState').showLoading();

                fetch('{{ route("invoice.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            user_name: userName,
                            pickup_date: pickupDate,
                            return_date: returnDate,
                            items: items,
                            grandtotal: grandtotal,
                            email: email,
                            order_id: orderId,
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to send invoice email');
                        }

                        Alpine.store('loadingState').hideLoading();
                    })
            }

            document.getElementById('payButton').onclick = function () {
                // Ambil data yang diperlukan
                const pickupDate = '{{ $pickup }}';
                const returnDate = '{{ $return }}';
                const selectedItems = @json($items->pluck('id'));
                const quantities = @json($items->pluck('quantity'));
                const grandtotal = Math.round({{ $grandtotal }}); // Pastikan grandtotal dibulatkan

                console.log('Data yang akan dikirim:', {
                    pickup_date: pickupDate,
                    return_date: returnDate,
                    selected_items: selectedItems,
                    quantities: quantities,
                    grandtotal: grandtotal
                });

                Alpine.store('loadingState').showLoading();

                // Kirim permintaan untuk mendapatkan snapToken
                fetch('{{ route('payment') }}', { // Pastikan route ini benar
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        pickup_date: pickupDate,
                        return_date: returnDate,
                        selected_items: selectedItems,
                        quantities: quantities,
                        grandtotal: grandtotal
                    })
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
                        sendToEmail('{{ $userName }}', pickupDate, returnDate, selectedItems, grandtotal, '{{ $email }}', data.rent.id);
                        window.snap.pay(data.snapToken, {
                            onSuccess: function(result) {
                                console.log(result);
                                // Handle success
                                Alpine.store('loadingState').showLoading();
                                fetch(`/orders/payment/${result.order_id}/success`, {
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
                                 Alpine.store('loadingState').showLoading();
                                fetch(`/orders/payment/${result.order_id}`, {
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
                                })
                                .then(data => {
                                    console.log('Payment method updated:', data);
                                    window.location.href = '/user/history?status=unpaid';
                                })
                                .catch(error => {
                                    console.error('Error updating payment method:', error);
                                    alert('Failed to update payment method.');
                                });
                            },
                            onError: function(result) {
                                console.log(result);
                                // Handle error
                            },
                            onClose: function(){
                                /* You may add your own implementation here */
                                alert('you closed the popup without finishing the payment');
                                Alpine.store('loadingState').showLoading();
                                window.location.href = '/user/history?status=unpaid';
                                // document.getElementById('paymentModal').classList.add('hidden');
                            }
                        });
                    } else {
                        alert('Terjadi kesalahan: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses pembayaran: ' + error.message);
                })
                .finally(() => {
                    Alpine.store('loadingState').hideLoading();
                });
            };

        </script>
    </x-slot>
</x-app-layout>
