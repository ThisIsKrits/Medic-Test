<tr class="upload-file-row">
    <td>
        <span class="input-group-text rounded-0">{{ request()->rows }}</span>
    </td>
    <td>
        <input
            type="file"
            id="file-{{ request()->rows }}"
            name="file[document][]"
            class="form-control rounded-0"
            accept="image/*,application/pdf">
    </td>
    <td>
        <div id="file-preview" class="mt-2"></div>
    </td>
    <td>
        <button type="button" class="form-control rounded-0 del-file-form" style="display: none;"><i class="fa fa-trash"></i></button>
    </td>
</tr>
