<x-app-layout title="Edit Profile" bodyClass="bg-tertiery3 items-center gap-4">
    <div class="py-8 gap-3 bg-white min-w-[400px] flex flex-col items-center rounded-lg drop-shadow-md">
        <h1 class=" text-xl font-semibold w-full text-center">Edit Profile</h1>
        <form action="{{route('user.profile.update')}}" method="POST" class="w-full max-w-md px-6">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-4">
                <label for="name">Firstname</label>
                <x-input-text type="text" id="firstname" name="firstname" value="{{Auth::user()->firstname}}" class="w-full px-3 py-2 rounded-md" required></x-input-text>
                <label for="lastname">Lastname:</label>
                <x-input-text type="text" id="lastname" name="lastname" value="{{Auth::user()->lastname}}" class="w-full px-3 py-2 rounded-md" required></x-input-text>

                <label for="email">Email:</label>
                <x-input-text type="email" id="email" name="email" value="{{Auth::user()->email}}" class="w-full px-3 py-2 rounded-md" required></x-input-text>

                <label for="password">New Password:</label>
                <x-input-text type="password" id="password" name="password" class="w-full px-3 py-2 rounded-md"></x-input-text>

                <label for="password_confirmation">Confirm New Password:</label>
                <x-input-text type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 rounded-md"></x-input-text>
                @if ($errors->any())
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
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
</x-app-layout>
