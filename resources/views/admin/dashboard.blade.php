{{-- <x-app-layout> --}}
    {{-- @dump($totalRents)
    @dump($totalDoneRents)
    @dump($totalRenting)
    @dump($totalOngoingRents)
    @dump($totalIncome)
    @dump($topTenProducts) --}}
    {{-- @dump($quantityRentTotal) --}}
    {{-- @dump($topThreeCategories) --}}
    {{-- @dump($transactions) --}}


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
                            <p class="text-xl md:text-3xl font-bold">{{ $totalRents }}</p>
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

                <!-- Total Quantity Rented -->
                <div class="card bg-base-100 drop-shadow p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold">Total Quantity Rented</h2>
                            <p class="text-xl md:text-3xl font-bold">{{ $quantityRentTotal }}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="size-12 fill-tertiery1" viewBox="0 0 50 50" version="1.1">
                            <g id="surface1">
                                <path style="stroke:none;fill-rule:nonzero;fill-opacity:1;" d="M 24.707031 3.9375 C 24.675781 3.945313 24.648438 3.957031 24.617188 3.96875 L 10.914063 3.96875 C 10.882813 3.96875 10.851563 3.96875 10.820313 3.96875 C 10.789063 3.96875 10.757813 3.96875 10.726563 3.96875 C 10.566406 4.003906 10.417969 4.078125 10.292969 4.183594 L 4.433594 9.082031 L 4.339844 9.144531 C 4.296875 9.171875 4.253906 9.203125 4.214844 9.238281 C 4.203125 9.25 4.195313 9.257813 4.183594 9.269531 C 4.183594 9.28125 4.183594 9.289063 4.183594 9.300781 C 4.171875 9.300781 4.164063 9.300781 4.152344 9.300781 C 4.152344 9.320313 4.152344 9.34375 4.152344 9.363281 C 4.132813 9.394531 4.113281 9.425781 4.09375 9.457031 C 4.054688 9.515625 4.023438 9.574219 4 9.640625 C 3.984375 9.703125 3.972656 9.765625 3.96875 9.828125 C 3.960938 9.890625 3.960938 9.953125 3.96875 10.011719 L 3.96875 44.644531 C 3.96875 45.1875 4.414063 45.636719 4.960938 45.636719 L 44.644531 45.636719 C 45.1875 45.636719 45.636719 45.1875 45.636719 44.644531 L 45.636719 10.074219 C 45.640625 10.023438 45.640625 9.972656 45.636719 9.921875 C 45.636719 9.902344 45.636719 9.878906 45.636719 9.859375 C 45.636719 9.847656 45.636719 9.839844 45.636719 9.828125 C 45.636719 9.808594 45.636719 9.785156 45.636719 9.765625 C 45.625 9.753906 45.617188 9.746094 45.605469 9.734375 C 45.605469 9.714844 45.605469 9.691406 45.605469 9.671875 C 45.605469 9.660156 45.605469 9.652344 45.605469 9.640625 C 45.597656 9.621094 45.585938 9.597656 45.574219 9.578125 C 45.5625 9.566406 45.554688 9.558594 45.542969 9.546875 C 45.542969 9.527344 45.542969 9.507813 45.542969 9.488281 C 45.53125 9.476563 45.523438 9.46875 45.511719 9.457031 C 45.503906 9.4375 45.492188 9.414063 45.480469 9.394531 C 45.46875 9.382813 45.460938 9.375 45.449219 9.363281 C 45.4375 9.351563 45.429688 9.34375 45.417969 9.332031 C 45.410156 9.3125 45.398438 9.289063 45.386719 9.269531 C 45.375 9.257813 45.367188 9.25 45.355469 9.238281 C 45.34375 9.226563 45.335938 9.21875 45.324219 9.207031 C 45.3125 9.195313 45.304688 9.1875 45.292969 9.175781 C 45.28125 9.164063 45.273438 9.15625 45.261719 9.144531 L 45.167969 9.082031 C 45.152344 9.058594 45.132813 9.039063 45.109375 9.023438 L 39.308594 4.183594 C 39.136719 4.046875 38.914063 3.96875 38.691406 3.96875 L 25.019531 3.96875 C 24.917969 3.941406 24.8125 3.929688 24.707031 3.9375 Z M 11.285156 5.953125 L 23.808594 5.953125 L 23.808594 8.929688 L 7.71875 8.929688 Z M 25.792969 5.953125 L 38.320313 5.953125 L 41.882813 8.929688 L 25.792969 8.929688 Z M 5.953125 10.914063 L 43.652344 10.914063 L 43.652344 43.652344 L 5.953125 43.652344 Z M 21.328125 14.882813 C 19.957031 14.882813 18.847656 15.988281 18.847656 17.359375 C 18.847656 18.734375 19.957031 19.839844 21.328125 19.839844 L 28.273438 19.839844 C 29.644531 19.839844 30.753906 18.734375 30.753906 17.359375 C 30.753906 15.988281 29.644531 14.882813 28.273438 14.882813 Z M 21.328125 16.863281 L 28.273438 16.863281 C 28.488281 16.863281 28.769531 17.148438 28.769531 17.359375 C 28.769531 17.574219 28.488281 17.855469 28.273438 17.855469 L 21.328125 17.855469 C 21.117188 17.855469 20.832031 17.574219 20.832031 17.359375 C 20.832031 17.148438 21.117188 16.863281 21.328125 16.863281 Z M 30.753906 30.753906 L 27.777344 33.730469 L 29.761719 33.730469 L 29.761719 37.699219 L 31.746094 37.699219 L 31.746094 33.730469 L 33.730469 33.730469 Z M 37.699219 30.753906 L 34.722656 33.730469 L 36.707031 33.730469 L 36.707031 37.699219 L 38.691406 37.699219 L 38.691406 33.730469 L 40.675781 33.730469 Z M 27.777344 38.691406 L 27.777344 40.675781 L 40.675781 40.675781 L 40.675781 38.691406 Z "/>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex gap-5 flex-wrap lg:flex-nowrap w-full">
            <div class="bg-white p-8 mt-8 rounded-xl w-full">
                <canvas id="myChart"></canvas>
            </div>
            <div class="bg-white p-8 mt-8 rounded-xl w-full">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>
        <!-- Top Ten Products -->
        <div class="flex gap-5 flex-wrap lg:flex-nowrap w-full">
            <div class="bg-white p-8 mt-8 rounded-xl w-full">
                <canvas id="topTenProductChart"></canvas>
            </div>
            <div class="bg-white p-8 mt-8 rounded-xl w-full">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        <script>
            const ctx = document.getElementById('myChart');
            const ctx2 = document.getElementById('incomeChart');
            const ctx3 = document.getElementById('topTenProductChart');
            const ctx4 = document.getElementById('categoriesChart');


            new Chart(ctx, {
                type: 'line', // Mengubah tipe grafik menjadi line
                data: {
                    labels: @json($months), // Menggunakan data bulan dari controller
                    datasets: [{
                        label: 'Total Transactions',
                        data: @json($totals), // Menggunakan data total transaksi dari controller
                        borderColor: 'rgba(96, 139, 193, 1)',
                        backgroundColor: 'rgba(96, 139, 193, 0.3)',
                        borderWidth: 2,
                        fill: true, // Mengisi area di bawah garis
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 16,
                                }
                            },
                        },
                        title: {
                            display: true,
                            text: 'Rental amount by time of month',
                            font: {
                                size: 24,
                            }
                        }
                    },
                }
            });

            new Chart(ctx2, {
                type: 'line', // Mengubah tipe grafik menjadi line
                data: {
                    labels: @json($monthsIncome), // Menggunakan data bulan dari controller
                    datasets: [{
                        label: 'Total Income',
                        data: @json($totalsIncome), // Menggunakan data total transaksi dari controller
                        borderColor: 'rgba(96, 139, 193, 1)',
                        backgroundColor: 'rgba(96, 139, 193, 0.3)',
                        borderWidth: 2,
                        fill: true, // Mengisi area di bawah garis
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 16,
                                }
                            },
                        },
                        title: {
                            display: true,
                            text: 'Income amount by time of month',
                            font: {
                                size: 24,
                            }
                        }
                    },
                }
            });

            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: @json($topTenProducts->pluck('product.name')),
                    datasets: [{
                        data: @json($topTenProducts->pluck('total_sales')),
                        // borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: [
                            'rgba(96, 139, 193, 1)',
                            'rgba(96, 139, 193, 0.9)',
                            'rgba(96, 139, 193, 0.8)',
                            'rgba(96, 139, 193, 0.7)',
                            'rgba(96, 139, 193, 0.6)',
                            'rgba(96, 139, 193, 0.5)',
                            'rgba(96, 139, 193, 0.4)',
                            'rgba(96, 139, 193, 0.3)',
                            'rgba(96, 139, 193, 0.2)',
                            'rgba(96, 139, 193, 0.1)',
                        ],
                        hoverOffset: 4,
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 16,
                                }
                            },
                        },
                        title: {
                            display: true,
                            text: 'Top Ten Products',
                            font: {
                                size: 24,
                            }
                        },
                        datalabels: {
                            color: 'black', // Warna label
                            anchor: 'center', // Posisi label
                            align: 'end', // Penempatan label
                            formatter: (value, context) => {
                                return value; // Menampilkan nilai
                            }
                        }
                    },
                },
                plugins: [ChartDataLabels] // Menambahkan plugin datalabels
            });


            new Chart(ctx4, {
                type: 'pie',
                data: {
                    labels: @json($transactions->pluck('category_name')), // Menggunakan data bulan dari controller
                    datasets: [{
                        data: @json($transactions->pluck('total_transactions')), // Menggunakan data total transaksi dari controller
                        // borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: [
                            'rgba(96, 139, 193, 1)', // Pastel Merah Muda
                            'rgba(96, 139, 193, 0.9)', // Pastel Hijau
                            'rgba(96, 139, 193, 0.8)', // Pastel Biru
                            'rgba(96, 139, 193, 0.7)', // Pastel Kuning
                            'rgba(96, 139, 193, 0.6)', // Pastel Ungu
                            'rgba(96, 139, 193, 0.5)', // Pastel Cyan
                            'rgba(96, 139, 193, 0.4)', // Pastel Coral
                            'rgba(96, 139, 193, 0.3)', // Pastel Lavender
                        ],
                        hoverOffset: 4,
                        borderWidth: 2,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 16,
                                },
                            },
                        },
                        title: {
                            display: true,
                            text: 'Top Categories Products',
                            font: {
                                size: 24,
                            }
                        },
                        datalabels: {
                            color: 'black', // Warna label
                            anchor: 'center', // Posisi label
                            align: 'end', // Penempatan label
                            formatter: (value, context) => {
                                return value; // Menampilkan nilai
                            }
                        }
                    },
                },
                plugins: [ChartDataLabels]
            });
        </script>
    </x-slot>
</x-app-layout>
