<x-app-layout title="Register" bodyClass="bg-tertiery3 justify-center items-center min-h-screen gap-4 p-4 text-tertiery1">
    <a @click="Alpine.store('loadingState').showLoading();" class="hover:scale-110 hover:-translate-y-2 transition duration-300" href="/">
        <img src="{{asset('images/Logo.png')}}" alt="Logo.png" class="max-w-16 drop-shadow-md">
    </a>
    <form  method="POST" action="{{route('auth.register.action')}}" class="bg-white drop-shadow-sm rounded-3xl p-5 flex flex-col md:px-10 md:py-5">
        @csrf
        <div class="flex justify-center">
            <h1 class="text-center font-semibold text-tertiery1 text-2xl">Sign Up</h1>
        </div>
        <div class="flex flex-col w-full md:min-w-[480px] gap-4 py-8">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex flex-col w-full gap-2">
                    <label for="" class="font-medium">Firstname</label>
                    <x-input-text name="firstname" placeholder="Enter Your Firstname"></x-input-text>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <label for="" class="font-medium">Lastname</label>
                    <x-input-text name="lastname" placeholder="Enter Your Lastname"></x-input-text>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="font-medium">Email</label>
                <x-input-text name="email" placeholder="Enter Your Email"></x-input-text>
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="font-medium">Password</label>
                <x-input-text type="password" name="password" placeholder="Enter Your Password"></x-input-text>
                <span class="text-slate-400 text-xs">Must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number.</span>
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="font-medium">Confirm Password</label>
                <x-input-text type="password" name="password_confirmation" placeholder="Confirm Your Password"></x-input-text>
            </div>
        </div>
        <div class="flex flex-col items-center gap-6">
                <div>
                    <x-button variant="secondary" type="submit">Sign Up</x-button>
                </div>
                <p class="text-center text-slate-400">Already have an account?<a @click="Alpine.store('loadingState').showLoading();" href="/login" class="text-tertiery1 hover:text-secondary1"> Sign in</a></p>
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
</x-app-layout>
