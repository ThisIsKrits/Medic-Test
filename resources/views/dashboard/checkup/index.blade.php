@extends('layouts.dashboard')
@push('title')
    {{ $title.' | '.config('app.name', 'Medic-Web') }}
@endpush
@section('content')
<div class="container-fluid" id="index-page">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>



    <div class="card shadow mb-4" >
        <div class="card-body">
            <div class="d-flex justify-content-end p-3">
                <a href="{{ route('checkup.create') }}" class="btn btn-sm btn-outline-primary" id="btn-add">Tambah</a>
            </div>
            <div class="d-flex justify-content-end p-3">
                <form action="{{ route('checkup.index') }}" method="GET">
                    <x-search />
                </form>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                @include('components._table',[
                    'idtable' => 'table-checkup',
                    'editurl' => 'checkup.edit',
                    'showurl' => 'checkup.show',
                    'destroyurl' => 'checkup.destroy',
                    'refnama' => 'nopmer',
                ])
            </div>
        </div>
    </div>
</div>

<div class="p-0" id="form-page"></div>

<x-modal id="modal-detail" label="Detail {{ $title }}" size="modal-xl"/>
<x-modal id="modal-delete" label="Hapus {{ $title }}">
    @include('components._modal-destroy')
</x-modal>
@endsection
@push('script')
<script>
    let rowDetail   = 1
    let rowFile   = 1

    $("#btn-add").click(function(e) {
        e.preventDefault();
        let url = $(this).attr('href')

        getAjax(url, function(data) {
            $("#index-page").fadeOut('slow', function() {
                $("#form-page").html(data)
                $("#form-page").fadeIn(function(){
                    enableButton("#btn-add")
                })
                evenForm()
            })
        })
    })

    $(".btn-edit-data").click(function(e) {
        e.preventDefault();
        let url = $(this).attr('href')

        getAjax(url, function(data) {
            $("#index-page").fadeOut('slow', function() {
                $("#form-page").html(data)
                $("#form-page").fadeIn(function(){
                    enableButton(".btn-edit-data")
                })
                rowDetail = $("#content-detail").attr('ref-idx')
                evenForm(true)

                handleDeleteDetail()
                handleDeleteDocument()

                for(let i = 1; i <= rowFile; i++) {
                    documents(i)
                }

                setSelect2()
                eventDetailForm()
                eventDetailDocument()
            })
        })
    })

    function evenForm(edited = false) {
        $('.select2').select2({
            dropdownParent: $('#content-detail'),
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            theme: "bootstrap-5",
            containerCssClass: "wrap"
        })

        let url     = $("#add-content-detail").attr('ref-url')
        let urlDoc  = $("#add-content-document").attr('ref-url')

        if(!edited) {
            getDetailForm(url, rowDetail);
            getDocumentUpload(urlDoc, rowFile);
        }

        $("#add-content-detail").click(function() {
            rowDetail++;
            getDetailForm(url, rowDetail)
        })

        $("#add-content-document").click(function() {
            rowFile++;
            getDocumentUpload(urlDoc, rowFile)
        })

        $("#btn-back").click(function(e) {
            e.preventDefault()
            $("#form-page").fadeOut('slow', function() {
                $("#form-page").html('')
                $("#index-page").fadeIn('slow')
            })
        })

    }

    function getDetailForm(url, request = false) {
        $.ajax({
            url: url,
            type: 'GET',
            data : {
                rows : request
            }
        }).done(function (data) {
            $("#content-detail").append(data)
            setSelect2()
            eventDetailForm(request)

        });
    }


    function getDocumentUpload(url, request = false) {
        $.ajax({
            url: url,
            type: 'GET',
            data : {
                rows : request
            }
        }).done(function (data) {
            $("#content-document").append(data)
            eventDetailDocument(request)
        });
    }

    function setSelect2() {
        $('.detail-select').select2({
            dropdownParent: $('#content-detail'),
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            theme: "bootstrap-5",
            containerCssClass: "wrap"
        }).next().find('.select2-selection').addClass('rounded-0');
    }

    function eventDetailForm(request)
    {
        eventValue()

        $(".del-form").unbind('click').bind('click', function () {
            $(this).closest('tr').remove()

        })
    }

    function eventDetailDocument(request){
        documents(request)

        $(".upload-file-row").each(function(index) {
            if (index === 0) {
                $(this).find(".del-file-form").hide();
            } else {
                $(this).find(".del-file-form").show();
            }
        });

        $(".del-file-form").unbind('click').bind('click', function () {
            $(this).closest('tr').remove()
            rowFile--;
        })
    }

    function bindSelect2Event(selector, callback) {
        $(selector).unbind('select2:select').bind("select2:select", function (e) {
            let dropdown = $(this);
            let rowParent = dropdown.parents("tr");
            callback(dropdown, rowParent);
        });
    }


    function eventValue() {
        defaultInputFormatNumber('.show-value')
        $(".show-value").change(function() {
            let row = $(this)
            let value = row.val()
            let angka = parseFloat(angkaBalik(value))

            row.val(formatRibuan(value))
            row.parents("tr").find(".value").val(angka)
        })
    }
</script>
@endpush
