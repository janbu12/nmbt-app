{{-- <x-app-layout> --}}
    {{-- Admin
    @dump($totalRents)
    @dump($totalDoneRents)
    @dump($totalRenting)
    @dump($totalOngoingRents)
    @dump($totalIncome)
    @dump($topTenProducts)
    @dump($allProduct) --}}
    {{-- @dump($topThreeCategories) --}}

{{-- </x-app-layout> --}}

<x-app-layout bodyClass="bg-tertiery3 text-tertiery1">
    <div class="container mx-auto my-8">
        <div class="bg-white p-6 rounded-xl">
            <h1 class="text-xl font-bold mb-4">Summary</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Total Rents -->
                <div class="card bg-base-100 drop-shadow p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold">Total Rents</h2>
                            <p class="text-xl font-bold">{{ $totalRents }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Done Rents -->
                <div class="card bg-base-100 drop-shadow p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold">Total Done Rents</h2>
                            <p class="text-xl md:text-3xl font-bold">{{ $totalDoneRents }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.125 2.25h-4.5c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125v-9M10.125 2.25h.375a9 9 0 0 1 9 9v.375M10.125 2.25A3.375 3.375 0 0 1 13.5 5.625v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 0 1 3.375 3.375M9 15l2.25 2.25L15 12" />
                        </svg>
                    </div>
                </div>

                <!-- Total Renting -->
                <div class="card bg-base-100 drop-shadow p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold">Total Renting</h2>
                            <p class="text-xl md:text-3xl font-bold">{{ $totalRenting }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Ongoing Rents -->
                <div class="card bg-base-100 drop-shadow p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold">Total Ongoing Rents</h2>
                            <p class="text-xl md:text-3xl font-bold">{{ $totalOngoingRents }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Income -->
                <div class="card bg-base-100 drop-shadow p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold">Total Income</h2>
                            <p class="text-xl md:text-3xl font-bold">Rp. {{ number_format($totalIncome, 2, ',', '.') }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>


        <!-- Top Ten Products -->
        <div class="mt-8 bg-white p-6 rounded-xl">
            <h2 class="text-xl font-bold mb-4">Top Ten Products</h2>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Total Sales</th>
                            <th>Average Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = 0;
                        @endphp
                        @foreach($topTenProducts as $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product['product']->name }}</td>
                                <td>{{ $product['total_sales'] }}</td>
                                <td>{{ number_format($product['average_rating'], 2) }}</td>
                            </tr>
                            @php
                                $index++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
