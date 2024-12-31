<x-app-layout title="Riwayat" bodyClass="bg-tertiery3 w-full items-center overflow-hidden max-h-screen">
    <div class="flex w-full px-10 h-screen overflow-hidden flex-col">

        {{-- Sidebar Component --}}
        <div class="w-full text-center mt-3 font-bold text-4xl text-secondary2 p-3">
            Riwayat Transaksi
        </div>
        
        <div class="border-tertiery1">
            <input type="text" name="" id="" class="rounded-lg bg-white w-3/12 p-3 border-tertiery2" placeholder="Search">
        </div>
        
        <div class="bg-white mr-8 my-8 rounded-3xl drop-shadow-md py-8 px-6 flex-col w-full">
            <table class="table-auto w-full text-left">
                <thead class="bg-blue-200 text-center">
                    <tr>
                        {{-- <th class="px-4 py-2">NO</th> --}}
                        <th class="px-4 py-2">NO Pesanan</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">ID Pelanggan</th>
                        <th class="px-4 py-2">Nama Pelanggan</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Pembayaran</th>
                        <th class="px-4 py-2">Detail</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="bg-gray-50 hover:bg-blue-100 text-center">
                        {{-- <td class="px-4 py-2">1</td> --}}
                        <td class="px-4 py-2">001</td>
                        <td class="px-4 py-2">2022-01-01</td>
                        <td class="px-4 py-2">010101</td>
                        <td class="px-4 py-2">Siregar</td>
                        <td class="px-4 py-2">1.000.000</td>
                        <td class="px-4 py-2">Transfer</td>
                        <td class="px-4 py-2 text-center">
                            <button class="p-2 text-white rounded-lg bg-secondary2 hover:bg-secondary1">
                                Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-auto flex justify-center py-3">
            <button class="mx-2 px-3 py-1 bg-blue-500 text-white rounded-lg">1</button>
            <button class="mx-2 px-3 py-1 bg-gray-300 text-gray-700 rounded-lg">2</button>
            <button class="mx-2 px-3 py-1 bg-gray-300 text-gray-700 rounded-lg">3</button>
        </div>
    </div>
</x-app-layout>
