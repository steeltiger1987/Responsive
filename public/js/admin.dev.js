$(document).ready(function(){
    $.ajax({
        type: "POST",
        url: '/moving/excel',
        data: post_data,
        success: function( response ) {
            'hi';
        }
    });
});