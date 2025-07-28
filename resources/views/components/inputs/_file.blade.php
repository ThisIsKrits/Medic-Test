<div class="form-group">
    {{-- Input File --}}
    <input type="{{ $field['type'] }}"
        class="form-control @error($field['key']) is-invalid @enderror mt-2"
        id="{{ $field['key'] }}"
        name="{{ $field['key'] }}"
        accept="image/*"
        onchange="previewImage(this, '{{ $field['key'] }}')"
        @if($field['required'] == 1) required @endif>

        {{-- Preview Gambar Sebelumnya --}}
        <div id="{{ $field['key'] }}-preview" class="mt-2">
            @if (!empty($item->{$field['key']}))
                <img src="{{ asset($item->{$field['key']}) }}"
                    alt="{{ $field['key'] }} image"
                    class="img-thumbnail"
                    width="80px">

                {{-- Button Hapus Logo --}}
                <button type="button" class="btn btn-danger mt-2" id="{{ $field['key'] }}-delete-btn">
                    Hapus Logo
                </button>
            @endif
        </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#{{ $field['key'] }}-delete-btn').click(function() {
            var imagePath = '{{ $item->{$field['key']} }}';

            if (confirm('Apakah Anda yakin ingin menghapus logo ini?')) {
                $.ajax({
                    url: "{{ route('system.profile-company.destroy',profile()->id) }}",
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}",
                        logo: imagePath
                    },
                    success: function(response) {
                        if (response.success) {
                            // Menghapus preview gambar dan tombol hapus
                            $('#{{ $field['key'] }}-preview').html('');
                            alert('Logo berhasil dihapus');
                        } else {
                            alert('Terjadi kesalahan saat menghapus logo');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan');
                    }
                });
            }
        });
    });
</script>
