$(document).ready(function() {

    if($("#file-upload").length){

        Dropzone.autoDiscover = false;
        var dropzone = new Dropzone ("#file-upload", {
            maxFilesize: 256, // Set the maximum file size to 256 MB
            url: "/moving/ajax/orders/item/upload",
            paramName: "file",

            headers: {
                'X-CSRF-Token': $('input[name="_token"]').val()
            },
            success:function(file, response){
                addFileNameToForm(response);
            }
        });
    }

    function addFileNameToForm(filename){
        $("#uploaded_filesas").append("<input type=\"hidden\" name=\"images[]\" value=\""+filename+"\">");
    }

    $("input#length, input#width, input#height").keyup(function(e) {
        validate_input(e);
    });

    $('#expiration_date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        formatDate: 'Y-m-d',
        minDate:0
    });

    function validate_input(e){
        var a = [];
        var k = e.which;

        for (var i = 48; i < 58; i++)
            a.push(i);

        a.push(46);
        a.push(8);

        if (!($.inArray(k, a) >= 0)) {
            e.preventDefault();
        } else {
            calculate_size();
        }
    }


    function calculate_size() {

        var width = parseInt($('input#width').val()) / 100;
        var length = parseInt($('input#length').val()) / 100;
        var height = parseInt($('input#height').val()) / 100;

        if (!width) width = 0;
        if (!length) length = 0;
        if (!height) height = 0;

        var result = width * length * height

        $('#size').html(result + " m<sup>3</sup>");
        $('#size_input').val(result);
    }

});


