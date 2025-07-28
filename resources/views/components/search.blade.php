<div>
    <div class="input-group">
        <input
            type="{{ isset($type) && $type ? $type : 'text'}}"
            class="form-control"
            placeholder=""
            name="search"
            value="{{ (Request::get('search')) ? Request::get('search') : ''  }}">

        @if(
            (Request::get('search') && Request::get('search') != '')
            || (Request::get('filter') && Request::get('filter') != '')
        )
        <button
            type="button"
            class="btn btn-outline-secondary"
            id="reset-search">
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
        @endif

        <button
            type="submit"
            class="btn btn-outline-secondary">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        @if(isset($advanced) && $advanced)
        <button
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#modal-search"
            id="advance-search"
            class="btn btn-outline-secondary">
            <i class="fa-solid fa-sliders"></i>
        </button>
        @endif
    </div>

    @push('script')
    <script>
        $("#reset-search").click(function() {
            let form = $(this).closest('form')
            let formUrl = form.attr('action')
            window.location = formUrl
        })
    </script>
    @endpush
</div>
