$(document).ready(function() {

    var map = 'lithuania.svg';

    for(var i = 0; i < 2; i++){
        var mapId = i;
        $('#map' + i).mapSvg({
            source: '/moving/maps/geo-calibrated/' + $('#map' + i).attr('country') + '.svg',
            responsive: 1,
            zoom: {on:0},
            scroll: {on:0},
            menu: {on: 1, containerId: 'mapsvg-menu'},
            multiSelect: true,
            colors: {
                baseDefault: "#e5e5e5",
                background: "rgba(238,238,238,0)",
                selected: 30,
                hover: 18,
                base: "#a18c8c",
                stroke: "#ffffff"
            },
            popovers: {mode: function(){
                selectedRegions(this)
            }, on: true, priority: "local"},
            afterLoad: function(){
                var mapsvg = this;

                for(var j = 0; j < parseInt($('#map_regions_selected').html()); j++){
                    mapsvg.selectRegion($('#map_region' + j).html());
                }
            }
        });
    }

    $('#country').live('change', function(){
        addCountry($(this).val().toLowerCase().replace(/\s/g, "-"), $(this).val());
    });

    $('.removeButton').live('click', function(){
        deleteCountry($(this).attr('country'));
        $(this).remove();
        return false;
    });

    populateCountries("country");


    function selectedRegions(region){
        //alert(region.id + " " + region.title);
        if(region.selected) {
            addRegion(region.id, region.title);
        } else {
            removeRegion(region.id);
        }
    }

    function addCountry(name, realName){
        $('div#'+name).remove();

        $('#maps').append('<div id="map'+ ($(".map").length + 1) +'" country="'+name+'" class="mapsvg mapsvg-responsive map" style="width: 350px"></div><div country="'+name+'">' + realName +' <a href="/moving/movers/preferences/remove/country/'+name+'" country="'+name+'" class="btn small green removeButton">remove</a></div>')

        var mapNr = $(".map").length;

        $('#map' + mapNr).mapSvg({
            source: '/moving/maps/geo-calibrated/' + name + '.svg',
            responsive: 1,
            zoom: {on:0},
            scroll: {on:0},
            menu: {on: 1, containerId: 'mapsvg-menu'},
            multiSelect: true,
            colors: {
                baseDefault: "#e5e5e5",
                background: "rgba(238,238,238,0)",
                selected: 30,
                hover: 18,
                base: "#a18c8c",
                stroke: "#ffffff"
            },
            popovers: {mode: function(){
                selectedRegions(this)
            }, on: true, priority: "local"}
        });
    }

    function deleteCountry(name){
        $("input[value='"+name+"']").each(function(){
            $(this).parent().remove();
        });
        $('div[country="'+name+'"]').remove();
        $('.hidden-items').append('<div class="deleted_country" id="'+name+'"><input type="hidden" name="country_delete[]" value="'+name+'"></div>');
    }

    function addRegion(id, title){

        $('.hidden-items').append('<div id="'+id+'"><input type="hidden" name="region_name[]" value="'+title+'">' +
        '<input type="hidden" name="identifier[]" value="'+id+'">' +
        '<input type="hidden" name="country[]" value="'+id.substring(0, 2)+'">' +
        '<input type="hidden" name="user_id[]" value="'+userId+'"> </div>');
    }

    function removeRegion(id){
        $('div#'+id).remove();
    }



});