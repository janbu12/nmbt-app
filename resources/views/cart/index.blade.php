<x-app-layout title="Cart" bodyClass="lg:bg-tertiery3 gap-1 min-h-screen">
    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed p-2 min-w-full lg:min-w-fit lg:toast lg:toast-end z-50">
            <div class="alert alert-error">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0 stroke-current hidden lg:block"
                    fill="none"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @elseif ($errors->any())
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed p-2 min-w-full lg:min-w-fit lg:toast toast-end z-50">
            @foreach ($errors->all() as $error)
                <div class="alert alert-error">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 shrink-0 stroke-current hidden lg:block"
                        fill="none"
                        viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $error }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-[4.5rem] md:mt-0 lg:py-5 lg:px-10 flex flex-col lg:flex-row lg:gap-10 lg:min-h-fit lg:h-full">
        {{-- @dump($rules->harga_sewa) --}}

        {{-- Section Item --}}
        <div class="flex flex-col bg-white w-full h-full lg:h-fit lg:max-h-[500px] overflow-y-auto lg:rounded-lg lg:drop-shadow-lg text-tertiery1">

            <div class="p-3 flex flex-row justify-between items-center pb-3 drop-shadow-md sticky top-0 bg-white">
                <div class="text-lg lg:text-2xl font-medium">
                    Cart ({{ count($cartItems) }} item(s))
                </div>
                <button id="check" class="p-2 bg-secondary3 hover:bg-tertiery3 rounded-lg text-white">
                    Select All
                </button>
            </div>
            @if ($cartItems->count() > 0)
                @foreach ($cartItems as $item)
                    <div class="p-3 flex items-center py-4 ">
                        <div class="flex items-center">
                            <input type="checkbox"
                                name="selected_items[]"
                                id="checkbox"
                                value="{{ $item->id }}"
                                data-price="{{ $item->product->price }}"
                                data-quantity="{{ $item->quantity }}"
                                class="mr-2 size-4"
                                >
                        </div>
                        <div class="h-28 w-36 border-4 rounded-lg flex flex-col text-center">
                            @if($item->product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/produk-icon-dummy.png') }}" alt="icon-dummy.png" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="flex flex-col px-3 w-full">
                            <div class="font-medium text-base lg:text-2xl">
                                {{ $item->product->name }}
                            </div>
                            <div class="flex w-full mt-2 lg:mt-0 justify-between">
                                <div class="flex text-base lg:text-lg">
                                    Rp. {{ number_format($item->product->price, 0, ',', '.') }}
                                </div>
                                <div class="flex flex-row gap-2">
                                    <form id="decreaseForm" action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity- 1 }}">
                                        <button class="py-1 px-2 border-2 rounded-lg">
                                            -
                                        </button>
                                    </form>

                                    <div class="py-1 px-2 border-2 rounded-lg">
                                        {{ $item->quantity }}
                                    </div>

                                    <form id="increaseForm" action="{{ route('cart.update', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('patch')
                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                        <button class="py-1 px-2 border-2 rounded-lg">
                                            +
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="flex w-full h-full justify-end mt-2 lg:mt-0 lg:justify-between lg:items-end">
                                <div class="hidden lg:block text-2xl align-baseline">
                                    Rp. {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                </div>

                                <form id="deleteForm" action="{{  route('cart.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('delete')
                                        <button class="border rounded-xl bg-secondary3 hover:bg-tertiery3 text-white font-medium py-2 px-3" id="hapus">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
                @else
                <div class="py-4 text-center text-lg font-medium">
                    Cart Empty, Let's Go Hiking!
                </div>
            @endif
        </div>

        {{-- Section Detail --}}
        <div class="p-3 shadow-up flex flex-col bottom-0 bg-white w-full h-fit lg:h-full lg:rounded-lg lg:drop-shadow-lg text-tertiery1">
            <div class="flex items-center justify-between">
                <div class="hidden lg:block text-2xl font-medium">
                    Payment
                </div>
                <div>
                    Operational hours 07.00 - 19.00 WIB
                </div>
            </div>
            <hr class="hidden lg:block">
            <div class="flex flex-col h-fit lg:h-full">
                <div class="flex flex-col lg:py-3">
                    <div class="flex flex-wrap lg:flex-nowrap w-full py-2 items-center gap-3 lg:gap-4">
                        <div class="w-full">
                            <label for="pickup_date">Pickup Date</label>
                            <input type="date" name="pickup_date" id="pickup_date" class="border-4 rounded-xl p-2 w-full">
                        </div>
                        <span class="hidden lg:block">
                            -
                        </span>
                        <div class="w-full">
                            <label for="pickup_date">Return Date</label>
                            <input type="date" name="return_date" id="return_date" class="border-4 rounded-xl p-2 w-full">
                        </div>
                    </div>
                </div>
                <hr class="mt-2 lg:mt-0">
                <div class="hidden lg:flex py-3 text-2xl flex-row justify-between">
                    Subtotal
                    <div id="subtotal">
                        Rp. {{ $subtotal ?? 0 }}
                    </div>
                </div>
                <div class="flex mt-2 lg:mt-0 lg:py-3 text-base lg:text-2xl flex-row justify-between">
                    <div class="flex flex-row w-full lg:w-fit lg:flex-col justify-between lg:justify-start">
                        <div id="jumlah_hari">
                            Rent Duration: {{ $days ?? 0 }} days
                        </div>
                        <p class="text-end lg:text-start lg:text-sm" id="harga_harian">(Rp. {{ $totalPrice ?? 0 }})</p>
                    </div>
                    <div class="hidden lg:block" id="harga_hari">
                        Rp. {{ $totalPrice ?? 0 }}
                    </div>
                </div>
                <div class="flex mt-2 lg:mt-0 lg:py-3 text-base lg:text-2xl flex-row justify-between">
                    Tax (11%)
                    <div id="pajak">
                        Rp. 0
                    </div>
                </div>
                <hr class="mt-2 lg:mt-0">
                <div class="flex py-3 text-lg lg:text-2xl flex-row justify-between">
                    Total
                    <div id="total">
                        Rp. 0
                    </div>
                </div>
                {{-- <div class="flex py-3 text-2xl items-center flex-row justify-between">
                    Subtotal
                    <div>
                        <select name="" id="" class="border rounded-lg p-2">
                            <option value="cod">COD</option>
                            <option value="transfer">Transfer</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                </div> --}}

                <div class="h-fit lg:h-full items-end flex mb-4 lg:mb-0">
                    <button id="checkoutButton" class="p-2 w-full rounded-lg bg-secondary3 hover:bg-primary3 text-white font-medium">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <form id="checkoutForm" action="{{ route('cart.invoice.index') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="pickup_date" id="checkoutPickupDate">
        <input type="hidden" name="return_date" id="checkoutReturnDate">
        <input type="hidden" name="selected_items[]" id="checkoutSelectedItems">
        <input type="hidden" name="quantities[]" id="checkoutQuantities">
    </form>

    <x-slot name="scripts">
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const checkAllButton = document.querySelector('#check');
                const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_items[]"]');
                const subtotalDisplay = document.getElementById('subtotal');
                const startDateInput = document.getElementById('pickup_date');
                const endDateInput = document.getElementById('return_date');
                const daysDisplay = document.getElementById('jumlah_hari');
                const hargaHari = document.getElementById('harga_hari');
                const hargaHarian = document.getElementById('harga_harian');
                const totalPajak = document.getElementById('pajak');
                const totalHargaDisplay = document.getElementById('total');
                const percentPajak = 0.11;

                const savedCheckboxes = JSON.parse(localStorage.getItem('selectedItems')) || [];
                checkboxes.forEach(checkbox => {
                    if (savedCheckboxes.includes(checkbox.value)) {
                        checkbox.checked = true;
                    }
                });

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        const selectedItems = Array.from(checkboxes)
                            .filter(checkbox => checkbox.checked)
                            .map(checkbox => checkbox.value);
                        localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
                    });
                });

                checkAllButton.addEventListener('click', () => {
                    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                    checkboxes.forEach(checkbox => checkbox.checked = !allChecked);

                    // Update local storage based on the current state of checkboxes
                    if (allChecked) {
                        // If all were checked, clear local storage
                        localStorage.removeItem('selectedItems');
                    } else {
                        // If not all were checked, save the current state
                        const selectedItems = Array.from(checkboxes)
                            .filter(checkbox => checkbox.checked)
                            .map(checkbox => checkbox.value);
                        localStorage.setItem('selectedItems', JSON.stringify(selectedItems));
                    }

                    // Recalculate total
                    calculateTotal();
                });

                // Utility function to format currency
                const formatCurrency = (value) => `Rp. ${Math.ceil(value).toLocaleString('id-ID')}`;

                // Calculate the subtotal of selected items
                const calculateSubtotal = () => {
                    let subtotal = Array.from(checkboxes)
                        .filter(checkbox => checkbox.checked)
                        .reduce((sum, checkbox) => {
                            const price = parseFloat(checkbox.getAttribute('data-price'));
                            const quantity = parseInt(checkbox.getAttribute('data-quantity'));
                            return sum + (price * quantity);
                        }, 0);

                    subtotalDisplay.textContent = formatCurrency(subtotal);
                    return subtotal;
                };

                // Calculate the total rental cost based on days
                const calculateDays = () => {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);
                    const subtotal = calculateSubtotal();

                    if (isNaN(startDate) || isNaN(endDate) || endDate < startDate) {
                        daysDisplay.textContent = 'Rent Duration: 0 days';
                        hargaHari.textContent = formatCurrency(0);
                        hargaHarian.textContent = formatCurrency(0);
                        totalPajak.textContent = formatCurrency(0);
                        return 0;
                    }

                    const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                    const hargaPerHari = days * {{ $rules->harga_sewa }};
                    const totalHargaHari = hargaPerHari + subtotal;
                    const pajak = totalHargaHari * percentPajak;

                    daysDisplay.textContent = `Rent Duration: ${days} days`;
                    hargaHari.textContent = formatCurrency(totalHargaHari);
                    hargaHarian.textContent = formatCurrency(hargaPerHari);
                    totalPajak.textContent = formatCurrency(pajak);

                    return totalHargaHari;
                };

                // Calculate the final total including tax
                const calculateTotal = () => {
                    const totalHargaHari = calculateDays();
                    const totalWithTax = totalHargaHari + (totalHargaHari * percentPajak);
                    totalHargaDisplay.textContent = formatCurrency(totalWithTax);
                };

                startDateInput.addEventListener('change', () => {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);
                    const nowDate = new Date();

                    startDate.setHours(23, 59, 59, 59);
                    endDate.setHours(23, 59, 59, 59);

                    // console.log(nowDate, startDate)

                    if ( startDate < nowDate) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "Pickup date can't be earlier than today.",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        startDateInput.value = '';
                    } else {
                        const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                        if (days < 1) {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Minimum rental duration is 1 days.",
                                showConfirmButton: false,
                                timer: 2000,
                            });
                            endDateInput.value = ''; // Reset end date
                        }
                    }
                });

                // Validate dates on change of end date
                endDateInput.addEventListener('change', () => {
                    const startDate = new Date(startDateInput.value);
                    const endDate = new Date(endDateInput.value);

                    startDate.setHours(23, 59, 59, 59);
                    endDate.setHours(23, 59, 59, 59);

                    // Validate end date
                    if (endDate < startDate) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "Return date can't be earlier than pickup date.",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        endDateInput.value = ''; // Reset end date
                    } else {
                        const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                        if (days < 1) {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Minimum rental duration is 1 days.",
                                showConfirmButton: false,
                                timer: 2000,
                            });
                            endDateInput.value = ''; // Reset end date
                        }
                    }
                });

                // Event listeners for individual checkbox changes
                checkboxes.forEach(checkbox => checkbox.addEventListener('change', calculateTotal));

                // Event listeners for date changes
                [startDateInput, endDateInput].forEach(input => input.addEventListener('change', calculateTotal));

                // Initial calculation
                calculateTotal();
            });

            document.addEventListener('DOMContentLoaded', () => {
                const checkoutButton = document.getElementById('checkoutButton');
                const checkboxes = document.querySelectorAll('input[type="checkbox"][name="selected_items[]"]');
                const startDateInput = document.getElementById('pickup_date');
                const endDateInput = document.getElementById('return_date');

                checkoutButton.addEventListener('click', () => {
                    const selectedItems = [];
                    const quantities = [];

                    checkboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            selectedItems.push(checkbox.value);
                            quantities.push(checkbox.getAttribute('data-quantity'));
                        }
                    });

                    // Clear previous values
                    document.getElementById('checkoutSelectedItems').value = '';
                    document.getElementById('checkoutQuantities').value = '';

                    // Hapus semua input tersembunyi sebelumnya
                    const checkoutForm = document.getElementById('checkoutForm');
                    checkoutForm.querySelectorAll('input[name="selected_items[]"], input[name="quantities[]"]').forEach(input => {
                        input.remove();
                    });

                    // Create hidden inputs for each selected item and quantity
                    selectedItems.forEach(item => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_items[]';
                        input.value = item;
                        checkoutForm.appendChild(input);
                    });

                    quantities.forEach(quantity => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'quantities[]';
                        input.value = quantity;
                        checkoutForm.appendChild(input);
                    });

                    // Set values to hidden inputs for dates
                    document.getElementById('checkoutPickupDate').value = startDateInput.value;
                    document.getElementById('checkoutReturnDate').value = endDateInput.value;

                     Alpine.store('loadingState').showLoading();
                    // Submit the form
                    checkoutForm.submit();
                });

                document.getElementById('deleteForm').addEventListener('submit', function (event) {
                    event.preventDefault();
                    Alpine.store('loadingState').showLoading();
                    this.submit();
                })

                document.getElementById('increaseForm').addEventListener('submit', function (event) {
                    event.preventDefault();
                    Alpine.store('loadingState').showLoading();
                    this.submit();
                })

                document.getElementById('decreaseForm').addEventListener('submit', function (event) {
                    event.preventDefault();
                    Alpine.store('loadingState').showLoading();
                    this.submit();
                })
            });


            @if($message != '')
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "{{ $message }}",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                });
            @endif
        </script>
    </x-slot>
</x-app-layout>


