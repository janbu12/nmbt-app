<x-app-layout title="Invoice" bodyClass="bg-tertiery3 gap-4 h-screen items-center" x-data="{ isLoading: false }">
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
        <x-button id="payButton" variant='secondary' class="py-2 w-full text-white rounded-lg my-3">Pilih Pembayaran!</x-button>
    </div>

    <x-slot name="scripts">
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            function sendToEmail(userName, pickupDate, returnDate, items, grandtotal, email, orderId) {
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
