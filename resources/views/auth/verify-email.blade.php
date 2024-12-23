<x-app-layout>
    <div class="max-w-7xl mx-auto py-6">
        <h1 class="text-2xl font-bold">Verify Your Email</h1>
        <p>We have sent a verification email to your address. Please check your inbox and click the verification link.</p>
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">Resend Verification Email</button>
        </form>
    </div>
</x-app-layout>
