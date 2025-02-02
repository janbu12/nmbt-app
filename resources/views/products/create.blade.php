<x-app-layout title="{{$page_meta['title']}}" bodyClass="bg-tertiery3 items-center">
    <form id="createForm" action="{{ $page_meta['url'] }}" method="POST" enctype="multipart/form-data" class="flex flex-col mt-[5rem] md:mt-0">
        @csrf

        {{-- Main Product Info --}}
        <div class="bg-white flex flex-col px-8 py-8 gap-4 rounded-lg w-full max-w-2xl mt-5">
            <h1 class="text-tertiery1 text-2xl font-semibold">Create Product</h1>
            <div class="flex w-full gap-4">
                <div class="flex flex-col w-full gap-2">
                    <label for="">Product Name <span class="text-red-700">*</span></label>
                    <input class="input input-bordered w-full" type="text" name="name" placeholder="Product Name" required>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="">Product Category <span class="text-red-700">*</span></label>
                    <select name="category_id" class="select select-bordered w-full" required>
                        <option value="" disabled selected>Select a Category <span class="text-red-700">*</span></option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex flex-col w-full gap-2">
                <label for="">Teaser Of Product <span class="text-red-700">*</span></label>
                <input class="input input-bordered w-full" type="text" name="teaser" placeholder="Teaser" required>
                <p class="text-sm text-gray-600">A product teaser is a brief, enticing description designed to spark curiosity and highlight the key appeal of a product without revealing too much.</p>
            </div>
        </div>

        {{-- Detail Product --}}
        <div class="bg-white flex flex-col px-8 py-8 gap-4 rounded-lg w-full max-w-2xl my-5">
            <h1 class="text-tertiery1 text-2xl font-semibold">Details Product</h1>
            <div class="flex flex-col gap-2">
                <label for="">Description Product</label>
                <textarea name="description" placeholder="Description" class="textarea textarea-bordered" rows="7" required></textarea>
            </div>
            <div class="flex gap-4">
                <div class="flex flex-col w-full gap-2">
                    <label for="">Price <span class="text-red-700">*</span></label>
                    <input class="input input-bordered w-full" type="number" name="price" step="0.01" placeholder="Price" required>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="">Stok <span class="text-red-700">*</span></label>
                    <input class="input input-bordered w-full" type="number" name="stock" placeholder="Stock" required>
                </div>
            </div>

            {{-- Photo --}}
            <div class="flex justify-center flex-col items-center gap-4 my-5">
                <h2 class="text-tertiery1 text-2xl font-semibold">Product Images</h2>
                {{--  Kotak Foto Besar  --}}
                <label for="imageUser" class="w-full h-full rounded-lg border border-dashed border-gray-900/25  py-10 cursor-pointer group flex flex-col items-center">
                        <div class="relative w-96 h-96 mb-4">
                            <div class="w-full h-full overflow-hidden group-hover:scale-105 transition delay-75 rounded-lg">
                                <img id="previewMain" src="{{ asset('images/photo-icon1.png') }}" alt="Main Picture" class="w-full h-full object-cover">
                            </div>
                        </div>

                        {{--  Kotak Foto Kecil --}}
                        <div class="flex gap-4">
                            @for ($i = 1; $i <= 4; $i++)
                            <div class="w-20 h-20 border border-dashed group-hover:border-solid border-gray-300 rounded-lg group-hover:border-gray-400 transition delay-75 overflow-hidden">
                                <img id="preview{{$i}}" src="{{ asset('images/photo-icon1.png') }}" alt="Additional Picture {{$i}}" class="w-full h-full object-cover">
                            </div>
                            @endfor
                        </div>
                </label>
                {{-- Input File --}}
                <input
                    type="file"
                    id="imageUser"
                    name="images[]"
                    multiple
                    accept="image/*"
                    required
                    class="file-input file-input-bordered w-full max-w-xs hidden"
                    onchange="validateFileInput(event)"
                />
                <p class="text-sm text-gray-600">Please upload 1-5 images (JPEG, PNG, JPG) with a maximum size of 2MB each.</p>
            </div>

            {{-- Submit Button --}}
            <div class="m-auto">
                <x-button variant="secondary" type="submit" class="max-w-fit" loading="none">Submit</x-button>
            </div>
        </div>
    </form>
    <x-slot name="scripts">
        <script>
            function validateFileInput(event) {
                const files = event.target.files;
                const allowedExtensions = ["image/jpeg", "image/png", "image/jpg", "image/webp"];
                const maxFileSize = 2 * 1024 * 1024; // 2MB
                const maxImages = 5;

                let isValid = true;
                let errorMessage = "";

                // Reset the previews
                document.getElementById("previewMain").src = "{{ asset('images/photo-icon1.png') }}";
                for (let i = 1; i <= 4; i++) {
                    document.getElementById("preview" + i).src = "{{ asset('images/photo-icon1.png') }}";
                }

                // Validate each file
                Array.from(files).forEach((file, index) => {
                    if (!allowedExtensions.includes(file.type)) {
                        isValid = false;
                        errorMessage = "Only PNG, JPEG, WEBP, or JPG files are allowed.";
                    } else if (file.size > maxFileSize) {
                        isValid = false;
                        errorMessage = "Each file must not exceed 2MB.";
                    }

                    // Stop further checks if invalid
                    if (!isValid) return;
                });

                if (files.length > maxImages) {
                    isValid = false;
                    errorMessage = "You can only upload a maximum of 5 images.";
                }

                if (!isValid) {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: errorMessage,
                        showConfirmButton: false,
                        timer: 2000,
                    });
                    event.target.value = "";
                    return;
                }

                // If valid, display previews
                Array.from(files).slice(0, maxImages).forEach((file, index) => {
                    const imageUrl = URL.createObjectURL(file);
                    if (index === 0) {
                        document.getElementById("previewMain").src = imageUrl;
                    } else if (index <= 4) {
                        document.getElementById("preview" + index).src = imageUrl;
                    }
                });
            }

            // Show Message Success
            @if (session('success'))
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "{{ session('success') }}",
                        showConfirmButton: false,
                        timer: 2000,
                    });
                });
            @endif

            document.getElementById('createForm').addEventListener('submit', function (event) {
                event.preventDefault();
                Alpine.store('loadingState').showLoading();
                this.submit();
            })
        </script>
    </x-slot>
</x-app-layout>
