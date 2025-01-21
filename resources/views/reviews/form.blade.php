<x-app-layout bodyClass="bg-tertiery3 min-h-screen items-center">
    @if ($errors->any())
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="toast toast-end z-50">
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
    <div class="container mt-[4.5rem] flex flex-col items-center justify-center md:mt-8">
        <form action="{{ route('orders.submitReview', $rent->id) }}" method="POST" class="bg-white p-5 rounded-md w-full min-h-screen md:min-h-fit md:w-1/2">
            @csrf
            <h1 class="mb-4">Review Pesanan #{{ $rent->id }}</h1>
            @foreach ($rent->rent_details as $detail)
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row justify-between p-3 bg-white drop-shadow rounded-md">
                        <div class="flex flex-col w-full items-center md:items-start">
                            <h2>{{ $detail->product->name }}</h2>
                            @if ($detail->product->images->first())
                                <img src="{{ asset('storage/' . $detail->product->images->first()->image_path) }}" alt="{{ $detail->product->name }}" class="w-32 h-32">
                            @else
                                <img src="{{ asset('images/produk-icon-dummy.png') }}" alt="icon-dummy.png" class="w-32 h-32">
                            @endif
                        </div>
                        <div class="flex flex-col items-center md:items-end justify-center w-full">
                            <h1>Comment:</h1>
                            <textarea
                                class="w-full h-full p-2 disabled:bg-white text-center md:text-end"
                                name="reviews[{{ $loop->index }}][comment]"
                                rows="3"
                                placeholder="Tulis komentar..."
                                style="resize: none;"
                                @if (@isset($detail->product->reviews->first()->comment))
                                    disabled
                                @endif
                            >{{ optional($detail->product->reviews->first())->comment ?? 'Barang bagus, bersih, dll' }}
                            </textarea>
                            <input type="hidden" id="rating-input-{{ $loop->index }}" name="reviews[{{ $loop->index }}][rating]" value="{{ optional($detail->product->reviews->first())->rating ?? '' }}">
                            <div class="flex space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button" class="text-gray-300 hover:text-yellow-500 text-2xl star" id="star{{ $i }}-{{ $loop->index }}" data-index="{{ $loop->index }}"
                                        @if(optional($detail->product->reviews->first())->rating >= $i) style="color: #eab308;" @endif>&#9733;</button>
                                @endfor
                            </div>
                            <input type="hidden" name="reviews[{{ $loop->index }}][product_id]" value="{{ $detail->product_id }}">
                        </div>
                    </div>
                </div>
            @endforeach

            @if (!@isset($detail->product->reviews->first()->comment))
                <div class="flex w-full justify-end">
                    <x-button type="submit" variant="secondary">
                        Kirim Review
                    </x-button>
                </div>
            @endif
        </form>
    </div>

    <script>
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                const stars = document.querySelectorAll(`button[id^="star"][id$="-${index}"]`);
                const ratingInput = document.getElementById(`rating-input-${index}`);

                stars.forEach((s, i) => {
                    s.classList.toggle('text-yellow-500', i < this.id.replace('star', '').split('-')[0]);
                    s.classList.toggle('text-gray-300', i >= this.id.replace('star', '').split('-')[0]);
                });

                ratingInput.value = this.id.replace('star', '').split('-')[0]; // Set rating value
            });
        });
    </script>

    <style>
        .star {
            font-size: 24px; /* Ukuran bintang */
        }
    </style>
</x-app-layout>
