<tr class="upload-file-row">
    <td>
        <span class="input-group-text rounded-0">{{ isset($index) ? $index : request()->rows }}</span>
    </td>
    <td>
        <input
            type="file"
            id="file-{{ $index }}"
            name="file[image][]"
            class="form-control"
            accept="image/*,application/pdf">
    </td>
    <td>
        @if($item->document)
            <div id="file-preview" class="file-preview mt-2">
                @if($item->type == 'pdf')
                <a
                    href="{{ asset('storage/document/' . $item->document) }}"
                    class="btn btn-sm btn-link mb-1 py-0"
                    target="_blank">
                    <h1><i class="fa-regular fa-file-pdf text-danger"></i></h1>
                </a>
                @else
                <img src="{{ Storage::url('document/' . $item->document) }}" alt="document" >
                @endif
            </div>
        @else
            <div id="file-preview" class="mt-2"></div>
        @endif
    </td>
    <td>
        <input
            type="hidden"
            class="form-control rounded-0"
            name="file[id][]"
            value="{{ $item->id }}">
        <button
            type="button"
            class="form-control rounded-0 del-attach-file"
            ref-url="{{ route("checkup-file.destroy", $item->id) }}"
            ref-nama="Pemeriksaan-{{ $index }}">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
