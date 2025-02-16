<x-app-layout bodyClass="bg-tertiery3 text-tertiery1 min-h-screen">
    <div class="container overflow-y-auto mx-auto mt-[5.5rem] md:mt-8 my-6 p-4 bg-white rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Users</h1>

        <table class="table w-full">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>Age</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-200 cursor-pointer" onclick="openModal({{ $user->id }})">
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->firstname . ' ' . $user->lastname }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->birthdate)->age }}</td>
                        <td>{{ $user->gender == 'm' ? 'Male' : 'Female' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links('pagination::custom-pagination') }} <!-- Menampilkan pagination -->
        </div>
    </div>

    <!-- Modal -->
    <div id="transactionModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50" onclick="closeModal(event)">
        <div class="bg-white rounded-lg p-6 w-auto h-[70%] overflow-y-auto" onclick="event.stopPropagation()"> <!-- Menghentikan propagasi klik -->
            <div id="modalContent">
                <!-- Konten riwayat transaksi akan dimuat di sini -->
            </div>
            <button onclick="closeModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Close</button>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            // Mengonversi data pengguna menjadi array JSON
            const users = @json($users->items()); // Mengambil data pengguna yang ditampilkan di halaman

            function openModal(userId) {
                const selectedUser = users.find(u => u.id === userId); // Mencari pengguna berdasarkan ID

                const modalContent = document.getElementById('modalContent');
                modalContent.innerHTML = ''; // Kosongkan konten sebelumnya

                // Menampilkan nama lengkap pengguna
                const fullName = selectedUser.firstname + ' ' + selectedUser.lastname;
                modalContent.innerHTML += `<h2 class="text-xl font-bold mb-2">Transactions History of ${fullName}</h2>`;

                // Menampilkan riwayat transaksi
                if (selectedUser && selectedUser.rent && selectedUser.rent.length > 0) {
                    let tableHTML = `
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>Pickup Date</th>
                                    <th>Return Date</th>
                                    <th>Status Rent</th>
                                    <th>Total Price</th>
                                    <th>Payment Method</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    selectedUser.rent.forEach(transaction => {
                        tableHTML += `
                            <tr class="hover:bg-gray-200">
                                <td>${transaction.pickup_date}</td>
                                <td>${transaction.return_date}</td>
                                <td>${transaction.status_rent}</td>
                                <td>${transaction.total_price}</td>
                                <td>${transaction.payment_method}</td>
                                <td>${formatDate(transaction.created_at)}</td>
                                <td>${formatDate(transaction.updated_at)}</td>
                            </tr>
                        `;
                    });

                    tableHTML += `
                            </tbody>
                        </table>
                    `;

                    modalContent.innerHTML += tableHTML;
                } else {
                    modalContent.innerHTML += '<p>No transactions found.</p>'; // Jika tidak ada transaksi
                }

                // Tampilkan modal
                document.getElementById('transactionModal').classList.remove('hidden');
            }

            function closeModal(event) {
                // Hanya menutup modal jika klik terjadi di luar konten modal
                if (event) {
                    const modal = document.getElementById('transactionModal');
                    if (event.target === modal) {
                        modal.classList.add('hidden');
                    }
                } else {
                    document.getElementById('transactionModal').classList.add('hidden');
                }
            }

            function formatDate(dateString) {
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return new Date(dateString).toLocaleDateString(undefined, options);
            }
        </script>
    </x-slot>
</x-app-layout>
