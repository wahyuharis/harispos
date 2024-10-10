<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="<?= base_url('keuangan/add') ?>">Add</a>
        <br>
        <br>
        <table id="dtt_tables" class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>#</th>
                    <th><?= label2("tanggal") ?></th>
                    <th><?= label2("jenis transaksi") ?></th>
                    <th><?= label2("kode trans") ?></th>
                    <th><?= label2("metode pembayaran") ?></th>
                    <th><?= label2("total transaksi") ?></th>
                    <th><?= label2("keterangan") ?></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#dtt_tables').DataTable({
            "columnDefs": [{
                "targets": 0,
                "visible": false,
                "searchable": false,
            }],
            "ordering": false,
            "processing": true,
            "serverSide": true,
            "ajax": '<?= base_url('keuangan/datatables') ?>',
            "buttons": ["copy", "csv", "excel", "pdf"],
            "dom": "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
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
    });
</script>