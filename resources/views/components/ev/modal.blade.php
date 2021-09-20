<!-- Modal Trigger -->
<a class="btn btn-{{ $color }} transition-3d-hover {{ $btnClass }}" href="javascript:;" data-toggle="modal" data-target="#{{ $id }}">{{ $btnText }}</a>
<!-- End Modal Trigger -->

<!-- Add New Card Modal -->
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{ $dialogClass }}" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h4 id="addNewCardModalTitle" class="modal-title">{{ $headerTitle }}</h4>
                <div class="modal-close">
                    <button type="button" class="btn btn-icon btn-xs btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
                        <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="modal-body {{ $bodyClass }}">
                {!! $slot !!}
            </div>
            <!-- End Body -->
        </div>
    </div>
</div>
<!-- End Add New Card Modal -->
