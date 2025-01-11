<x-app-layout bodyClass="bg-tertiery3 text-tertiery1 min-h-screen">
    <div class="container mx-auto my-6 p-4 bg-white rounded-lg">
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
    <div id="transactionModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-11/12 md:w-1/3">
            <h2 class="text-xl font-bold mb-4">Transaction History</h2>
            <div id="modalContent">
                <!-- Konten riwayat transaksi akan dimuat di sini -->
            </div>
            <button onclick="closeModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Close</button>
        </div>
    </div>

    <script>
        // Mengonversi data pengguna menjadi array JSON
        const users = @json($users->items()); // Mengambil data pengguna yang ditampilkan di halaman

        function openModal(userId) {
            const selectedUser = users.find(u => u.id === userId); // Mencari pengguna berdasarkan ID

            const modalContent = document.getElementById('modalContent');
            modalContent.innerHTML = ''; // Kosongkan konten sebelumnya

            // Menampilkan riwayat transaksi
            if (selectedUser && selectedUser.rent) {
                selectedUser.rent.forEach(transaction => {
                    modalContent.innerHTML += `<p>${transaction.status_rent}</p>`; // Ganti dengan detail transaksi yang sesuai
                });
            } else {
                modalContent.innerHTML = '<p>No transactions found.</p>'; // Jika tidak ada transaksi
            }

            // Tampilkan modal
            document.getElementById('transactionModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('transactionModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
