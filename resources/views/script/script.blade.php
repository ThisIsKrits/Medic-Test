<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script src="{{asset('js/easy-number-separator.js')}}"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function() {
        function adjustPadding() {
            var screenWidth = $(window).width();
            if (screenWidth < 767) {
                var divHeight = $("#main-header").height();
                $("#content").css("padding-top", divHeight + 10 + "px");
            } else {
                $("#content").css("padding-top", "");
            }
        }
        adjustPadding();
        $(window).resize(function() {
            adjustPadding();
        });
    });

    $(".import-data").click(function() {
        $("#form-import").attr('action', $(this).attr('ref-url'))
    })

    $(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
        $('[data-tooltip="tooltip"]').tooltip();
    })

    function defaultFocus(input) {
        var value = input.val().trim()

        if (value === '0' || value === '0,00') {
            input.val('');
        }
    }

    function defaultBlur(input) {
        var value = input.val()

        if (value === '') {
            input.val('0,00')
        }
    }

    function errorInputTitik(e) {
        if (e.key === '.') {
            Swal.fire({
                title: "Ooops",
                text: "Gunakan Koma (,) untuk menulis desimal",
                icon: "error"
            })
        }
    }

    function defaultSelect(key = false, name = false) {
        if(key && name) {
            return '<option value="'+key+'">'+name+'</option>';
        }
        return '<option value="">Pilih</option>';
    }

    function defaultInputFormatNumber(element) {
        $(element).on('focus', function() {
            defaultFocus($(this))
        })

        $(element).on('blur', function() {
            defaultBlur($(this))
        })

        $(element).on('input', function() {
            humanNumber($(this))
        })

        $(element).on('keydown', function (e) {
            errorInputTitik(e)
        })
    }

    function humanNumber(input) {
        let num = input.val()

        // Get the cursor position
        let cursorPosition = input.prop("selectionStart")

        // Remove non-numeric characters except dot and minus sign
        num = num.replace(/[^\d,-]/g, '')

        // Ensure minus sign is only at the beginning
        if (num.indexOf('-') > 0) {
            num = num.replace('-', '') // Remove any additional minus signs
            num = '-' + num // Add minus sign at the beginning
        }

        // Save the value before formatting
        let beforeFormatting = num

        let parts = num.split(',')
        let integerPart = parts[0]
        let decimalPart = parts.length > 1 ? ',' + parts[1] : ''

        if (integerPart.length > 3) {
            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.')
        }

        // Combine the integer and decimal parts
        num = integerPart + decimalPart.replace(/\./g, '')

        // Calculate the new cursor position
        let newCursorPosition = cursorPosition + (num.length - beforeFormatting.length)

        // Restore the cursor position
        input.prop("selectionStart", newCursorPosition)
        input.prop("selectionEnd", newCursorPosition)

        input.val(num)
    }


    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function formatAngka(angka) {
        let angkaStr = angka.toString();

        if (angkaStr.includes('.')) {
            let decimalPart = angkaStr.split('.')[1];
            if (decimalPart.length === 1) {
                angkaStr += '0';
            }
        } else {
            angkaStr += ',00';
        }

        return angkaStr.replace('.', ',');
    }

    function formatWithDecimal(angka){
        var num = angka.replace(/[^\d,.]/g, '');

        var parts = num.split('.');
        var integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        var decimalPart = parts[1] ? ',' + parts[1].slice(0, 2) : '';

        return integerPart + decimalPart;
    }

    function formatWithoutDecimal(angka){
        var num = angka.replace(/[^\d,.]/g, '');

        var parts = num.split('.');
        var integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        var decimalPart = parts[1] ? ',' + parts[1].slice(0, 2) : '';

        return integerPart;
    }

    function formatRibuans(angka){
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        angka_hasil     = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            angka_hasil += separator + ribuan.join('.');
        }

        return angka_hasil;
    }

    function formatRibuan(angka){
        let minus = (angka < 0) ? '-' : ''
        let number_string = angka.replace(/[^,\d]/g, '').toString(),
        split           = number_string.split(','),
        sisa            = split[0].length % 3,
        angka_hasil     = split[0].substr(0, sisa),
        ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

        if(number_string === ''){
            return '';
        }

        if(ribuan){
            separator = sisa ? '.' : '';
            angka_hasil += separator + ribuan.join('.');
        }

        if (split[1] == undefined) {
            angka_hasil += ',00';
        } else {
            angka_hasil += ',' + split[1].padEnd(2, '0');
        }

        return minus+angka_hasil;
    }

    function formatTotal(angka){
        var num = angka.replace(/[^\d,.]/g, '');

        var parts = num.split('.');
        var integerPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        var decimalPart = parts[1] ? ',' + parts[1].slice(0, 2) : ',00';

        return integerPart + decimalPart;
    }

    function angkaBalik(angka) {

        var balik = angka.replace(/\./g,"").replace(/,/,".");
        if (balik.includes('.')) {
            var splitAngka = balik.split('.');
            if (splitAngka[1] === '00') {
                balik = splitAngka[0];
            }
        }

        return balik;
    }

    function showNumber(number) {
        if(number < 0) {
            return "-"+formatRibuan(number.toString().replace(".", ","))
        }
        return formatRibuan(number.toString().replace(".", ","))
    }

    function defaultFormNumber(node) {
        var value = node.val().trim();
        var cursorPosition = node[0].selectionStart;

        // Hapus nilai default '0' jika pengguna memasukkan nilai baru
        if (value === '0' && cursorPosition === 0) {
            node.val('');
        }

        // Izinkan hanya angka dan koma dalam nilai input
        node.val(value.replace(/[^0-9,]/g, ''));

        // Cek apakah nilai awal sama dengan 0
        if (node.val() === '0') {
            node.val(0);
        }
    }



    function showColumnTable(table) {
        let arr = $('.show-checked').get()
        arr.map(function(el) {
            let id = $(el).attr('id')
            if($(el).is(':checked')) {
                $(table+" ."+id).removeClass('d-none')
                return
            }
            $(table+" ."+id).addClass('d-none')
        })
    }

    function getAjax(url, callback) {
        let obj = {
            url: url,
            type: 'GET'
        }
        $.ajax(obj)
        .done(function (data) {
            return callback(data)
        })
        .fail(function(data) {
            if(data.status == 403) {
                const message = data.responseJSON?.message || "Anda tidak memiliki akses yang diperlukan untuk halaman ini!";
                Swal.fire({
                    title: "Akses Ditolak",
                    text: message,
                    icon: "warning"
                })
                return
            }
            Swal.fire({
                title: "Ooops",
                text: "something error",
                icon: "error"
            })
        });
    }

    function postAjax(url, data, callback) {
        $.ajax({
            url: url,
            type: 'POST',
            data: data
        }).done(function (data) {
            return callback(data)
        });
    }

    function getAjaxWithParam(url, data = false, callback) {
        let obj = {
            url: url,
            type: 'GET'
        }

        if(data) {
            obj.data = data
        }

        $.ajax(obj).done(function (data) {
            return callback(data)
        });
    }

    function getAjaxHelper(helper, param, callback) {
        $.ajax({
            url: '/ajax-helper',
            type: 'GET',
            data : {
                helper : helper,
                param : param
            }
        }).done(function (data) {
            return callback(data)
        });
    }

    function updateStatus(id,menu) {
        var url = '{{ url(":menu/:id") }}';
        url = url.replace(':menu', menu).replace(':id', id);

        $.ajax({
            url: url,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status: 1,
            },
            success: function(response) {
                if (response.success) {
                    var pdfUrl = '{{ url(":menu/:id") }}';
                    pdfUrl = pdfUrl.replace(':menu', menu).replace(':id', id);
                    window.open(pdfUrl, '_blank');
                } else {
                    console.log('Gagal mengupdate status: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
    }

    function notifSuccess(message) {
        Swal.fire({
                title: "Done",
                text: message,
                icon: "success"
            })
    }

    function notifWarning(message) {
        Swal.fire({
                title: "Done",
                text: message,
                icon: "warning"
            })
    }

    function notifError(message) {
        Swal.fire({
                title: "Ooops",
                text: message,
                icon: "error"
            })
    }


    $('.toggle-custom').on('click', function() {
        $('.toggle-custom').siblings('.sub-menu').collapse('hide')
    })
    $("#mobile-menu").click(function() {
        if ($("#top-navbar").css("left") == "0px") {
            $("#top-navbar").animate({
                "left": "165px"
            }, "fast")
            $("#mobile-menu").css("display", "none")
            $("#mobile-menu").html('Close <span class="fa fa-close"></span>')
        } else {
            $("#top-navbar").animate({
                "left": "0px"
            }, "fast")
            $("#mobile-menu").html('Menu <span class="fa fa-bars"></span>')
            $('.toggle-custom').siblings('.sub-menu').collapse('hide')
            $("#mobile-menu").css("display", "none");

        }
    })
    $(document).on('click', function(e) {
        if ($(e.target).closest("#top-navbar, .toggle-custom").length === 0) {
            $("#top-navbar").animate({
                "left": "0px"
            }, "fast")
            $("#mobile-menu").html('Menu <span class="fa fa-bars"></span>')
            $("#mobile-menu").css("display", "none")

        }
        if ($(e.target).closest(".sub-menu").length === 0) {
            $('.toggle-custom').siblings('.sub-menu').collapse('hide')
        }
    })

    $('.select2').select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    })

    @if(session()->has('success'))
        Swal.fire({
            title: "Done",
            text: "{{ session('success') }}",
            icon: "success"
        })
    @endif

    @if (!$errors->isEmpty())
        Swal.fire({
            title: "Ooops",
            text: "{{ $errors->first() }}",
            icon: "error"
        })
    @endif

    @if(session()->has('error'))
        let dataError = {
            title: "Ooops",
            text: "{{ session('error') }}",
            icon: "error"
        }
        @if(session()->has('link'))
        dataError.html = "<a>check link</a>"
        @endif
        Swal.fire(dataError)
    @endif

    $('#status').on('change', function() {
        let selectedValue = $(this).val();
        if(selectedValue == 'B') {
            $(".form-satuan").addClass('text-danger').find('sup').remove();
            $(".form-satuan").append('<sup>*</sup>');
        } else {
            $(".form-satuan").removeClass('text-danger').find('sup').remove();
        }
    });

    function printModalContent(modalId){
        var printContent = $(modalId + ' .modal-content').html();
        $('#print-area').html(printContent);

        $('#print-area').show();

        window.print();
        $('#print-area').hide();
    }

    function submitForm(selector) {
        $(selector).on('submit', function(e) {
            e.preventDefault()
            let btn = $(this).find("button[type='submit']")
            let focusId = ''
            disableButton(btn)

            $('[required]').each(function (i, el) {
                if ($(el).val() == '' || $(el).val() == undefined) {
                    if(focusId != '') {
                        return
                    }
                    focusId = $(el).attr('id')
                }
            })

            if(focusId) {
                $("#"+focusId).focus()
                enableButton(btn)
                return
            }
            $(selector).submit()
        })
    }

    // Fungsi global untuk menonaktifkan tombol dengan pengecekan tipe elemen
    function disableButton(selector) {
        let $element = $(selector);

        if ($element.is("a")) {
            $element.addClass("btn-disabled").attr("aria-disabled", "true");
        } else {
            $element.prop("disabled", true);
        }
    }

    // Fungsi global untuk mengaktifkan tombol
    function enableButton(selector) {
        let $element = $(selector);

        if ($element.is("a")) {
            $element.removeClass("btn-disabled").removeAttr("aria-disabled");
        } else {
            $element.prop("disabled", false);
        }
    }

    function handleDeleteDetail(){
        $(".del-detail").click(function() {
            let urlDel = $(this).attr('ref-url')
            let r = $(this).closest('tr')

            $("#form-deleted").attr('action', urlDel)
            $("#nama_delete").text($(this).attr('ref-nama'))
            $("#modal-delete").modal('show')

            $("#form-deleted :submit").attr('id', 'submit-delete-detail')
            $("#modal-delete .btn-secondary").attr('id', 'close-modal-delete')
            $("#submit-delete-detail").click(function(e) {
                e.preventDefault()
                let dataDelete = $("#form-deleted").serializeArray()
                postAjax(urlDel, dataDelete, function(data) {
                    if(data.success) {
                        r.remove()
                        $("#modal-delete").modal('hide')
                        $("#form-deleted :submit").removeAttr('id')
                    }
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: data.success ? "success" : "error"
                    })
                })
            })

            $("#close-modal-delete").click(function(e) {
                $("#form-deleted :submit").removeAttr('id')
            })

        })
    }

    function handleDeleteCost(){
        $(".del-cost").click(function() {
            let urlDel = $(this).attr('ref-url')
            let r = $(this).closest('tr')
            $("#form-deleted").attr('action', urlDel)
            $("#nama_delete").text($(this).attr('ref-nama'))
            $("#modal-delete").modal('show')

            $("#form-deleted :submit").attr('id', 'submit-delete-cost')
            $("#modal-delete .btn-secondary").attr('id', 'close-modal-delete')
            $("#submit-delete-cost").click(function(e) {
                e.preventDefault()
                let dataDelete = $("#form-deleted").serializeArray()
                postAjax(urlDel, dataDelete, function(data) {
                    if(data.success) {
                        r.remove()
                        $("#form-deleted :submit").removeAttr('id')
                        $("#modal-delete").modal('hide')
                    }
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: data.success ? "success" : "error"
                    })
                })
            })

            $("#close-modal-delete").click(function(e) {
                $("#form-deleted :submit").removeAttr('id')
            })

        })
    }

    function handleDeleteDocument(){
        $(".del-attach-file").click(function() {
            let urlDel = $(this).attr('ref-url')
            let r = $(this).closest('tr')
            $("#form-deleted").attr('action', urlDel)
            $("#nama_delete").text($(this).attr('ref-nama'))
            $("#modal-delete").modal('show')

            $("#form-deleted :submit").attr('id', 'submit-delete-upload')
            $("#modal-delete .btn-secondary").attr('id', 'close-modal-delete')
            $("#submit-delete-upload").click(function(e) {
                e.preventDefault()
                let dataDelete = $("#form-deleted").serializeArray()
                postAjax(urlDel, dataDelete, function(data) {
                    if(data.success) {
                        r.remove()
                        $("#modal-delete").modal('hide')
                        $("#form-deleted :submit").removeAttr('id')
                    }
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: data.success ? "success" : "error"
                    })
                })
            })

            $("#close-modal-delete").click(function(e) {
                $("#form-deleted :submit").removeAttr('id')
            })

        })
    }

    // function disable enter dan dsable button ketika form ada yang belum diisi
    function checkRequiredFields(form, submitBtn) {
        let allFilled = true

        form.find('input[required], select[required], textarea[required]').each(function () {
            if (!$(this).val()) {
                allFilled = false
                return false
            }
        })

        submitBtn.prop('disabled', !allFilled)
        return allFilled
    }

    function disableEnter() {
        let form = $('.primary-form')
        let submitBtn = $('#save-form')

        // Cek saat input berubah
        form.on('input change', function () {
            checkRequiredFields(form, submitBtn)
        })

        // Cegah submit dengan Enter jika belum lengkap
        form.on('keydown', function (e) {
            if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault()
            }
        })

        // Inisialisasi saat pertama kali halaman load
        checkRequiredFields(form, submitBtn)
    }

    function documents(request) {
        $('#file-'+request).on('change', function(event) {
            var files = event.target.files;
            var previewContainer = $(this).closest('tr').find('#file-preview');
            previewContainer.html('');
            $.each(files, function(index, file) {
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.append('<img src="' + e.target.result + '" alt="Preview Image">');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    }
</script>
