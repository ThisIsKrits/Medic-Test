@php
    $iteration = (!isset($iteration) || $iteration == true) ? true : false;
    $action = (!isset($action) || $action == true) ? true : false;
@endphp

<div class="table-responsive">
    <table id="{{ $idtable }}" class="table table-bordered table-striped mt-3">
        <thead class="tableHead thead-dark text-center" >
            <tr>
                @if($iteration)
                <th width="10px">No</th>
                @endif
                @foreach($fields as $key => $data)
                @continue(isset($data['collapsed']) && $data['collapsed'])
                @continue(isset($data['show_on']) && !in_array('table', $data['show_on']) )
                <th
                    class="s-{{ $key }} {{ $data['is_show'] }}
                    @if(isset($data['col_class']))
                    {{ $data['col_class'] }}
                    @else
                    {{ 'text-start' }}
                    @endif
                    ">
                    @if(isset($indexUrl) && isset($data['order']))
                    <span>
                        @php
                        $direction = 'asc';

                        if(isset(request()->order) && request()->order == $data['order']) {
                            $direction = (!isset(request()->direction) || request()->direction == 'asc') ? 'desc' : 'asc' ;
                        }

                        @endphp
                        <a href="{{ route($indexUrl, [
                            ...request()->all(),
                            'order' => $data['order'],
                            'direction' => $direction,
                            ]) }}"
                        class="btn btn-link p-0">
                            @if(isset(request()->order) && request()->order == $data['order'])
                            <i
                                class="fa-solid
                                {{ (!isset(request()->direction) || request()->direction == 'asc')
                                    ? 'fa-arrow-down-a-z'
                                    : 'fa-arrow-down-z-a'
                                }}
                                text-primary">
                            </i>
                            @else
                            <i class="fa-solid fa-arrow-down-a-z text-secondary"></i>
                            @endif
                        </a>
                    </span>
                    @endif
                    {{ $data['label'] }}
                </th>
                @endforeach
                @if($action)
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if(isset($items))
            @forelse($items as $item)
            <tr data-id="{{ $item->id }}">
                @if($iteration)
                @if(isset($items->perPage))
                <td>{{ $loop->iteration + $items->firstItem() - 1 }}</td>
                @else
                <td>{{ $loop->iteration }}</td>
                @endif
                @endif
                @foreach($fields as $key => $data)
                @continue(isset($data['collapsed']) && $data['collapsed'])
                @continue(isset($data['show_on']) && !in_array('table', $data['show_on']) )
                <td class="
                    s-{{ $key }}
                    {{ $data['is_show'] }}
                    @isset($data['col_class'])
                    {{ $data['col_class'] }}
                    @endisset
                    @isset($data['is_color'])
                    {{ $data['is_color'] }}
                    @endisset
                    ">
                    @if(isset($data['col_link']))
                    <a href="{{ $item->{$data['col_link']} }}" class="btn-link">
                        @if($data['type'] == 'date' && $item->$key)
                        {{ human_date($item->$key) }}
                        @elseif($data['type'] == 'number' && is_numeric($item->$key))
                            @if(isset($data['numeric_string']) && $data['numeric_string'] == true)
                            {{ $item->$key }}
                            @else
                            {{ human_number((float) $item->$key) }}
                            @endif
                        @elseif(strip_tags($item->$key))
                        {!! $item->$key !!}
                        @else
                        {!! $item->$key !!}
                        @endif
                    </a>
                    @else
                        @if(isset($data['style_font']) && $data['style_font'] == 'checklist')
                        {!! $item->{$key.'_checklist'} !!}
                        @elseif($data['type'] == 'date' && $item->$key)
                        {{ human_date($item->$key) }}
                        @elseif($data['type'] == 'number' && is_numeric($item->$key))
                            @if(isset($data['numeric_string']) && $data['numeric_string'] == true)
                            {{ $item->$key }}
                            @else
                            {{ human_number((float) $item->$key) }}
                            @endif
                        @elseif(strip_tags($item->$key))
                        {!! $item->$key !!}
                        @else
                        {!! $item->$key !!}
                        @endif
                    @endif
                </td>
                @endforeach
                @if($action)
                <td class="text-center">
                    <x-action-group-button
                        editurl="{{ isset($editurl) && $editurl ? route($editurl, $item) : '' }}"
                        showurl="{{ isset($showurl) && $showurl ? route($showurl, $item) : '' }}"
                        destroyurl="{{ isset($destroyurl) && $destroyurl ? route($destroyurl, $item) : '' }}"
                        destroyClass="{{ isset($destroyClass) && $destroyClass ? $destroyClass : '' }}"
                        delTargetModal="{{ isset($delTargetModal) ? $delTargetModal : '' }}"
                        refnama="{{ $item->$refnama }}"/>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="{{ (count($fields) + 2) }}">Data tidak ditemukan</td>
            </tr>
            @endforelse
            @else
            <tr>
                <td class="text-center" colspan="{{ (count($fields) + 2) }}">Data tidak ditemukan</td>
            </tr>
            @endif
        </tbody>
        @isset($footer)
        <tfoot>
            <tr>
                @foreach($footer as $foot)
                <td
                    @isset($foot['class'])
                        class="{{ $foot['class'] }}"
                    @endisset
                    @isset($foot['colspan'])
                        colspan="{{ $foot['colspan'] }}"
                    @endisset>
                    {{ $foot['label'] }}
                </td>
                @endforeach
            </tr>
        </tfoot>
        @endisset
    </table>
    @isset($items)
    @if(
        $items instanceof \Illuminate\Pagination\Paginator ||
        $items instanceof \Illuminate\Pagination\LengthAwarePaginator
    )
    <div class="pb-0 small footer-pagination">
        {{ $items->withQueryString()->links('pagination::bootstrap-4') }}
    </div>
    @endif
    @endisset
</div>
