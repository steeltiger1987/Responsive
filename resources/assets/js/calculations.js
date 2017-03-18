
/**
 * Forms values
 */

//First form

var pickup_address;
var pickup_floors = 0;
var pickup_elevator = false;

var dropoff_address;
var dropoff_floors = 0;
var dropoff_elevator = false;


//Second form
var large_items = 0;
var small_items = 0;

var large_items_assembly = 0;
var small_items_assembly = 0;

var teleporters = 1;
var own_helpers = 0;

//Third form
var name;
var phone_number;
var email;
var comments;


    //Constants form calculations
    const labor_rate = 700;
    const driving_rate = 41;
    const extra_teleporter_rate = 200;
    const asamblee_rate = 700;


    const minimum_price = 599;

    //Ask for these Aleksandr
    const big_assembly_time = 0.5/24;
    const small_assembly_time = 1/24;


    //Temporary distance that is constant
    var distance = 0;
    var driving_time = 0;


    //Variables countable
    var driving_distance;


    var service;




    /**
     * GEOCODING
     */

    var origin_address = "";
    var destination_address = "";

    function validateForm($number){
        switch ($number){
            case 1:
                pickup_address = $("#pickup_address").val();
                pickup_floors = $("#pickup_floor").val();
                if($("#pickup_elevator").val() == "Yes"){
                    pickup_elevator = true;
                } else {
                    pickup_elevator = false;
                }

                dropoff_address = $("#drop_off_address").val();
                dropoff_floors = $("#drop_off_floor").val();


                if($("#drop_off_elevator").val() == "Yes"){
                    dropoff_elevator = true;
                } else {
                    dropoff_elevator = false;
                }

                date = $("#date").val();
                time = $("#time").val();
                break;
            case 2:
                large_items = $("#large_items").val();
                small_items = $("#small_items").val();

                large_items_assembly = $("#large_item_assembly").val();
                small_items_assembly = $("#small_item_assembly").val();

                teleporters = $("#teleporters").val();
                own_helpers = $("#own_helpers").val();
                break;
            case 3:
                name = $("#name").val();
                phone_number = $("#phone_number").val();
                email = $("#email").val();
                comments = $("#comment").val();
                break;
        }
    }

    function set_driving_time(time){
        driving_time = time;
    }

    function calculate(withDrivingTime){
        if(withDrivingTime){
            get_driving_time();
        }

        var total_price;

        if(teleporters > 1){
            total_price = two_teleporters_price();
        } else {
            total_price = teleporter_price();
        }



        if(total_price < minimum_price){
            total_price = minimum_price;
        }

        total_time = total_labor_time() * 24 + driving_time ;



        if(parseFloat($('#estimate-time').html()) == 0){
            if(parseFloat($('#estimate-time-field').val()) > 0){
                total_time += parseFloat($('#estimate-time-field').val());
            }
        }

        total_time += old_time;

        $('#estimate-time').html(roundUp(total_time, 100));
        $('#estimate-time-field').val(roundUp(total_time, 100));

    }

    function get_driving_time(){
        if(origin_address != "" && destination_address.length != ""){

            service = new google.maps.DistanceMatrixService();
            service.getDistanceMatrix(
                {
                    origins: [origin_address],
                    destinations: [destination_address],
                    travelMode: google.maps.TravelMode.DRIVING,
                    avoidHighways: false,
                    avoidTolls: false
                },
                callback
            );

            function callback(response, status) {
                if(status=="OK") {
                    distance = response.rows[0].elements[0].distance.value / 1000;
                    driving_time = response.rows[0].elements[0].duration.value / 60 / 60;
                    set_distance(distance);
                    calculate(false)
                }
            }
        }
    }

    function set_distance(distance){
        $('#distance').val(distance);
    }

    function append_time(time){
        $('#estimate-time').html(time);

        $('#estimate-time-field').val(time);
    }

    function labor_price(){
        var result = labor_rate * total_labor_time() * 24;
        return result;
    }

    function update_value(){
        $('#estimate-time').html($('#estimate-time-field').val());

    }

    function total_labor_time(){
        var pickup_time = calculate_pickup_time();
        console.log('Pickup time' + pickup_time);
        var dropoff_time = calculate_dropoff_time();
        console.log('Drop off time' + dropoff_time);
        var result = pickup_time + dropoff_time;

        return roundTime(result);
    }

    function roundTime(time){
        time = time * 24 * 60;

        if(time < 1000){
            time = roundUp(time / 100, 10) * 100;
        } else {
            time = roundUp(time, 10);
        }
        return time / 60 / 24;
    }


    function calculate_pickup_time(){
        if(large_items > 0 || small_items > 0){
            if(calculate_pickup_coeficient() > 24){
                return calculate_pickup_coeficient()/24 + 24;
            } else {
                return calculate_pickup_coeficient()/24
            }
        } else {
            return 0;
        }
    }

    function calculate_dropoff_time(){
        if(large_items > 0 || small_items > 0){
            if(calculate_dropoff_coeficient() > 24){
                return calculate_dropoff_coeficient()/24 + 24;
            } else {
                return calculate_dropoff_coeficient()/24
            }
        } else {
            console.log('neturim itemu');
            return 0;
        }
    }

    function calculate_pickup_coeficient(){

        if(!pickup_elevator && !dropoff_elevator){
            return loading_unloading_time_pickup() + big_small_for_each_floor_pickup();
        } else if(dropoff_elevator || !dropoff_elevator){
            return loading_unloading_time_pickup() + big_small_for_each_floor_pickup()
        } else if(pickup_elevator && !dropoff_elevator){
            return loading_unloading_time_pickup() + big_small_with_elevator_pickup();
        } else if(dropoff_elevator || !dropoff_elevator){
            return loading_unloading_time_pickup() + big_small_with_elevator_pickup();
        } else {
            return 0;
        }
    }

    function calculate_dropoff_coeficient(){
        if(!pickup_elevator && !dropoff_elevator){
            return loading_unloading_time_dropoff() + big_small_for_each_floor_dropoff();
        } else if(dropoff_elevator) {
            return loading_unloading_time_dropoff() + big_small_for_each_floor_dropoff();
        } else if(!dropoff_elevator){
            return loading_unloading_time_dropoff() + big_small_for_each_floor_dropoff() + big_small_additional_time();
        } else if(pickup_elevator && !dropoff_elevator){
            return loading_unloading_time_dropoff() + big_small_with_elevator_dropoff();
        } else if(dropoff_elevator){
            return loading_unloading_time_dropoff() + big_small_with_elevator_pickup();
        } else if(!dropoff_elevator){
            return loading_unloading_time_dropoff() + big_small_with_elevator_pickup() + big_small_additional_time();
        } else {
            return 0;
        }
    }


    function all_movers(){
        return (parseInt(teleporters) + parseInt(own_helpers));
    }

    function loading_unloading_time_pickup(){
        return ((large_items * 0.1265) + (small_items * 0.05)) / all_movers();
    }

    function loading_unloading_time_dropoff(){
        return ((large_items * 0.1265) + (small_items * 0.05)) / teleporters;
    }

    function big_small_for_each_floor_pickup(){
        return (0.01875 * pickup_floors) * large_items + ((0.0025 * pickup_floors) * small_items) / all_movers();
    }

    function big_small_for_each_floor_dropoff(){
        return (0.01875 * dropoff_floors) * large_items + ((0.0025 * dropoff_floors) * small_items) / teleporters;
    }

    function big_small_with_elevator_pickup(){
        return (0.0141 * pickup_floors) * large_items + ((0.0045 * pickup_floors) * small_items) / all_movers();
    }

    function big_small_with_elevator_dropoff(){
        return (0.0141 * dropoff_floors) * large_items + ((0.0045 * dropoff_floors) * small_items) / teleporters;
    }

    function big_small_additional_time(){
        return (0.0042 * dropoff_floors) * large_items + ((0.0042 * dropoff_floors) * small_items) / all_movers();
    }


    function teleporter_price(){
        if(large_items_assembly > 0 || small_items_assembly > 0){
            assembly_price_big = large_items_assembly * big_assembly_time * 24 * asamblee_rate;
            assembly_price_small = small_items_assembly * small_assembly_time * 24 * asamblee_rate;
            return mover_distance_price() + labor_price() + assembly_price_big + assembly_price_small;
        } else {
            var result = labor_price() + mover_distance_price();
            return result;
        }
    }

    function two_teleporters_price(){
        if(large_items_assembly > 0 || small_items_assembly > 0){
            var assembly_price_big = large_items_assembly * big_assembly_time * 24 * asamblee_rate;
            var assembly_price_small = small_items_assembly * small_assembly_time * 24 * asamblee_rate;
            return (teleporter_price() + (total_labor_time() + driving_time) * 24 * extra_teleporter_rate) + assembly_price_big + assembly_price_small;
        } else {
            var result = teleporter_price() + (total_labor_time() + driving_time) * 24 * extra_teleporter_rate;
            return result;
        }
    }

    function mover_distance_price(){
        return driving_rate * distance;
    }

    function roundUp(num, precision) {
        return Math.ceil(num * precision) / precision;
    }

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




$( document ).ready(function(){

    update_value();

    //Checking when something was entered on fields
    $("#pickup_address").change(function(){
        pickup_address = $(this).val();
        calculate();
    });
    $("#pickup_floor").change(function(){
        pickup_floors = parseInt($(this).val());
        $(".pickup_floor_value").html(pickup_floors);
        calculate(true);
    });
    $("#pickup_elevator").change(function(){
        if($(this).val() == "No"){
            pickup_elevator = false;
            $(".pickup_elevator_value").html("No");
        } else {
            pickup_elevator = true;
            $(".pickup_elevator_value").html("Yes");
        }
        calculate(true);
    });

    $("#drop_off_address").change(function(){
        dropoff_address = $(this).val();
        calculate(true);
    });
    $("#drop_off_floor").change(function(){
        dropoff_floors = parseInt($(this).val());
        $(".drop_off_floor_value").html(dropoff_floors);
        calculate(true);
    });

    $("#drop_off_elevator").change(function(){
        if($(this).val() == "No"){
            dropoff_elevator = false;
            $(".drop_off_elevator_value").html('No');
        } else {
            dropoff_elevator = true;
            $(".drop_off_elevator_value").html('Yes');
        }
        calculate(true);
    });

    $("#large_items").change(function(){
        large_items = parseInt($(this).val());
        $(".large_items_value").html(large_items);
        calculate(true);
    });
    $("#small_items").change(function(){
        small_items = parseInt($(this).val());
        $(".small_items_value").html(small_items);
        calculate(true);
    });

    $("#large_item_assembly").change(function(){
        large_items_assembly = parseInt($(this).val());
        $(".large_item_assembly_value").html(large_items_assembly);
        calculate(true);
    });
    $("#small_item_assembly").change(function(){
        small_items_assembly = parseInt($(this).val());
        $(".small_item_assembly_value").html(small_items_assembly);
        calculate(true);
    });

    $("#teleporters").change(function(){
        teleporters = parseInt($(this).val());
        $(".teleporters_value").html(teleporters);
        calculate(true);
    });
    $("#own_helpers").change(function(){
        own_helpers = parseInt($(this).val());
        $(".own_helpers_value").html(own_helpers);
        calculate(true);
    });

    //GeoComplete
    var pickup_street = $('#pickup_street');
    var pickup_house_number = $('#pickup_house_number');
    var pickup_city = $('#pickup_city');
    var pickup_zip = $('#pickup_zip');
    var pickup_country = $('#pickup_country');
    var pickup_lat = $('#pickup_lat');
    var pickup_long = $('#pickup_long');
    var pickup_administrative_area = $('#pickup_administrative_area');

    var drop_off_street = $('#drop_off_street');
    var drop_off_house_number = $('#drop_off_house_number');
    var drop_off_city = $('#drop_off_city');
    var drop_off_zip = $('#drop_off_zip');
    var drop_off_country = $('#drop_off_country');
    var drop_off_lat = $('#drop_off_lat');
    var drop_off_long = $('#drop_off_long');
    var drop_off_administrative_area = $('#drop_off_administrative_area');


    $("#pickup_address").geocomplete()
        .bind("geocode:result", function(event, result){
            origin_address = result.formatted_address;
            console.log(result.geometry.location.lat());
            $.ajax({
                type: "GET",
                url: 'http://nominatim.openstreetmap.org/reverse?format=json&lat='+result.geometry.location.lat()+'&lon='+result.geometry.location.lng()+'&addressdetails=1&accept-language=en',
                success: function( response ) {
                    console.log(response);
                    pickup_street.val(response.address.road);
                    pickup_house_number.val(response.address.house_number);
                    if(response.address.city != null){
                        pickup_city.val(response.address.city);
                    } else if(response.address.town != null) {
                        pickup_city.val(response.address.town);
                    } else {
                        pickup_city.val(response.address.village);
                    }

                    pickup_zip.val(response.address.postcode);
                    pickup_country.val(response.address.country);
                    pickup_lat.val(response.lat);
                    pickup_long.val(response.lon);
                    var state = response.address.state;
                    pickup_administrative_area.val(state.replace(' County', ''));
                }
            });


            calculate(true);
        });

    $("#drop_off_address").geocomplete()
        .bind("geocode:result", function(event, result){
            destination_address = result.formatted_address;

            $.ajax({
                type: "GET",
                url: 'http://nominatim.openstreetmap.org/reverse?format=json&lat='+result.geometry.location.lat()+'&lon='+result.geometry.location.lng()+'&addressdetails=1',
                success: function( response ) {
                    drop_off_street.val(response.address.road);
                    drop_off_house_number.val(response.address.house_number);
                    if(response.address.city == null){
                        drop_off_city.val(response.address.town);
                    } else {
                        drop_off_city.val(response.address.city);
                    }
                    drop_off_zip.val(response.address.postcode);
                    drop_off_country.val(response.address.country);
                    drop_off_lat.val(response.lat);
                    drop_off_long.val(response.lon);
                    var state = response.address.state;
                    drop_off_administrative_area.val(state.replace(' County', ''));
                }
            });

            calculate(true);
        });
});





//Getting items number from main.js

function large_items_number(number){
    large_items = number;
    calculate(true);
}

function small_items_number(number){
    small_items = number;
    calculate(true);
}