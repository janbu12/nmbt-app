<x-app-layout title="Category" bodyClass="bg-tertiery3 w-full lg:overflow-hidden h-screen">
    <div class="p-3 justify-between flex flex-row">
        <form action="{{ route('category.index') }}" method="GET">
            <input
            @keydown.enter="Alpine.store('loadingState').showLoading();"
             type="text" 
             name="search" 
             class="p-3 rounded-lg border border-tertiery1 hover:cursor-text" 
             placeholder="Search" 
             value="{{ request('search') }}" />
        </form>

        <div>
            <x-button onclick="openModal('addCategoryModal')">Add a Category</x-button>
        </div>
    </div>

    @if (count($categories) > 0)
        <div class="w-full grid grid-cols-3 justify-between p-3 gap-4 max-h-screen overflow-auto">
            @foreach ($categories as $cat)
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">{{ $cat->category_name }}</h2>
                    <p>Total: {{ $cat->products_count }}</p>
                    <div class="card-actions justify-end">
                        <x-button variant="secondary" class="btn btn-primary text-lg" onclick="openEditModal('{{ $cat->id }}', '{{ $cat->category_name }}')">Edit</x-button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="w-full p-3 text-center text-lg">
            No categories found.
        </div>
    @endif
    
    <!-- Modal Tambah Kategori -->
    <div id="addCategoryModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center" x-data="{ isLoading: false }">
        <div class="bg-white p-5 rounded-lg shadow-lg w-1/3">
            <h2 class="text-lg font-semibold mb-3">Add Category</h2>
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <input type="text" name="category_name" class="w-full p-2 border rounded-lg" placeholder="Category Name" required>
                <div class="flex justify-end mt-3">
                    <button type="button" class="px-4 py-2 bg-gray-400 rounded-lg mr-2" onclick="closeModal('addCategoryModal')">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="editCategoryModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex items-center justify-center" x-data="{ isLoading: false }">
        <div class="bg-white p-5 rounded-lg shadow-lg w-1/3">
            <h2 class="text-lg font-semibold mb-3">Edit Category</h2>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editCategoryId" name="id">
                <input type="text" id="editCategoryName" name="category_name" class="w-full p-2 border rounded-lg" required>
                <div class="flex justify-end mt-3">
                    <button type="button" class="px-4 py-2 bg-gray-400 rounded-lg mr-2" onclick="closeModal('editCategoryModal')">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        Alpine.store('loadingState', {
            isLoading: false,
            showLoading() { 
                this.isLoading = true; 
                console.log("Loading Started"); 
            },
            hideLoading() { 
                this.isLoading = false; 
                console.log("Loading Stopped"); 
            }
        });
    
        function openModal(modalId) {
            console.log("Opening Modal:", modalId);
            document.getElementById(modalId).classList.remove('hidden');

            setTimeout(() => {
                Alpine.store('loadingState').hideLoading();
            }, 500);
        }

        function closeModal(modalId) {
            console.log("Closing Modal:", modalId);
            document.getElementById(modalId).classList.add('hidden');

            setTimeout(() => {
                Alpine.store('loadingState').hideLoading();
                console.log("Loading Stopped from closeModal");
            }, 500);
        }

        function openEditModal(id, name) {
            console.log("Editing Category:", id, name);
            Alpine.store('loadingState').hideLoading();
            document.getElementById('editCategoryId').value = id;
            document.getElementById('editCategoryName').value = name;
            document.getElementById('editCategoryForm').action = `/admin/category/${id}`;
            
            openModal('editCategoryModal');
        }
    
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll("form").forEach(form => {
                form.addEventListener("submit", function (event) {
                    Alpine.store("loadingState").showLoading();

                    setTimeout(() => {
                        Alpine.store("loadingState").hideLoading();
                    }, 3000);
                });

                form.addEventListener("load", function () {
                    Alpine.store("loadingState").hideLoading();
                    console.log("Loading Stopped after form submission");
                });

                form.addEventListener("error", function () {
                    Alpine.store("loadingState").hideLoading();
                    console.log("Loading Stopped due to error");
                });
            });
        });

    </script>
      
</x-app-layout>
