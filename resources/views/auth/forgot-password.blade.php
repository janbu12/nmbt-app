<x-app-layout title="Forgot Password" bodyClass="bg-tertiery3 justify-center items-center min-h-screen gap-4 text-tertiery1">
    <a class="hover:scale-110 hover:-translate-y-2 transition duration-300" href="/">
        <img src="{{asset('images/Logo.png')}}" alt="Logo.png" class="max-w-28 drop-shadow-md">
    </a>
    <form method="POST" action="{{ route('password.email') }}" class="bg-white drop-shadow-sm rounded-3xl flex flex-col px-10 py-5">
        @csrf
        <div class="flex justify-center">
            <h1 class="text-center font-semibold text-tertiery1 text-2xl">Forgot Password</h1>
        </div>
        <div class="flex flex-col min-w-[450px] gap-4 py-8">
            <div class="flex flex-col gap-2">
                <label for="email" class="font-medium">Email</label>
                <x-input-text name="email" placeholder="Enter Your Email"></x-input-text>
            </div>
        </div>
        <div class="flex flex-col items-center gap-6">
            <div>
                <x-button variant="secondary" type="submit">Send Password Reset Link</x-button>
            </div>
        </div>
    </form>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="toast toast-end" x-data="{ show: true }" x-init="setTimeout(() => show = false, 2500)" x-show="show">
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

    <script>
        @if (session('status'))
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "{{ session('status') }}",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                });
            @endif
    </script>
</x-app-layout>
