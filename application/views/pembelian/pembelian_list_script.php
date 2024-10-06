<script>
    $(document).ready(function() {
        var table = $('#dtt_tables').DataTable({
            "columnDefs": [{
                "targets": 0,
                "visible": false,
                "searchable": false,
            }],
            "ordering": false,
            "serverSide": true,
            "processing": true,
            "ajax": '<?= base_url('pembelian/datatables') ?>',
            "buttons": ["copy", "csv", "excel", "pdf"],
            "dom": "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",
            "drawCallback": function(settings) {
                delete_handler();
            },
        });

        function delete_handler() {
            $('.delete_btn').click(function(e) {
                e.preventDefault();
                delete_url = $(this).attr('href');

                bootbox.confirm({
                    message: "Yakin Menghapus Data ?",
                    buttons: {
                        confirm: {
                            label: 'Yes',
                            className: 'btn-danger'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-secondary'
                        }
                    },
                    callback: function(result) {
                        if (result) {
                            $.get(delete_url, function(data, status) {
                                table.ajax.reload(null, false);
                                toastr.success("Data Telah dihapus", "Info");
                            });
                        }
                    }
                });

            });
        }


        $('#tanggal').daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            locale: glob_daterange_locale,
            showDropdowns: true,
            minYear: <?= date("Y", strtotime("-10 year")); ?>,
            maxYear: <?= date("Y", strtotime("+10 year")); ?>,
            autoApply: true
        });
        $('#tanggal').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY'));
        });
        $('#tanggal').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('#id_kontak').select2({
            // minimumInputLength: 2,
            placeholder: "Ketik Nama Kontak",
            allowClear: true,
            ajax: {
                url: '<?= base_url('kontak/select2') ?>',
                data: function(params) {
                    var query = {
                        search: params.term,
                        type: 'public'
                    }
                    return query;
                }
            }
        });

        $('#form_filter').submit(function(e) {
            e.preventDefault();

            param = $(this).serialize();
            table.ajax.url('<?= base_url('pembelian/datatables') ?>?' + param).load();
            $('#filter_modal').modal('hide');
        });

        $('#clear_form_filter').click(function(){
            $('#id_kontak').val("").trigger('change');
            $('#kode_pembelian').val("");
            $('#tanggal').val("");
            $('#status').val("");
            // $('#form_filter')[0].reset();
        })

    });
</script>