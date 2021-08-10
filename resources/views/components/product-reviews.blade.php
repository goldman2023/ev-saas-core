 <ul class="list-group list-group-flush">
                                    
                                        @foreach ($detailedProduct->reviews as $key => $review)
                                            @if ($review->user != null)
                                                <li class="media list-group-item d-flex">

                                                    <span class="avatar avatar-md mr-3">
                                                        <img class="lazyload"
                                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                            @if ($review->user->avatar_original != null) data-src="{{ uploaded_asset($review->user->avatar_original) }}"
                                                        @else
                                                                    data-src="{{ uploaded_asset('assets/img/placeholder.jpg') }}" @endif>
                                                    </span>
                                                    <div class="media-body">
                                                        <div class="d-flex justify-content-between">
                                                            <h3 class="fs-15 fw-600 mb-0">{{ $review->user->name }}</h3>
                                                            <span class="rating rating-sm">
                                                                @for ($i = 0; $i < $review->rating; $i++)
                                                                    <i class="las la-star active"></i>
                                                                @endfor
                                                                @for ($i = 0; $i < 5 - $review->rating; $i++)
                                                                    <i class="las la-star"></i>
                                                                @endfor
                                                            </span>
                                                        </div>
                                                        <div class="opacity-60 mb-2">
                                                            {{ date('d-m-Y', strtotime($review->created_at)) }}</div>
                                                        <p class="comment-text">
                                                            {{ $review->comment }}
                                                        </p>
                                                    </div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>

                                    @if (count($detailedProduct->reviews) <= 0)
                                        <div class="text-center fs-18 opacity-70">
                                            {{ translate('There have been no reviews for this product yet.') }}
                                        </div>
                                    @endif
