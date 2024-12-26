<x-app-layout title="Cart" bodyClass="bg-tertiery3 gap-2 h-screen">
    <div class="py-5 px-10 flex gap-10 h-full">
        <div class="p-3 flex flex-col bg-white w-full h-fit rounded-lg drop-shadow-lg text-tertiery1">
            <div class="text-2xl font-medium">
                Keranjang
            </div>
            <hr class="font-bold bg-black">
            <div class="flex py-4 ">
                <div class="flex flex-col">
                    <input type="checkbox" name="" id="" class="mr-2 items-center">
                </div>
                <div class="p-16 border-4 rounded-lg flex flex-col text-center">
                    Ini gambar produk
                </div>

                <div class="flex flex-col px-3 w-full">
                    <div class="font-medium text-2xl">
                        Tenda 2 Orang
                    </div>
                    <div class="flex w-full justify-between">
                        <div class="flex text-lg">
                            Rp. 250,000
                        </div>
                        <div class="flex flex-row gap-2">
                            <div class="p-2 border-2 rounded-lg">
                                -
                            </div>
                            <div class="p-2 border-2 rounded-lg">
                                1
                            </div>
                            <div class="p-2 border-2 rounded-lg">
                                +
                            </div>
                        </div>
                    </div>
                    <div class="flex h-full justify-between items-end">
                        <div class="text-2xl align-baseline">
                            Rp. 250,000
                        </div>
                        <div>
                            <button class="border rounded-xl bg-secondary3 hover:bg-tertiery3 text-white font-medium py-2 px-3">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-3 flex flex-col bg-white w-full h-full rounded-lg drop-shadow-lg text-tertiery1">
            <div class="text-2xl font-medium">
                Pembayaran
            </div>
            <hr>
            <div class="flex flex-col h-full">
                <div class="flex flex-col py-3">
                    Tanggal Penyewaan
                    <div class="flex flex-row py-2 items-center gap-4">
                        <input type="date" name="" id="" class="border-4 rounded-xl p-2 w-full">
                        -
                        <input type="date" name="" id="" class="border-4 rounded-xl p-2 w-full">
                    </div>
                </div>
                <hr>
                <div class="flex py-3 text-2xl flex-row justify-between">
                    Subtotal
                    <div>
                        Rp. 250,000
                    </div>
                </div>
                <div class="flex py-3 text-2xl flex-row justify-between">
                    Lama pinjam (2 hari)
                    <div>
                        Rp. 20,000
                    </div>
                </div>
                <div class="flex py-3 text-2xl flex-row justify-between">
                    Pajak (11%)
                    <div>
                        Rp. 29,700
                    </div>
                </div>
                <hr>
                <div class="flex py-3 text-2xl flex-row justify-between">
                    Total (Pembulatan)
                    <div>
                        Rp. 280,000
                    </div>
                </div>
                <div class="flex py-3 text-2xl items-center flex-row justify-between">
                    Subtotal
                    <div>
                        <select name="" id="" class="border rounded-lg p-2">
                            <option value="cod">COD</option>
                            <option value="transfer">Transfer</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                </div>

                <div class=" h-full items-end flex">
                    <button class="p-2 w-full rounded-lg bg-secondary3 hover:bg-primary3 text-white font-medium">Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
