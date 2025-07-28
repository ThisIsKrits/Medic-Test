<div class="card mb-3">
    <div class="card-body">
        <div class="row mb-3">
            @foreach($fields as $key => $prop)
            @continue(isset($prop['collapsed']) && $prop['collapsed'])
            @continue(isset($prop['show_on']) && !in_array('show', $prop['show_on']))
            @continue(isset($prop['show_when']) && !in_array($item->{$prop['show_when']['key']}, $prop['show_when']['value']))
            <div class="col-lg-4 col-md-4 col-6 mb-2">
                <div class="form-group">
                    <b>{{ $prop['label'] }}</b>
                    @if($prop['type'] ==  'date' && $item->$key)
                    <div>{{ human_date($item->$key) }}</div>
                    @elseif($prop['type'] == 'number' && is_numeric($item->$key))
                        @if(isset($prop['numeric_string']) && $prop['numeric_string'] == true)
                            <div>{{ $item->$key }}</div>
                        @else
                            <div>{{ human_number($item->$key) }}</div>
                        @endif
                    @elseif (isset($prop['text_class']))
                    <div class="{{ $prop['text_class'] }}">{{ $item->$key }}</div>
                    @elseif(strip_tags($item->$key))
                    <div>{!! $item->$key !!}</div>
                    @else
                    <div>{{ $item->$key ?? '-' }}</div>
                    @endif
                </div>
            </div>

            @endforeach
        </div>
    </div>
</div>
