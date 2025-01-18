<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tagihan Pesanan Anda</title>
    <style>
        /* Tailwind CSS styles */
        .bg-white { background-color: #ffffff; }
        .text-secondary2 { color: #4A5568; } /* Ganti dengan warna yang sesuai */
        .text-lg { font-size: 1.125rem; }
        .font-semibold { font-weight: 600; }
        .p-4 { padding: 1rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .shadow-md { box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mt-4 { margin-top: 1rem; }
        .mb-4 { margin-bottom: 1rem; }
        .border { border: 1px solid #E2E8F0; }
        .border-collapse { border-collapse: collapse; }
        .w-full { width: 100%; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .font-normal { font-weight: 400; }
        .bg-gray-100 { background-color: #F7FAFC; }
        .p-2 { padding: 0.5rem; }
        .text-sm { font-size: 0.875rem; }
    </style>
</head>
<body class="bg-white">
    <div class="p-4">
        <h1 class="text-2xl font-semibold text-secondary2">Perhatian !!!, {{ $userName }}!</h1>
        <p class="text-lg">Your order is ready for pickup.</p>
        <p class="text-lg">Date Status Changed: {{ $date }}</p>
        <h2 class="text-xl font-semibold mt-4">Detail Pesanan:</h2>
        <table class="w-full border-collapse border border-gray-300 mt-2">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 p-2 text-left">Nama Barang</th>
                    <th class="border border-gray-300 p-2 text-left">Kuantitas</th>
                    <th class="border border-gray-300 p-2 text-left">Total</th>
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
        <p class="mt-4"><a href="{{ route('history.index', ['status' => 'ready_pickup']) }}" class="text-blue-500">Lihat Tagihan</a></p>
    </div>
</body>
</html>
