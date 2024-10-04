function curency_to_float(str) {
    var myNumeral2 = numeral(str);

    value = 0;
    if (myNumeral2.value() == null) {
        value = 0;
    } else {
        value = myNumeral2.value();
    }
    return parseFloat(value);
}

function float_to_currency(floatval) {
    floatval = parseFloat(floatval);
    return numeral(floatval).format("0,0.00");
}


function format_currency() {
    $('.thousand').each(function () {
        num = $(this).val();
        if (num.trim().length == 0) {
            num = "";
        } else {
            num = numeral(num).format('0,0.00');
        }
        $(this).val(num);
    });

    $('.thousand').keyup(function () {
        num = $(this).val();
        if (num.trim().length == 0) {
            num = "";
        } else {
            num = numeral(num).format();
        }
        $(this).val(num);
    });

    $('.thousand').focusout(function () {
        num = $(this).val();
        if (num.trim().length == 0) {
            num = "";
        } else {
            num = numeral(num).format('0,0.00');
        }
        $(this).val(num);
    });

    $('.thousand').focus(function () {
        $(this).select();
    });

}

function format_number() {

    $('.number').keypress(function (event) {
        num = $(this).val();
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $('.number').focusout(function () {
        num = $(this).val();
        // num = numeral(num).format();
        num = parseFloat(num);
        $(this).val(num);
    });

    $('.number').each(function () {
        num = $(this).val();
        // num = numeral(num).format();
        num = parseFloat(num);
        $(this).val(num);
    });

    $('.number').focus(function () {
        $(this).select();
    });
}