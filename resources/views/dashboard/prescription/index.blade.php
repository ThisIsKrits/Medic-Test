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
            @hasanyrole('superadmin|admin|dokter')
            <div class="d-flex justify-content-end p-3">
                <a href="{{ route('prescription.create') }}" class="btn btn-sm btn-outline-primary" id="btn-add">Tambah</a>
            </div>
            @endhasanyrole
            <div class="d-flex justify-content-end p-3">
                <form action="{{ route('prescription.index') }}" method="GET">
                    <x-search />
                </form>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12">
                @php
                    $canEdit = Auth::user()->hasAnyRole('dokter|superadmin');
                @endphp
                @include('components._table',[
                    'idtable' => 'table-prescription',
                    'editurl' => $canEdit ? 'prescription.edit' : null,
                    'showurl' => 'prescription.show',
                    'destroyurl' => $canEdit ? 'prescription.destroy' : null,
                    'refnama' => 'nomer',
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

                setSelect2()
                eventDetailForm()
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

        if(!edited) {
            getDetailForm(url, rowDetail);
        }

        $("#add-content-detail").click(function() {
            rowDetail++;
            getDetailForm(url, rowDetail)
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
        eventInv()
        eventQty()
        eventPrice()

        $(".del-form").unbind('click').bind('click', function () {
            $(this).closest('tr').remove()

        })
    }


    function bindSelect2Event(selector, callback) {
        $(selector).unbind('select2:select').bind("select2:select", function (e) {
            let dropdown = $(this);
            let rowParent = dropdown.parents("tr");
            callback(dropdown, rowParent);
        });
    }

    function eventInv(){
        $('.select-inv').unbind('select2:select').bind("select2:select", function (e) {
            let row = $(this)
            let rowParent = row.parents("tr")

            let price = row.find('option:selected').attr('ref-price')

            rowParent.find(".show-price").val(price)
            rowParent.find(".price").val((price ? parseFloat(angkaBalik(price)) : 0))
        })
    }

    function eventQty() {
        defaultInputFormatNumber('.show-qty')
        $(".show-qty").change(function() {
            let row = $(this)
            let value = row.val()
            let angka = parseFloat(angkaBalik(value))

            row.val(formatRibuan(value))
            row.parents("tr").find(".qty").val(angka)

            let data = setDataCalculate(row)
            calculate(row, data)
        })
    }

    function eventPrice() {
        defaultInputFormatNumber('.show-price')
        $(".show-price").change(function() {
            let row = $(this)
            let value = row.val()
            let angka = parseFloat(angkaBalik(value))

            row.val(formatRibuan(value))
            row.parents("tr").find(".price").val(angka)

            let data = setDataCalculate(row)
            calculate(row, data)
        })
    }

    function setDataCalculate(row) {
        return {
            qty  : parseFloat(row.parents("tr").find(".qty").val()),
            price: parseFloat(row.parents("tr").find(".price").val()),
        }
    }

    function calculate(row, data) {
        console.log(data.price);

        let total = (isNaN(data.qty) ? 0 : data.qty) * (isNaN(data.price) ? 0 : data.price)
        row.parents("tr").find(".subtotal").val(total)

        total = total.toFixed(2)
        var angka = total.toString().replace(".", ",")
        var hasilAngka = formatTotal(total)
        row.parents("tr").find(".show-subtotal").val(hasilAngka)
        calculateGrandTotal()
    }

    function calculateGrandTotal(row, data) {
        let total = 0
        let tableBody = $("#table-detail tbody").find(".subtotal").each(function() {
            total += parseFloat($(this).val())
        })
        total = total.toFixed(2)
        $("#grandTotal").val(showNumber(total))
    }
</script>
@endpush
