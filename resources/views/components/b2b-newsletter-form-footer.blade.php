 <h4 class="fs-13 fw-600 text-white">
    {{ translate('Join Our Newsletter') }}
</h4>

<div class="d-inline-block d-md-block">
    <form class="form d-flex align-items-center" method="POST" action="{{ route('subscribers.store') }}">
        @csrf
        <div class="form-group mb-0">
            <input type="email" class="form-control"
                placeholder="{{ translate('Your Email Address') }}" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">
            {{ translate('Subscribe') }}
        </button>
    </form>
</div>