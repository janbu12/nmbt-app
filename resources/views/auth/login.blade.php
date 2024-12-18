<x-app-layout title="Login" bodyClass="bg-tertiery3 justify-center items-center h-screen gap-4 text-tertiery1">
    <a class="hover:scale-110 hover:-translate-y-2 transition duration-300" href="/">
        <img src="{{asset('images/Logo.png')}}" alt="Logo.png" class="max-w-28 drop-shadow-md">
    </a>
    <div class="bg-white drop-shadow-sm rounded-3xl flex flex-col px-10 py-5">
        <div class="flex justify-center">
            <h1 class="text-center font-semibold text-tertiery1 text-2xl">Sign In</h1>
        </div>
        <div class="flex flex-col min-w-[450px] gap-4 py-8">
            <div class="flex flex-col gap-2">
                <label for="" class="font-medium">Email</label>
                <x-input-text name="email" placeholder="Enter Your Email"></x-input-text>
            </div>
            <div class="flex flex-col gap-2">
                <label for="" class="font-medium">Password</label>
                <x-input-text type="password" name="password" placeholder="Enter Your Password"></x-input-text>
                <a href="" class="text-end text-sm text-slate-400 hover:text-tertiery1">Forgot Your Password ?</a>
            </div>
        </div>
        <div class="flex flex-col items-center gap-6">
                <div>
                    <x-button variant="secondary">Sign In</x-button>
                </div>
                <p class="text-center text-slate-400">Don't have an account?<a href="/register" class="text-tertiery1 hover:text-secondary1"> Sign up</a></p>
        </div>
    </div>
</x-app-layout>
