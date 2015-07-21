$(document).ready(function(){
    var country = $("select[name='country']");
    var city = $("select[name='city']").hide();
    var area = $("#areas");
    var streets = $('#streets');
    var otherThing = $("#other_thing");
    $("input[name='area']").hide();
    $("input[name='other_thing']").hide();
    var street = $("input[name='street']").hide();

    var thing = $("select[name='thing']").hide();
    var waitImage = $('#wait_data').hide();
    var buttonNextStreet = $('#button_next_street').hide();
    var buttonNextThing = $('#button_next_thing').hide();

    function wait(){
        waitImage.show();
    }

    //Запрос в базу для открытия поля city
    country.on("change", function(){
        var country_id = country.val();
        $.ajax({
            url: "/find/getcity/",
            method: "POST",
            data: {
                country_id: country_id
            },
            dataType: "json",
            beforeSend: wait(),
            success: function(data){
                waitImage.empty();
                city.empty();
                city.show().append($("<option value='0'>Choice city</option>"));
                $.each(data, function(index, value){
                    $(city).append($("<option value='"+value.id+"'>"+value.city+"</option>"));
                });
            }
        });
    });

    //Запрос в базу для открытия поля area
    city.on("change", function(){
        $("input[name='area']").val('');
        $("input[name='street']").val('');
        $("input[name='other_thing']").val('').hide();
        street.hide();
        thing.hide();
        var city_id = city.val();

        $.ajax({
            url: "/find/getarea/",
            method: "POST",
            data: {
                city_id: city_id
            },
            dataType: "json",
            beforeSend: wait(),
            success: function(data){
                $("input[name='area']").show();
                buttonNextStreet.show();
                area.show().empty();
                $.each(data, function(index, value){
                    $(area).append($("<option value='"+value.area+"'>"+value.area+"</option>"));
                });
            }
        });
    });

    //Запрос в базу для открытия поля street
    buttonNextStreet.on("click", function(){
        var area_id = area.val();
        $.ajax({
            url: "/find/getstreet/",
            method: "POST",
            data: {
                area_id: area_id
            },
            dataType: "json",
            beforeSend: wait(),
            success: function(data){
                street.show().empty();
                streets.empty();
                //thing.show().empty();
                buttonNextStreet.hide();
                buttonNextThing.show();
                $.each(data, function(index, value){
                    $(streets).append($("<option value='"+value.street+"'>"+value.street+"</option>"));
                });
            }
        });
    });


    //Запрос в базу для открытия поля thing
    buttonNextThing.on("click", function(){
        $("input[name='other_thing']").hide();
        buttonNextThing.hide();
        $.ajax({
            url: "/find/getthing/",
            method: "POST",
            dataType: "json",
            beforeSend: wait(),
            success: function(data){
                waitImage.empty();
                thing.show().empty().append($("<option>Choice thing</option>"));
                $.each(data, function(index, value){
                    if(value.baseThing == true){
                        $(thing).append($("<option value='"+value.id+"'>"+value.nameThing+"</option>"));
                    }
                    $(otherThing).append($("<option value='"+value.nameThing+"'>"+value.nameThing+"</option>"));
                });
                thing.append($("<option value='0'>Other</option>"));
            }
        });
    });
    thing.on("change", function(){
        var yesOrNo = thing.val();
        if(yesOrNo == 0){
            $("input[name='other_thing']").val('').show();
        }else{
            $("input[name='other_thing']").val('').hide();
        }
    });
});
