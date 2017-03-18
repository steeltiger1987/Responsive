$(document).ready(function() {

    /**
     * Order
     *
     * Here you'll find all information that need to use in order controller
     **/


    var modal_dialog = new BootstrapDialog({
        message: $('<div></div>').load('/moving/items/modal/'),
        buttons: [{
            label: 'Close',
            cssClass: 'btn-primary',
            action: function(dialogItself){
                dialogItself.close();
            }},
            {
                label: 'save',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    if($('#name').val() == ""){
                        $('#error-message').html("Please fill name field");
                    } else {
                        var serialized_item_data = $('#item-add-form').serialize();
                        saveItem(serialized_item_data);
                        dialogItself.close();
                    }

                }
            }]
        });

    var items_modal = new BootstrapDialog({
        message: function() {
            $('#items-box').removeClass('hidden');
            var $content = $('#items-box');

            return $content;
        },
        buttons: [{
            label: 'Close',
            cssClass: 'btn-primary',
            action: function(dialogItself){
                dialogItself.close()
            }
        }]
    });

    /**
     * input: serialized data
     * Saves item
     */


    function saveItem(serializedData){


        var item_type = modal_dialog.getData('item');

        form_data = serializedData + '&type=' + item_type;

        $.ajax({
            type: "POST",
            url: '/moving/ajax/orders/item/create',
            data: form_data,
            success: function( response ) {
                getItemsWithResponse(response);
            }
        });
    }



    function getItemsWithResponse(response){
        $.ajax({
            type: "POST",
            url: '/moving/ajax/order/'+ response.data.item.order_id +'/items',
            data: form_data,
            success: function( items ) {
                updateItems(items);
            },
            error:function( msg ){
                console.log('No luck with getting items')
            }
        });
    }

    function updateItemsWithId(order_id){
        console.log('updating ' + order_id);
        $.ajax({
            type: "POST",
            url: '/moving/ajax/order/'+ order_id +'/items',
            data: '_token='+$('meta[name="csrf-token"]').attr('content'),
            success: function( items ) {
                updateItems(items);
            },
            error:function( msg ){
                console.log('No luck with getting items')
            }
        });
    }

    function updateItems(items){
        $('.small_items').empty();

        for(i = 0; i < items.small_items.length; i++){
            $('.small_items').append("<li><a href='/moving/items/modal/"+items.small_items[i].id+"' class='large-item-choose'>" + items.small_items[i].name + " x" + items.small_items[i].amount + "</a> <a class='delete-item' href='/moving/orders/item/delete/"+items.small_items[i].id+"'>(delete)</a></li>");
        }



        $('.large_items').empty();
        for(i = 0; i < items.large_items.length; i++){
            $('.large_items').append("<li><a href='/moving/items/modal/"+items.large_items[i].id+"' class='large-item-choose'>" + items.large_items[i].name + " x" + items.large_items[i].amount + "</a> <a class='delete-item' href='/moving/orders/item/delete/"+items.large_items[i].id+"'>(delete)</a></li>");
        }

        items_count = items.small_items.length + items.large_items.length;

        //Add items count to calculations.js
        small_items_number(items.small_items.length);
        large_items_number(items.large_items.length);

        $('.items_count').html("<input type=\"hidden\" name=\"items_count\" value=\""+ items_count + " \" >");

    }

    /**
     * Date pickers
     */

    $('#time, #time_pick_up, #time_drop_off, #time_drop_off_interval, #time_pick_up_interval').datetimepicker({
        datepicker: false,
        format: 'H:i',
        step: 30
    });

    $('#date, #date_pick_up, #date_drop_off').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        formatDate: 'Y-m-d',
        minDate:0
    });

    $('#expiration_date').datetimepicker({
        timepicker: false,
        format: 'Y-m-d',
        formatDate: 'Y-m-d',
        minDate:0
    })

    //Period picker

    $('#pick_up_picker').periodpicker({
        cells: [1, 1],
        withoutBottomPanel: true,
        yearsLine: false,
        title: false,
        closeButton: false,
        fullsizeButton: false
    });

    $('#drop_off_picker').periodpicker({
        cells: [1, 1],
        withoutBottomPanel: true,
        yearsLine: false,
        title: false,
        closeButton: false,
        fullsizeButton: false
    });

    /** Form **/

    //Button in order was pressed, so submitting any of forms in order creation.
    $("#order-button").click(function(){

        if($('#drop_off_picker').length && $('#pick_up_picker').length){
            datePickerResultPickUp = $('#drop_off_picker').periodpicker('valueStringStrong');
            datePickerResultDropOff = $('#pick_up_picker').periodpicker('valueStringStrong');
            $("#order-form").append("<input type='hidden' name='pick_up_dates' value="+ datePickerResultPickUp +" >");
            $("#order-form").append("<input type='hidden' name='drop_off_dates' value="+ datePickerResultDropOff +" >");
        }

        $("#order-form").submit();
    });



    /**
     * Checkboxes to display other elements
     */

    $("#will_help").click(function(){
       if($(this).is(':checked')){
           $('.helper_count_input').show(300);
       } else {
           $('.helper_count_input').hide(300);
       }
    });

    $("#negotiate_by_self").click(function(){
        if($(this).is(':checked')){
            $('.pick-drop-times').hide(300);
        } else {
            $('.pick-drop-times').show(300);
        }
    });

    $("#exact-time-pick-up-checkbox").change(function(){
        if($(this).prop('checked')){
            $('.exact-time-pick-up').show(300);
        } else {
            $('.exact-time-pick-up').hide(300);
        }
    });

    $("#exact-time-drop-off-checkbox").change(function(){
        if($(this).is(':checked')){
            $('.exact-time-drop-off').show(300);
        } else {
            $('.exact-time-drop-off').hide(300);
        }
    });

    $("#interval-pick-up-checkbox").change(function(){
        if($(this).is(':checked')){
            $('#interval-pick-up').show(300);
        } else {
            $('#interval-pick-up').hide(300);
        }
    });

    $("#interval-drop-off-checkbox").change(function(){
        if($(this).prop('checked')){
            $('#interval-drop-off').show(300);
        } else {
            $('#interval-drop-off').hide(300);
        }
    });

    //Firing small or large item add pop-up
    $("#add_small_item_button").on('click', function(){
        modal_dialog = new BootstrapDialog({
            message: $('<div></div>').load('/moving/items/modal'),
            buttons: [{
                label: 'Close',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    dialogItself.close();
                }},
                {
                    label: 'save',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        if($('#name').val() == ""){
                            $('#error-message').html("Please fill name field");
                        } else {
                            var serialized_item_data = $('#item-add-form').serialize();
                            saveItem(serialized_item_data);
                            dialogItself.close();
                        }

                    }
                }]
        });

        modal_dialog.realize();

        modal_dialog.setData('item', 'small');
        modal_dialog.getModalHeader().css("background-color", "#ffd800");
        modal_dialog.open();
    });



    $("#add_large_item_button").on('click', function(){
        modal_dialog = new BootstrapDialog({
            message: $('<div></div>').load('/moving/items/modal'),
            buttons: [{
                label: 'Close',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    dialogItself.close();
                }},
                {
                    label: 'save',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        if($('#name').val() == ""){
                            $('#error-message').html("Please fill name field");
                        } else {
                            var serialized_item_data = $('#item-add-form').serialize();
                            saveItem(serialized_item_data);
                            dialogItself.close();
                        }

                    }
                }]
        });

        modal_dialog.realize();

        modal_dialog.setData('item', 'large');
        modal_dialog.getModalHeader().css("background-color", "#ffd800");
        modal_dialog.open();
    });

    $(".cancel").on('click', function(event){
        var url = $(this).attr('href');
        modal_dialog = new BootstrapDialog({
            message: 'Are you sure you want to cancel order?',
            buttons: [{
                label: 'Close',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    dialogItself.close();
                }},
                {
                    label: 'save',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        cancelOrder(url);
                        dialogItself.close();
                    }
                }]
        });

        modal_dialog.realize();

        modal_dialog.setData('item', 'small');
        modal_dialog.getModalHeader().css("background-color", "#ffd800");
        modal_dialog.open();

        return false;
    });

    $(".prolong").on('click', function(event){
        var url = $(this).attr('href');
        modal_dialog = new BootstrapDialog({
            message: $('<div></div>').load(url),
            buttons: [{
                label: 'Close',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    dialogItself.close();
                }},
                {
                    label: 'save',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                            var serialized_item_data = $('#prolong-form').serialize();
                            change_prolong(serialized_item_data);
                            dialogItself.close();
                    }
                }]
        });

        modal_dialog.realize();

        modal_dialog.setData('item', 'small');
        modal_dialog.getModalHeader().css("background-color", "#ffd800");
        modal_dialog.open();

        return false;
    });

    $("#review-mover").on('click', function(event){
        var url = $(this).attr('href');
        modal_dialog = new BootstrapDialog({
            message: $('<div></div>').load(url),
            buttons: [{
                label: 'Close',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    dialogItself.close();
                }},
                {
                    label: 'save',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        var serialized_item_data = $('#review-form').serialize();
                        review_mover(serialized_item_data);
                        dialogItself.close();
                    }
                }]
        });

        modal_dialog.realize();

        modal_dialog.setData('item', 'small');
        modal_dialog.getModalHeader().css("background-color", "#ffd800");
        modal_dialog.open();

        return false;
    });

    $(".user-profile").on('click', function(event){

        var url = $(this).attr('href');
        modal_dialog = new BootstrapDialog({
            message: $('<div></div>').load(url),
            buttons: [{
                label: 'Close',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    dialogItself.close();
                }}]
        });

        modal_dialog.realize();

        modal_dialog.getModalHeader().css("background-color", "#ffd800");
        modal_dialog.open();

        return false;
    });

    $(".accept-mover").on('click', function(event){
        var url = $(this).attr('href');

        modal_dialog = new BootstrapDialog({
            message: function(dialog){
                var content = $('<div></div>').load(url, function( response, status, xhr ) {
                    if ( status == "error" ) {
                        var msg = "Sorry but there was an error: ";
                        $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
                    } else {
                        $(this).find('#close').click(function(event){
                            dialog.close();
                            location.reload();
                            return false;
                        });

                        $(this).find('#hire').click(function(event){

                            var post_form = $('#job_details_form').serialize()
                            $.ajax({
                                type: "POST",
                                url: '/moving/orders/create_job',
                                data: post_form,
                                success: function( response ) {

                                }
                            });

                            $('#first-step-approve').hide();
                            $('#second-step-approve').show();
                        });


                    }
                });


                return content;
            }
        });

        modal_dialog.realize();

        modal_dialog.getModalHeader().css("display", "none");
        modal_dialog.open();

        return false;
    });

    function review_mover(serializedData){
        $.ajax({
            type: "POST",
            url: '/moving/ajax/orders/review',
            data: serializedData,
            success: function( response ) {
                location.reload();
            }
        });
    }

    function change_prolong(serializedData){
        $.ajax({
            type: "POST",
            url: '/moving/ajax/orders/prolong',
            data: serializedData,
            success: function( response ) {
                location.reload();
            }
        });
    }

    function cancelOrder(url){
        $.ajax({
            type: "POST",
            url: url,
            data: '_token='+$('meta[name="csrf-token"]').attr('content'),
            success: function( response ) {
                location.assign('/moving/orders/show');
            }
        });
    }

    $(".small-item-choose").live('click', function(event){

        var url = $(this).attr('href');

        modal_dialog = new BootstrapDialog({
            message: $('<div></div>').load(url),
            buttons: [{
                label: 'Close',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    dialogItself.close();
                }},
                {
                    label: 'save',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        if($('#name').val() == ""){
                            $('#error-message').html("Please fill name field");
                        } else {
                            var serialized_item_data = $('#item-add-form').serialize();
                            saveItem(serialized_item_data);
                            dialogItself.close();
                        }

                    }
                }]
        });

        modal_dialog.realize();

        modal_dialog.setData('item', 'small');
        modal_dialog.getModalHeader().css("background-color", "#ffd800");
        modal_dialog.open();

        return false;
    });

    $(".large-item-choose").live('click', function(event){

        var url = $(this).attr('href');

        modal_dialog = new BootstrapDialog({
            message: $('<div></div>').load(url),
            buttons: [{
                label: 'Close',
                cssClass: 'btn-primary',
                action: function(dialogItself){
                    dialogItself.close();
                }},
                {
                    label: 'save',
                    cssClass: 'btn-primary',
                    action: function(dialogItself){
                        if($('#name').val() == ""){
                            $('#error-message').html("Please fill name field");
                        } else {
                            var serialized_item_data = $('#item-add-form').serialize();
                            saveItem(serialized_item_data);
                            dialogItself.close();
                        }

                    }
                }]
        });

        modal_dialog.realize();

        modal_dialog.setData('item', 'large');
        modal_dialog.getModalHeader().css("background-color", "#ffd800");
        modal_dialog.open();

        return false;
    });

    $(".delete-item").live('click', function(event){

        var url = $(this).attr('href');

        $.ajax({
            type: "POST",
            url: '/moving/ajax'+url,
            data: '_token='+$('meta[name="csrf-token"]').attr('content'),
            success: function( response ) {
                updateItemsWithId(response.data.order_id);
            }
        });

        return false;
    });

    $("#items_list_view_action").on('click', function(event){

        event.preventDefault;

        show_items();

        return false;
    })


    //Spinner logic.
    $(document).on('click', '.number-spinner button', function () {
        var btn = $(this),
            oldValue = btn.closest('.number-spinner').find('input').val().trim(),
            newVal = 0;

        if (btn.attr('data-dir') == 'up') {
            newVal = parseInt(oldValue) + 1;
        } else {
            if (oldValue > 1) {
                newVal = parseInt(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        btn.closest('.number-spinner').find('input').val(newVal);

        return false;
    });


    //Getting parameter of url
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };


    /**
     * Sidebar actions
     */

        //Gets step
        var step = getUrlParameter('step');

        $('.order-steps li').each(function(){
            $(this).removeClass('active');
        });

        if(step == 'address'){
            $('.order-steps li:eq(0)').addClass('active');
        } else if(step == 'items'){
            $('.order-steps li:eq(1)').addClass('active');
        } else if(step == 'dates'){
            $('.order-steps li:eq(2)').addClass('active');
        } else if(step == 'account'){
            $('.order-steps li:eq(3)').addClass('active');
        } else {
            $('.order-steps li:eq(0)').addClass('active');
        }

    //Show items in order page
    function show_items(){
        items_modal.open();
    }
        $("#base_address").geocomplete()
        .bind("geocode:result", function(event, result){

        });
});