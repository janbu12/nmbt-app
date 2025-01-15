<x-app-layout bodyClass="bg-tertiery3 min-h-screen">
    <div class="max-w-7xl m-auto">
        <div class="h-full bg-white p-6 rounded-lg flex flex-col gap-3">
            <h1 class="text-2xl font-bold">Verify Your Email</h1>
            <p>We have sent a verification email to your address. Please check your inbox and click the verification link.</p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-button type="submit" variant="secondary">Resend Verification Email</x-button>
            </form>
        </div>
    </div>
</x-app-layout>
