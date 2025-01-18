<!DOCTYPE html>
<html>
<head>
    <title>Update Status Sewa</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen flex items-center justify-center bg-tertiery3 text-sm md:text-base">
    <div class="bg-white p-5 rounded-md mx-3">
        <h1>Halo, {{ $fullName }}</h1>
        <h2 class="mt-4">Detail Pesanan</h2>
        <table class="table w-full my-3">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rent->rent_details as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            @if ($status == 'ready_pickup')
                <p>Pesanan Anda siap diambil. Silakan datang ke lokasi untuk mengambil barang sewa Anda.</p>
            @elseif ($status == 'renting')
                <p>Semoga Anda happy dan selamat hingga pulang! Nikmati pengalaman sewa Anda.</p>
            @elseif ($status == 'done')
                <p>Kami berharap Anda puas dengan pengalaman sewa Anda.</p>
            @else
                <p>Status sewa Anda telah diperbarui menjadi: <strong>{{ $status }}</strong></p>
            @endif
        </div>

        <p class="mt-4">Terima kasih telah menggunakan layanan kami!</p>
    </div>
</body>
</html>
