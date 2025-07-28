<div>
    <div
        class="modal fade"
        tabindex="-1"
        aria-hidden="true"
        data-bs-backdrop="stacked"
        {{ $attributes }}>
        <div class="modal-dialog {{ isset($size) ? $size : '' }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-label">{{ $label }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @isset($content)
                @include($content)
                @endisset
                {{ $slot }}
                <div id="ajax-content"></div>
            </div>
        </div>
    </div>
</div>
