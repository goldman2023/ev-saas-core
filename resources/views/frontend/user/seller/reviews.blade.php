@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Reviews') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Rating') }}</th>
                        <th data-breakpoints="lg">{{ translate('Comment') }}</th>
                        <th data-breakpoints="lg">{{ translate('Published') }}</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- TODO: Make nothing found label centered if there is no reviews --}}
                    @foreach ($review_relationships as $key => $relationship)
                        @php
                            $review = $relationship->review;
                        @endphp
                        @if ($review != null)
                            <tr>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ renderStarRating($review->rating, 5) }}
                                </td>
                                <td>{{ $review->comment }}</td>
                                <td>
                                    @if ($review->status == 1)
                                        <span
                                            class="badge badge-inline badge-success">{{ translate('Published') }}</span>
                                    @else
                                        <span
                                            class="badge badge-inline badge-danger">{{ translate('Unpublished') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $review_relationships->links() }}
            </div>
        </div>
    </div>

@endsection
