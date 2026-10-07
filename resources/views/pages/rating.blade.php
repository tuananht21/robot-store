<div class="mt-8 rounded-2xl bg-white p-6 shadow-sm sm:p-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Đánh giá sản phẩm</h2>
            <p class="mt-1 text-sm text-gray-500">
                {{ $reviewCount }} đánh giá
            </p>
        </div>

        @if ($reviewCount > 0)
            <div class="text-left sm:text-right">
                <p class="text-3xl font-bold text-gray-900">
                    {{ $averageRating }}/5
                </p>

                <div class="mt-1 text-yellow-400">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-solid fa-star {{ $i <= round($averageRating) ? '' : 'text-gray-300' }}"></i>
                    @endfor
                </div>
            </div>
        @endif
    </div>

    @if ($reviews->count())
        <div class="mt-6 space-y-5">
            @foreach ($reviews as $review)
                <div class="border-b border-gray-200 pb-5 last:border-0 last:pb-0">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold text-gray-900">
                                {{ $review->detailOrder?->order?->customer_name ?? 'Khách hàng' }}
                            </p>

                            <div class="mt-1 text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                        </div>

                        <span class="text-sm text-gray-400">
                            {{ $review->created_at?->format('d/m/Y') }}
                        </span>
                    </div>

                    @if ($review->content)
                        <p class="mt-3 leading-7 text-gray-600">
                            {{ $review->content }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="mt-6 rounded-xl bg-gray-50 px-5 py-8 text-center">
            <i class="fa-regular fa-comment-dots text-3xl text-gray-400"></i>

            <p class="mt-3 text-gray-500">
                Sản phẩm chưa có đánh giá nào.
            </p>
        </div>
    @endif
</div>