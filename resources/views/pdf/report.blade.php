<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Template</title>

    @vite('resources/css/app.css')

    <!-- Highcharts JS -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>
<body class="antialiased flex flex-col h-screen text-sm font-sans text-gray-700 tracking-tight">
    {{-- Header: This contains the company logo, name,
         address and other contact information. --}}
    <div class="w-full bg-gradient-to-t from-slate-200 via-white">
        <div class="container flex justify-between w-full mx-auto p-8">
            {{-- Company Info --}}
            <div class="flex flex-col justify-between w-5/12">
                {{-- Example company logo --}}
                <div class="mb-2 w-16 h-16">
                    <svg xmlns="http://www.w3.org/2000/svg" width="62" height="62" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-boxes"><path d="M2.97 12.92A2 2 0 0 0 2 14.63v3.24a2 2 0 0 0 .97 1.71l3 1.8a2 2 0 0 0 2.06 0L12 19v-5.5l-5-3-4.03 2.42Z"/><path d="m7 16.5-4.74-2.85"/><path d="m7 16.5 5-3"/><path d="M7 16.5v5.17"/><path d="M12 13.5V19l3.97 2.38a2 2 0 0 0 2.06 0l3-1.8a2 2 0 0 0 .97-1.71v-3.24a2 2 0 0 0-.97-1.71L17 10.5l-5 3Z"/><path d="m17 16.5-5-3"/><path d="m17 16.5 4.74-2.85"/><path d="M17 16.5v5.17"/><path d="M7.97 4.42A2 2 0 0 0 7 6.13v4.37l5 3 5-3V6.13a2 2 0 0 0-.97-1.71l-3-1.8a2 2 0 0 0-2.06 0l-3 1.8Z"/><path d="M12 8 7.26 5.15"/><path d="m12 8 4.74-2.85"/><path d="M12 13.5V8"/></svg>
                </div>

                {{-- Company name, address --}}
                <div class="flex flex-col gap-y-4">
                    <span class="flex flex-col font-bold">
                        <span class="text-base">{{ $name }}</span>
                        <span class="font-normal text-[10px] text-gray-500">Absolutely fictional incorporation</span>
                    </span>
                </div>
            </div>

            <div class="flex flex-col justify-between text-[10px]">
                <div class="flex">
                    <span class="font-light">Date Make Report: {{ now()->format('l, F j, Y') }}</span>
                </div>

                {{-- Contacts --}}
                <div class="flex flex-col">
                    <p>Address: {{ $address }}</p>
                    <p>Phone: {{ $phone }}</p>
                    <p>Email: {{ $email }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- @dump($topTenProducts) --}}

    <div class="container mx-auto px-8 mt-8">
        <h3 class="font-bold text-base">Summary</h3>
        <p>Total Product Quantity Rented: <span class="font-medium">{{ $quantityRentTotal }}</span></p>
        <p>Total Rents: <span class="font-medium">{{ $totalBorrowed }}</span></p>
        <p>Total Ongoing Rents: <span class="font-medium">{{ $ongoingRent }}</span></p>
        <p>Total Renting Rents: <span class="font-medium">{{ $totalRenting }}</span></p>
        <p>Total Done Rents: <span class="font-medium">{{ $doneRents }}</span></p>
        <p>Total Income: <span class="font-medium">Rp. {{ number_format($totalIncome, 2, ',', '.') }}</span></p>
    </div>

    <div class="container mx-auto my-8">
        <div class="flex flex-col w-full">
            <div id="topTenProductChart" class="w-full"></div>
            <div id="categoriesChart" class="w-full"></div>
        </div>
    </div>

    <div class="container mx-auto px-8 mt-8">
        <h1 class="font-bold text-base">Total Income</h1>
        <li class="text-[12px] font-bold mt-1 text-sky-500">By Month</li>
        <table class="table w-full text-[12px]">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th class="text-right">Income</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($incomeByMonth as $data)
                    <tr>
                        <td>{{ $no++}}</td>
                        <td>{{ $data['formatted_date'] }}</td>
                        <td class="text-right">Rp. {{ number_format($data['income'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <li class="text-[12px] font-bold mt-1 text-sky-500">By Day</li>
        <div class="w-full">
            <table class="table w-full text-[12px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Date</th>
                        <th class="text-right">Income</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($incomeByDay as $data)
                        <tr>
                            <td>{{ $no++}}</td>
                            <td>{{ $data['formatted_date'] }}</td>
                            <td class="text-right">Rp. {{ number_format($data['income'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container mx-auto px-8 mt-8">
        <h1 class="font-bold text-base">Total Rents</h1>
        <li class="text-[12px] font-bold mt-1 text-sky-500">By Month</li>
        <table class="table w-full text-[12px]">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th class="text-right">Number of Rents</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($rentsByMonth as $data)
                    <tr>
                        <td>{{ $no++}}</td>
                        <td>{{ $data['formatted_date'] }}</td>
                        <td class="text-right">{{ $data['rents'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <li class="text-[12px] font-bold mt-1 text-sky-500">By Day</li>
        <table class="table w-full text-[12px]">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th class="text-right">Income</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($rentsByDay as $data)
                    <tr>
                        <td>{{ $no++}}</td>
                        <td>{{ $data['formatted_date'] }}</td>
                        <td class="text-right">{{ $data['rents'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        const topTenProducts = @json($topTenProducts);

        const productsArray = Object.values(topTenProducts).map(item => ({
            name: item.product.name,
            total_sales: parseInt(item.total_sales) // Ensure total_sales is a number
        }));

        const chartData = productsArray.map((product, index) => ({
            name: product.name,
            y: product.total_sales,
            // sliced: index === 0
        })).sort((a, b) => b.y - a.y);

        // Top Ten Products Chart
        Highcharts.chart('topTenProductChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Top Ten Products'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                animation: {
                        duration: 0
                },
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '12px',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [{
                name: 'Products',
                colorByPoint: true,
                animation: {
                        duration: 0
                },
                data: chartData,
            }]
        });

        // Categories Chart
        Highcharts.chart('categoriesChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Top Categories Products'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                animation: {
                    duration: 0
                },
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '12px',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [{
                name: 'Categories',
                colorByPoint: true,
                animation: {
                        duration: 0
                },
                data: @json(collect($transactions)->map(function($transaction) {
                    return ['name' => $transaction['category_name'], 'y' => $transaction['total_transactions']];
                }))
            }]
        });
    </script>
</body>
</html>
