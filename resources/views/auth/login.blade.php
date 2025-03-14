<x-app-layout title="Login" bodyClass="bg-tertiery3 justify-center items-center min-h-screen w-full gap-4 text-tertiery1 p-4 md:">
    <a @click="Alpine.store('loadingState').showLoading();" class="hover:scale-110 hover:-translate-y-2 transition duration-300" href="/">
        <img src="{{asset('images/Logo.png')}}" alt="Logo.png" class="max-w-20 md:max-w-28 drop-shadow-md">
    </a>
    <form method="POST" action="{{route('auth.login.action')}}" class="bg-white w-full md:w-fit p-5 drop-shadow-sm rounded-3xl flex flex-col md:px-10 md:py-5">
        @csrf
        <div class="flex justify-center">
            <h1 class="text-center font-semibold text-tertiery1 text-2xl">Sign In</h1>
        </div>
        <div class="flex flex-col w-full md:min-w-[450px] gap-4 py-8">
            <div class="flex flex-col gap-2">
                <label for="" class="font-medium">Email</label>
                <x-input-text name="email" placeholder="Enter Your Email"></x-input-text>
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="font-medium">Password</label>
                <x-input-text type="password" name="password" placeholder="Enter Your Password"></x-input-text>
                <div class="flex justify-between px-2">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" checked class="mr-2 cursor-pointer" />
                        <label for="remember" class="text-sm text-slate-400 cursor-pointer">Remember Me</label>
                    </div>
                    <a href="/forgot-password" class="hidden md:block text-end text-sm text-slate-400 hover:text-tertiery1">Forgot Your Password ?</a>
                </div>
            </div>

        </div>
        <div class="flex flex-col items-center gap-6">
                <div>
                    <x-button variant="secondary" type="submit">Sign In</x-button>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <a @click="Alpine.store('loadingState').showLoading();" href="/forgot-password" class="block md:hidden text-end text-sm text-slate-400 hover:text-tertiery1">Forgot Your Password ?</a>
                    <p class="text-center text-slate-400">Don't have an account?<a @click="Alpine.store('loadingState').showLoading();" href="/register" class="text-tertiery1 hover:text-secondary1"> Sign up</a></p>
                </div>
        </div>
    </form>

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="toast toast-end">
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
