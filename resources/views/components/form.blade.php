@php
$editPage = is_editpage();
@endphp
<div class="section">
    <div class="row">
        @foreach($formFields as $cards)
        <div class="{{ $cards['class'] }} mb-3">
            <div class="card">
                <div class="card-body">
                    @foreach($cards['fields'] as $rows)
                    <div class="{{ $rows['class'] }}">
                        @foreach($rows['fields'] as $field)
                            @continue($editPage && isset($field['is_primary']) && $field['is_primary'])
                            @php
                            $defaultValue = isset($field['default_value']) ? $field['default_value'] : '';
                            @endphp
                            <div
                                @if(isset($field['class_edited']) && $editPage)
                                class="{{ $field['class_edited'] }} mb-3"
                                @elseif(isset($field['class']))
                                class="{{ $field['class'] }} mb-3"
                                @else
                                class="col-12 col-lg-6 col-md-6 col-sm-12 mb-3"
                                @endif>
                                <div class="form-group">
                                    @if(!isset($field['no_label']) || (isset($field['no_label']) && $field['no_label'] == false))
                                    <label
                                        class="form-label form-{{ $field['key'] }}
                                        @if($field['required'] == 1)
                                        {{ 'text-danger' }}
                                        @elseif($field['required'] == 2)
                                        {{ 'text-primary' }}
                                        @endif">
                                        {{ $field['label'] }}
                                        @if($field['required'] != 0)
                                            <sup>*</sup>
                                        @endif
                                    </label>
                                    @endif

                                    @if($field['type'] == 'select')
                                        @include('components.inputs._select')
                                    @elseif($field['type'] == 'text-area')
                                        @include('components.inputs._text-area')
                                    @elseif($field['type'] == 'checkbox')
                                        @include('components.inputs._checkbox')
                                    @elseif($field['type'] == 'number')
                                        @include('components.inputs._number')
                                    @elseif($field['type'] == 'password')
                                        @include('components.inputs._password')
                                    @elseif($field['type'] == 'file')
                                        @include('components.inputs._file')
                                    @else
                                        @include('components.inputs._text')
                                    @endif

                                    @error($field['key'])
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
        @if(!isset($withoutButton) || !$withoutButton)
            <div class="col-12 d-flex justify-content-end">
                <x-button-save />
            </div>
        @endif
    </div>
</div>
