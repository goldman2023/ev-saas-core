<a class="card card-hover-shadow mb-4" href="{{ $url }}">
    <div class="card-body">
        <div class="media align-items-center">
            <img class="avatar avatar-xl mr-4"
                src="{{ $img }}"
                alt="Image Description">

            <div class="media-body">
                <h3 class="text-hover-primary mb-1">
                    {{ $title }}
                </h3>
                <span class="text-body">{{ translate('Track your website statics') }}</span>
            </div>

            <div class="ml-2 text-right">
                <i class="tio-chevron-right tio-lg text-body text-hover-primary"></i>
            </div>
        </div>
        <!-- End Row -->
    </div>
</a>
