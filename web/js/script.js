$(document).ready(function(){
    var country = $("select[name='country']");
    var city = $("select[name='city']").hide();
    var area = $("#areas");
    var streets = $('#streets');
    var otherThing = $("#other_thing");
    var submitFindForm = $("input[name='submit_find_form']").hide();
    var street = $("input[name='street']").hide();

    var thing = $("select[name='thing']").hide();
    var waitImage = $('#wait_data').hide();
    var buttonNextStreet = $('#button_next_street').hide();
    var buttonNextThing = $('#button_next_thing').hide();
    var description = $("textarea[name='description']").hide();

    $("input[name='area']").hide();
    $("input[name='other_thing']").hide();
    $("input[name='find_foto']").hide();
    $("input[name='lost_foto']").hide();


    function wait(){
        waitImage.show();
    }

    //Запрос в базу для открытия поля city
    country.on("change", function(){
	$("input[name='find_foto']").hide();
        $("input[name='area']").val('').hide();
        $("input[name='street']").val('');
        $("input[name='other_thing']").val('').hide();
        description.hide();
        street.hide();
        thing.hide()
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
                waitImage.hide();
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
	$("input[name='find_foto']").hide();
        $("input[name='area']").val('');
        $("input[name='street']").val('');
        $("input[name='other_thing']").val('').hide();
        buttonNextThing.hide();
        description.hide();
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
                waitImage.hide();
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
        var city_id = city.val();
        $.ajax({
            url: "/find/getstreet/",
            method: "POST",
            data: {
                city_id: city_id
            },
            dataType: "json",
            beforeSend: wait(),
            success: function(data){
                waitImage.hide();
                street.show().empty();
                streets.empty();
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
        //description.show();
        buttonNextThing.hide();
        $.ajax({
            url: "/find/getthing/",
            method: "POST",
            dataType: "json",
            beforeSend: wait(),
            success: function(data){
                waitImage.hide();
                thing.show().empty().append($("<option value='-1'>Choice thing</option>"));
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
        submitFindForm.show();
        var yesOrNo = thing.val();
        if(yesOrNo == 0){
            description.show();
            $("input[name='other_thing']").val('').show().attr('required', true);
            $("input[name='find_foto']").show();
            $("input[name='lost_foto']").show();
        }else{
            description.show();
            $("input[name='other_thing']").val('').hide().attr('required', false);
            $("input[name='find_foto']").show();
            $("input[name='lost_foto']").show();
        }
        if(yesOrNo == -1){
            $("input[name='find_foto']").hide();
            $("input[name='lost_foto']").hide();
            description.hide();
            submitFindForm.hide();
        }
    });
});
