<div class="modal-body">
    <p> Anda akan menghapus data
        <span class="text-capitalize text-danger font-weight-bolder" id="nama_delete"></span>
         dari daftar {{ $title }}?</p>

</div>
<div class="modal-footer">
    <form id="form-deleted" action="" method="POST">
        @method('delete')
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-delete-data">Hapus</button>
    </form>
    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Tutup</button>
</div>
