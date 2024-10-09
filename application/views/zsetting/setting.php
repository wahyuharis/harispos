<div class="card">
    <div class="card-body">
        <form id="form_1" enctype="multipart/form-data" action="<?= base_url('zsetting/submit') ?>" method="post">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="company_name">Nama Perusahaan*</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" value="<?= $company_name ?>">
                    </div>

                    <div class="form-group">
                        <label for="company_address">Alamat Perusahaan</label>
                        <textarea class="form-control" id="company_address" name="company_address"><?= $company_address ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="company_logo">Logo Perusahaan</label>
                        <input type="file" accept="image/*" class="form-control-file" id="company_logo" name="company_logo" onchange="loadFile(event)">
                    </div>
                    <img id="output" style="width: 200px;height: 200px;border:1px solid #ccc" src="<?= base_url($company_logo) ?>">
                    <script>
                        var loadFile = function(event) {
                            var output = document.getElementById('output');
                            output.src = URL.createObjectURL(event.target.files[0]);
                            // console.log(output.src);
                            output.onload = function() {
                                URL.revokeObjectURL(output.src) // free memory
                            }
                        };
                    </script>

                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="company_name">Pos Printer Address</label>
                        <input type="text" class="form-control" id="pos_printer_addres" name="pos_printer_addres" value="<?= $pos_printer_addres ?>">
                    </div>
                </div>
            </div>

            <div style="text-align: end;">
                <button type="submit" class="btn btn-primary">save</button>
            </div>
        </form>
    </div>
</div>
<?php require_once "setting_script.php" ?>