<div>
    <div class="btn-group" role="group">
        @if(isset($editurl) && $editurl != '')
            @include('components._default-edit-button')
        @endif
        @if(isset($showurl) && $showurl != '')
            @include('components._default-show-button')
        @endif
        @if(isset($destroyurl) && $destroyurl != '')
            @include('components._default-destroy-button')
        @endif
    </div>
</div>
