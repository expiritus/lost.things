$(document).ready(function(){

    //ФОРМА ----------------------------------------------

    var country = $("select[name='country']");
    var city = $("select[name='city']").hide();
    var area = $("#areas");
    var streets = $('#streets');
    var otherThing = $("#other_thing");
    var submitFindForm = $("input[name='submit_find_form']").hide();
    var street = $("input[name='street']").hide();

    var thing = $("select[name='thing']").hide();
    var waitImage = $('.wait_data').hide();

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
    // КОНЕЦ ОБРАБОТКИ ФОРМЫ ===============================================================================









    // ЛИЧНЫЙ КАБИНЕТ ----------------------------------------------------------------------------------------
    $('.delete_lost').on('click', function(){
        var lost_id = $(this).attr('value');
        $.ajax({
            url: "/personal-area/delete-lost/"+lost_id,
            method: "DELETE",
            success: function(data){
                if(data){
                    $('.lost-'+lost_id).html("");
                    var child_lost = $('.lost_things').children().contents().length;
                    if(child_lost == 1){
                        $('.lost_things h1').html("");
                    }
                }
            }
        });
    });

    $('.delete_find').on('click', function(){
        var find_id = $(this).attr('value');
        $.ajax({
            url: "/personal-area/delete-find/"+find_id,
            method: "DELETE",
            success: function(data){
                if(data){
                    $('.find-'+find_id).html("");
                    var child_find = $('.find_things').children().contents().length;
                    if(child_find == 1){
                        $('.find_things h1').html("");
                    }
                }
            }
        });
    });


    var refresh_lost = $('.refresh_lost');
    var refresh_lost_id = refresh_lost.attr('value');

    refresh_lost.on('click', function(){
        var refresh_lost_id = $(this).attr('value');
        $.ajax({
            url: "/personal-area/refresh-lost/"+refresh_lost_id,
            method: "POST",
            data: {
                id: refresh_lost_id
            },
            dataType: "json",
            success: function(data){
                $('.count_matches_lost_'+refresh_lost_id+' span').empty().append(data);
            }
        });
    });

    refresh_lost.click();

    var refresh_find = $('.refresh_find');
    var refresh_find_id = refresh_find.attr('value');

    refresh_find.on('click', function(){
        var refresh_find_id = $(this).attr('value');
        $.ajax({
            url: "/personal-area/refresh-find/"+refresh_find_id,
            method: "POST",
            data: {
                id: refresh_find_id
            },
            dataType: "json",
            success: function(data){
                $('.wait_data_find_'+refresh_find_id).hide();
                $('.count_matches_find_'+refresh_find_id+' span').empty().append(data);
            }
        });
    });

    refresh_find.click();
    // КОНЕЦ ОБРАБОТКИ ЛИЧНОГО КАБИНЕТА


    //ПОПАП ДЛЯ ЛИЧНОГО СООБЩЕНИЯ
    var private_message = $('.send_user_pm .button_link');
    var dialog = $(".dialog");
    dialog.dialog({ autoOpen: false });
    private_message.on('click', function(){
        var user = $(this).attr('value');
        $('.whom').attr('value', user);
        dialog.dialog({
            title: "Send a message to "+user,
            resizable: false,
            modal: true,
            width: 600,
            height: 400,
            show: { effect: "slideDown", duration: 300},
            hide: { effect: "slideUp", duration: 300}
        });
        dialog.dialog('open');
        var button = $('.submit_pm').attr('type', 'button');
        button.on('click', function(){
            var message = $('.message').val();
            if(message.length > 0){
                button.attr('type', 'submit');
            }
        });
    });

    var dont_read_messages = $('.dont_read_messages');
    if(dont_read_messages){
        var from_user = $('.from_user').attr('value');
        dont_read_messages.dialog({ autoOpen: false });
        $('.whom').attr('value', from_user);
        dont_read_messages.dialog({
            //title: "Message from "+from_user,
            resizable: false,
            modal: true,
            width: 600,
            height: 400,
            show: { effect: "slideDown", duration: 300},
            hide: { effect: "slideUp", duration: 300}
        });
        dont_read_messages.dialog('open');
    }

    var all_messages = $('#all_messages');
    if(all_messages.length > 0){
        var received_user_id = $('#send_correspondence').attr('value');
        setInterval(function(){
            $.ajax({
                url: "/personal-area/update-message/"+received_user_id,
                method: "POST",
                success: function(data){
                    $(all_messages).html(data);
                }
            });
        },60000);
    }
    all_messages.scrollTop(100000);

    var all_correspondence = $('.all_correspondence');
    var el = all_correspondence.children();
    var val = all_correspondence.children().text();
    var seen = {};
    $('.all_correspondence li').each(function() {
        var txt = $(this).text();
        if (seen[txt])
            $(this).remove();
        else
            seen[txt] = true;
    });

    //КОНЕЦ ОБРАБОТКИ ЛИЧНОГО СООБЩЕНИЯ
});
