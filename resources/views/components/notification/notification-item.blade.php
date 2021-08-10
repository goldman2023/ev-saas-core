@php
    $user = \App\Models\User::where('id', $notification->data['subject_id'])->first();
@endphp
<!-- Item -->

@if($user)
    <li class="list-group-item custom-checkbox-list-wrapper">
        <div class="row">
            <div class="col-auto position-static">
                <div class="d-flex align-items-center">
                    <div class="custom-control custom-checkbox custom-checkbox-list">
                        <input type="checkbox" class="custom-control-input" id="{{ $notification->id }}"
                               @if($notification->read_at == null) checked @endif>
                        <label class="custom-control-label"></label>
                    </div>
                </div>
            </div>
            <div class="col ml-n3">
                <span class="card-title h5">{{ $user->shop->name }}</span>
                @switch($notification->type)
                    @case('App\Models\Notifications\NewCompanyJoin')
                    <p class="card-text font-size-sm">{{ translate('has been joined to B2BWood Club.') }}</p>
                    @break
                    @case('App\Models\Notifications\CompanyVisit')
                    <p class="card-text font-size-sm">{{ translate('visited your company profile.') }}</p>
                    @break
                    @default
                    <p class="card-text font-size-sm"></p>
                @endswitch
            </div>
            <small class="col-auto text-muted text-cap">{{ $notification->created_at->diffForHumans() }}</small>
        </div>
        <a class="stretched-link" href="#"></a>
    </li>
    <!-- End Item -->
@endif
