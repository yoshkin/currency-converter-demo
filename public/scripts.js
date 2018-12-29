$(function() {
    var form = $("form");
    $.validator.setDefaults({
        success: "valid",
        rules: {
            from: "required",
            to: "required",
            amount: {
                required: true,
                number: true
            }
        }
    });
    $( "#amount" ).on("input", function() {
        replaceWordToNumber.call(this);
    });
    form.validate({
        submitHandler: function() {
            var dataArray = convertToArray(form.serializeArray());
            getConvertedValue(dataArray);
        },
        success: function(label) {
            label.remove();
        }
    });

    function convertToArray(formData) {
        var dataArray = [];
        $(formData).each(function (i, field) {
            dataArray[field.name] = field.value;
        });
        return dataArray;
    }

    function getConvertedValue(dataArray) {
        $.get("/api/convert/" + dataArray.from + "/" + dataArray.to + "/" + dataArray.amount)
            .done(function (data) {
                $("#converted").text("Converted value: " + data + " " + dataArray.to);
            })
            .fail(function () {
                $("#converted").text('Error, pls try later.');
            });
    }

    function replaceWordToNumber() {
        $(this).val($(this).val().replace(/\,/g, '.'));
        $(this).val($(this).val().replace(/(?=(\d+\.\d{2})).+|(\.(?=\.))|([^\.\d])|(^\D)/gi, '$1'));
    }
});