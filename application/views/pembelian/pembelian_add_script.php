<script>
    $(document).ready(function() {
        is_hutang();

        $('#is_hutang').change(function() {
            is_hutang();

        });

        $('#fokus2barcode').click(function(){
            $('#barcode').focus();
        });
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