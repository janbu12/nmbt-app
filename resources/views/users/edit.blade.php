<x-app-layout title="Edit Profile" bodyClass="bg-tertiery3 items-center gap-4">
    <div class="py-8 gap-3 bg-white w-full lg:max-w-2xl flex flex-col items-center rounded-lg drop-shadow-md">
        <h1 class=" text-xl font-semibold w-full text-center">Edit Profile</h1>
        <form action="{{route('user.profile.update')}}" method="POST" class="w-full px-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-4">

                {{-- Icon Input --}}
                <div class="flex justify-center">
                    <div class="relative w-24 h-24">
                        <label for="imageUser" class="cursor-pointer group">
                            <div class="w-full h-full rounded-full overflow-hidden border-2 border-gray-300 group-hover:border-gray-500 transition delay-75">
                                @if(Auth::user()->imageUser)
                                    <img id="imagePreview" src="{{ asset('storage/' . Auth::user()->imageUser) }}" alt="Profile Picture" class="w-full h-full object-cover">
                                @else
                                    <img id="imagePreview" src="{{asset('images/boy.png')}}" alt="Profile Picture" class="w-full h-full object-cover">
                                @endif
                            </div>
                        </label>
                        <input type="file" id="imageUser" name="imageUser" class="hidden">
                    </div>
                </div>

                {{-- Form Input --}}
                <div class="flex gap-4">
                    <div class="flex flex-col w-full gap-2">
                        <label for="name">Firstname</label>
                        <x-input-text type="text" id="firstname" name="firstname" value="{{Auth::user()->firstname}}" class="w-full px-3 py-2 rounded-md" required></x-input-text>
                    </div>
                    <div class="flex flex-col w-full gap-2">
                        <label for="name">Lastname</label>
                        <x-input-text type="text" id="lastname" name="lastname" value="{{Auth::user()->lastname}}" class="w-full px-3 py-2 rounded-md" required></x-input-text>
                    </div>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="email">Email</label>
                    <x-input-text type="email" id="email" name="email" value="{{Auth::user()->email}}" class="w-full px-3 py-2 rounded-md" required></x-input-text>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="password">New Password</label>
                    <x-input-text type="password" id="password" name="password" class="w-full px-3 py-2 rounded-md"></x-input-text>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="password_confirmation">Confirm New Password:</label>
                    <x-input-text type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 rounded-md"></x-input-text>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="address">Address</label>
                    <x-input-text type="text" id="address" name="address" value="{{ Auth::user()->address }}" class="w-full px-3 py-2 rounded-md" required></x-input-text>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="phone">Phone</label>
                    <x-input-text type="text" id="phone" name="phone" value="{{ Auth::user()->phone }}" class="w-full px-3 py-2 rounded-md" required></x-input-text>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="birthdate">Birthdate</label>
                    <x-input-text type="date" id="birthdate" name="birthdate" value="{{ Auth::user()->birthdate }}" class="w-full px-3 py-2 rounded-md" required></x-input-text>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" class="select select-bordered w-full">
                        <option disabled {{ is_null(Auth::user()->gender) ? 'selected' : '' }}>Choose your gender</option>
                        <option value="male" {{ Auth::user()->gender === 'm' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{Auth::user()->gender === 'f' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                {{-- Messages --}}
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                class="text-sm bg-red-500 text-white hover:bg-red-600 p-2 rounded-md"
                            >{{$error}}</li>
                        @endforeach
                    </ul>
                @elseif (session('success'))
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm bg-green-500 text-white hover:bg-green-600 p-2 rounded-md"
                    >{{session('success')}}</p>
                @endif

                <x-button type="submit">Update Profile</x-button>
            </div>
        </form>
    </div>

    <x-slot name="scripts">
        <script>
            document.getElementById('imageUser').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('imagePreview').src = URL.createObjectURL(file);
            }
        });
        </script>
    </x-slot>

</x-app-layout>

