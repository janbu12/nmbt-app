<x-app-layout title="Invoice" bodyClass="bg-tertiery3 gap-1 h-screen items-center">
    <div class="pt-3 text-4xl font-semibold text-secondary2">
        Invoice
    </div>

    {{-- Invoice card --}}
    <div class="bg-white rounded-lg shadow-md p-4 h-screen w-3/6 flex flex-col justify-between">
        <div class="gap-3">
            <div class="flex flex-row justify-between">
                ID Pesanan
                <div>
                    XXXX
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Nama Pemesan
                <div>
                    Yani
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Tanggal Mulai
                <div>
                    31/08/2025
                </div>
            </div>
            
            <div class="flex flex-row justify-between">
                Tanggal Selesai
                <div>
                    10/09/2025
                </div>
            </div>

            <div class="flex flex-row justify-between">
                Jumlah hari
                <div>
                    11 hari
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
                        <tr>
                            <td class="border border-gray-300 p-2">Barang 1</td>
                            <td class="border border-gray-300 p-2">2</td>
                            <td class="border border-gray-300 p-2">Rp. 10,000</td>
                        </tr>
                    </tbody>
                </table>
        </div>

        <div>
            <div class="flex flex-row justify-between items-center mt-4">
                Total + Pajak
                <div>
                    Rp. XX,XXX
                </div>
            </div>
            <div class="flex flex-row justify-between mt-2">
                Keterangan
                <div>
                    Lunas
                </div>
            </div>
        </div>
    </div>

    {{-- Button --}}
    <div class="w-3/6">
        <button class="bg-secondary2 py-2 w-full text-white rounded-lg my-3">Kembali</button>
    </div>
</x-app-layout>
