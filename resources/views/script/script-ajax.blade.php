<script>
    $("#reset-search").click(function() {
        let form = $(this).closest('form')
        let formUrl = form.attr('action')
        window.location = formUrl
    })

    $(".btn-show-data").on('click',function() {
        console.log('test');

        let url = $(this).attr('ref-url')
        $.ajax({
            url: url,
            type: 'GET'
        }).done(function (data) {
            $("#modal-detail #ajax-content").html(data)
            $("#modal-detail").modal('show')
        });
    })

    $(".btn-delete-data").on('click',function() {
        $("#form-deleted").attr('action', $(this).attr('ref-url'))
        $("#nama_delete").text($(this).attr('ref-nama'))
    })
</script>
