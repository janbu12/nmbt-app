<x-app-layout title="Reset Password" bodyClass="bg-tertiery3 justify-center items-center h-screen gap-4 text-tertiery1">
    <form method="POST" action="{{ route('password.update') }}" class="bg-white drop-shadow-sm rounded-3xl flex flex-col px-10 py-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="flex justify-center">
            <h1 class="text-center font-semibold text-tertiery1 text-2xl">Reset Password</h1>
        </div>
        <div class="flex flex-col min-w-[450px] gap-4 py-8">
            <div class="flex flex-col gap-2">
                <label for="password" class="font-medium">New Password</label>
                <x-input-text type="password" name="password" placeholder="Enter Your New Password" required></x-input-text>
            </div>
            <div class="flex flex-col gap-2">
                <label for="password_confirmation" class="font-medium">Confirm Password</label>
                <x-input-text type="password" name="password_confirmation" placeholder="Confirm Your New Password" required></x-input-text>
            </div>
        </div>
        <div class="flex flex-col items-center gap-6">
            <div>
                <x-button variant="secondary" type="submit">Reset Password</x-button>
            </div>
        </div>
    </form>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="toast toast-end" x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show">
            @foreach ($errors->all() as $error)
                <div class="alert alert-error">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 shrink-0 stroke-current"
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
</x-app-layout>
