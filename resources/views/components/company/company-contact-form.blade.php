<form id="company-contact-form" action="{{ route('conversations.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="receiver_id" value="{{$seller->user->id}}">
    <input type="hidden" name="user_type" value="{{$seller->user->user_type}}">
    <div class="modal-body gry-bg px-3 pt-3">
        <div class="form-group  mb-3">
            <input type="text" class="form-control" name="title" value=""
                placeholder="{{ translate('Your Name') }}" >
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <textarea class="form-control" rows="8" name="message" 
                placeholder="{{ translate('Your Question') }}"></textarea>
            @error('message')
                <small class="text-danger">{{ $message }}</small>
            @enderror    
        </div>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-block btn-primary transition-3d-hover" value="{{ translate('Send') }}"></button>


        <div class="fs-15 fw-600 text-center mt-3 w-100">
        
            <small>This information will be kept private at all times
                <img src="https://uxwing.com/wp-content/themes/uxwing/download/01-user_interface/success-green-check-mark.png" style="width: 15px;">
            </small>
        </div>
    </div>
</form>
