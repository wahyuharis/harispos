<script>
    function add_item(id_item, barcode, nama_item, harga_beli, qty, satuan, stock, disc) {
        var self = this;

        self.id_item = ko.observable(id_item);
        self.barcode = ko.observable(barcode);
        self.nama_item = ko.observable(nama_item);
        self.harga_beli = ko.observable(harga_beli);
        self.qty = ko.observable(qty);
        self.satuan = ko.observable(satuan);
        self.disc = ko.observable(disc);
        self.stock = ko.observable(stock);
        self.disc_type = ko.observable('persen');

        self.sub = ko.computed(function() {
            var total = 0;
            total = curency_to_float(self.qty()) * curency_to_float(self.harga_beli());
            if (self.disc_type() == 'persen') {
                total = total - (total * (curency_to_float(self.disc()) / 100));
            }else{
                total = total - curency_to_float(self.disc());
            }
            total = float_to_currency(total);
            return total;
        });

    }

    function Pembelian_model() {
        var self = this;

        self.kode_pembelian = ko.observable('');
        self.tanggal = ko.observable('');
        self.id_kontak = ko.observable('');
        self.is_hutang = ko.observable(false);
        self.keterangan = ko.observable('');
        // 
        self.opt_metode_pembayaran = ko.observableArray(<?= json_encode($opt_metode_pembayaran) ?>);

        self.id_rekening_dp = ko.observable('');
        self.id_rekening_cash = ko.observable('');

        self.item_list = ko.observableArray([]);
        self.nama_biaya = ko.observable('');
        self.jumlah_biaya = ko.observable('');
        self.bayar = ko.observable('');
        self.uang_muka = ko.observable('');



        self.add_item_modal = function(id_item) {
            add = true;
            for (var i = 0; i < self.item_list().length; i++) {
                id_item2 = self.item_list()[i].id_item();
                if (id_item == id_item2) {
                    add = false;
                }
            }
            if (add) {
                Custom_loading();
                $.ajax({
                    url: '<?= base_url('/item/item_detail') ?>/' + id_item,
                    type: 'get',
                    success: function(data) {
                        // console.log(data);

                        // function add_item(id_item, barcode, nama_item, harga_beli, qty, satuan, stock, disc) {                       
                        self.item_list.push(new add_item(data.id_item, data.barcode, data.nama_item, data.harga_beli, '1', data.satuan, data.stock, '0'));

                        $('#pick_item_modal').modal('hide');
                        JsLoadingOverlay.hide();

                    },
                    error: function(err) {
                        alert("terjadi kesalahan");
                        JsLoadingOverlay.hide();
                    }
                });
            } else {
                toastr["error"]("Maaf Item Sudah Ada !");
            }
        }

        self.add_item_barcode = function(barcode) {
            Custom_loading();
            $.ajax({
                url: '<?= base_url('/item/item_detail_barcode') ?>/' + barcode,
                type: 'get',
                success: function(data) {
                    // console.log(data);

                    id_item = data.id_item;
                    add = true;
                    for (var i = 0; i < self.item_list().length; i++) {
                        id_item2 = self.item_list()[i].id_item();
                        if (id_item == id_item2) {
                            add = false;
                            last_qty = curency_to_float(self.item_list()[i].qty());
                            last_qty = last_qty + 1;
                            last_qty = float_to_currency(last_qty);
                            self.item_list()[i].qty(last_qty)
                        }
                    }
                    if (add) {
                        // function add_item(id_item, barcode, nama_item, harga_beli, qty, satuan, stock, disc) {                       
                        self.item_list.push(new add_item(data.id_item, data.barcode, data.nama_item, data.harga_beli, '1', data.satuan, data.stock, '0'));

                    } else {
                        // toastr["error"]("Maaf Item Sudah Ada !");
                    }
                    $('#pick_item_modal').modal('hide');
                    JsLoadingOverlay.hide();
                    $('#barcode').val('');

                },
                error: function(err) {
                    alert("terjadi kesalahan");
                    JsLoadingOverlay.hide();
                }
            });

        }


        self.delete_item_list = function(row) {
            self.item_list.remove(row);
        }

        self.total = ko.computed(function() {
            var total = 0;
            for (var i = 0; i < self.item_list().length; i++) {
                sub1 = self.item_list()[i].sub();
                total = total + curency_to_float(sub1);
            }

            total=total + curency_to_float(self.jumlah_biaya());

            total = float_to_currency(total);
            return total;
        });

        self.kembalian = ko.computed(function() {
            var kembalian = 0;
            // self.bayar
            kembalian = curency_to_float(self.bayar()) - curency_to_float(self.total());
            if (kembalian < 0) {
                kembalian = 0
            }
            kembalian = float_to_currency(kembalian);
            return kembalian;
        });

        self.sisa_tagihan = ko.computed(function() {
            var sisa_tagihan = 0;
            sisa_tagihan = curency_to_float(self.total()) - curency_to_float(self.uang_muka());
            sisa_tagihan = float_to_currency(sisa_tagihan);

            return sisa_tagihan;
        });

    }

    $(document).ready(function() {
        ko.applyBindings(new Pembelian_model(), document.getElementById("pembelian_add"));

        is_hutang();

        $('#is_hutang').change(function() {
            is_hutang();
        });

        $('#fokus2barcode').click(function() {
            $('#barcode').focus();
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
        $('#tanggal').daterangepicker({
            singleDatePicker: true,
            locale: glob_daterange_locale,
        });

        $('#pick_item_modal').on('shown.bs.modal', function(event) {
            $('#pick_item_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ordering": false,
                ajax: '<?= base_url('item/item_modal') ?>',
                "drawCallback": function(settings) {
                    $('.pilih_item').click(function() {
                        val = $(this).attr('id_item');
                        // console.log(val);

                        var context = ko.contextFor(document.getElementById("pembelian_add"));
                        context.$data.add_item_modal(val);
                    });
                }
            });
        });

        $('#form_barcode').submit(function(e) {
            e.preventDefault();
            val = $('#barcode').val();

            var context = ko.contextFor(document.getElementById("pembelian_add"));
            context.$data.add_item_barcode(val);
        });

        $('#pick_item_modal').on('hidden.bs.modal', function(event) {
            $('#pick_item_table').dataTable().fnClearTable();
            $('#pick_item_table').dataTable().fnDestroy();
        });


        $('#form_1').submit(function(e) {
            e.preventDefault();
            Custom_loading();
            $.ajax({
                url: '<?= base_url('pembelian/submit/') ?>', // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function(data) // A function to be called if request succeeds
                {
                    if (data.success) {
                        insert_id = data.data.insert_id;
                        window.location = '<?= base_url('pembelian/view/') ?>/' + insert_id;
                        console.log(data);
                    } else {
                        toastr.error(data.message);
                    }
                    console.log(data);
                    JsLoadingOverlay.hide();
                },
                error: function(err, txt) {
                    JsLoadingOverlay.hide();
                    console.log(err);
                    // console.log('================');
                    // console.log(txt);
                    bootbox.alert({
                        size: "large",
                        title: '<span class="text-danger" >Error ' + err.status + '<span>',
                        message: '<iframe id="bootframe_err"  src="about:blank" style="width:100%;height:500px;border:none" ></iframe>',
                        onShown: function(e) {
                            var doc = document.getElementById('bootframe_err').contentWindow.document;
                            doc.open();
                            doc.write(err.responseText);
                            doc.close();
                        }
                    });
                }
            });
        });

    });

    var list = document.getElementById("ko_binded");

    var MutationObserver = window.MutationObserver || window.WebKitMutationObserver || window.MozMutationObserver;

    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList') {
                // console.log("mutation!", mutation);
                format_currency();
                format_number();
            }
        });
    });

    observer.observe(list, {
        attributes: true,
        childList: true,
        characterData: true,
        subtree: true
    });



    function is_hutang() {
        if ($('#is_hutang').is(':checked')) {
            $(".cash_payment").hide();
            $(".down_payment").show();
        } else {
            $(".down_payment").hide();
            $(".cash_payment").show();
        }
    }
</script>