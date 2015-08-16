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
        var empty_choice = $("select[name='country']").val();
        if(empty_choice == 0){
            city.hide();
            $("input[name='area']").hide();
            street.hide();
            thing.hide();
            $("input[name='other_thing']").hide();
            description.hide();
            $("input[name='find_foto']").hide();
            $("input[name='lost_foto']").hide();
            buttonNextStreet.hide();
            buttonNextThing.hide();
            var submitFindForm = $("input[name='submit_find_form']").hide();
            return;
        }
        $("input[name='find_foto']").hide();
        $("input[name='area']").val('').hide();
        $("input[name='street']").val('');
        $("input[name='other_thing']").val('').hide();
        description.hide();
        street.hide();
        thing.hide();
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
                city.show().append($("<option value='0'>Выберите город</option>"));
                $.each(data, function(index, value){
                    $(city).append($("<option value='"+value.id+"'>"+value.city+"</option>"));
                });
            }
        });

    });

    //Запрос в базу для открытия поля area
    city.on("change", function(){
        var empty_choice = $("select[name='city']").val();
        if(empty_choice == 0){
            $("input[name='area']").hide();
            street.hide();
            thing.hide();
            $("input[name='other_thing']").hide();
            description.hide();
            $("input[name='find_foto']").hide();
            $("input[name='lost_foto']").hide();
            buttonNextStreet.hide();
            buttonNextThing.hide();
            var submitFindForm = $("input[name='submit_find_form']").hide();
            return;
        }
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
                thing.show().empty().append($("<option value='-1'>Выберито то, что вы ищите</option>"));
                $.each(data, function(index, value){
                    if(value.baseThing == true){
                        $(thing).append($("<option value='"+value.id+"'>"+value.nameThing+"</option>"));
                    }
                    $(otherThing).append($("<option value='"+value.nameThing+"'>"+value.nameThing+"</option>"));
                });
                thing.append($("<option value='0'>Другое...</option>"));
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
    var edit_lost = $('.edit_lost');
    edit_lost.on('click', function(){
        var edit_lost_id = $(this).attr('value');
        var edit_description = $(".edit_description_"+edit_lost_id);
        $.ajax({
            url: "/personal-area/edit-lost/"+edit_lost_id,
            method: "POST",
            success: function(data){
                edit_description.html(
                    "<textarea class='edit_textarea' placeholder='Описание' name='update_description'>"+data+"</textarea>" +
                    "<button class='button_link'  id='save_edit_lost_"+edit_lost_id+"' name='save_edit_lost' type='button' value='"+edit_lost_id+"'>Сохранить</button>"
                );
                var save_edit_lost = '#save_edit_lost_'+edit_lost_id;
                if($(save_edit_lost).length > 0){
                    $(save_edit_lost).on('click', function(){
                        var update_description = $('.edit_textarea').val();
                        $.ajax({
                            url: "/personal-area/edit-lost/"+edit_lost_id,
                            method: "POST",
                            data:{
                                update_description: update_description,
                                save_edit_lost: 1,
                                edit_lost_id: edit_lost_id
                            },
                            success: function(data){
                                edit_description.html('');
                                $(".edit_description_"+edit_lost_id).html("<span>Описание: </span>"+data);
                            }
                        });
                    });
                }
            }
        });
    });


    var edit_find = $('.edit_find');
    edit_find.on('click', function(){
        var edit_find_id = $(this).attr('value');
        var edit_description = $(".edit_description_"+edit_find_id);
        $.ajax({
            url: "/personal-area/edit-find/"+edit_find_id,
            method: "POST",
            success: function(data){
                edit_description.html(
                    "<textarea class='edit_textarea' placeholder='Описание' name='update_description'>"+data+"</textarea>" +
                    "<button class='button_link'  id='save_edit_find_"+edit_find_id+"' name='save_edit_find' type='button' value='"+edit_find_id+"'>Сохранить</button>"
                );
                var save_edit_find = '#save_edit_find_'+edit_find_id;
                if($(save_edit_find).length > 0){
                    $(save_edit_find).on('click', function(){
                        var update_description = $('.edit_textarea').val();
                        $.ajax({
                            url: "/personal-area/edit-find/"+edit_find_id,
                            method: "POST",
                            data:{
                                update_description: update_description,
                                save_edit_find: 1,
                                edit_lost_id: edit_find_id
                            },
                            success: function(data){
                                edit_description.html('');
                                $(".edit_description_"+edit_find_id).html("<span>Описание: </span>"+data);
                            }
                        });
                    });
                }
            }
        });
    });



    //var edit_find = $('.edit_find');
    //edit_find.on('click', function(){
    //    var edit_find_id = $(this).attr('value');
    //    var edit_description = $(".edit_description_"+edit_find_id);
    //    $.ajax({
    //        url: "/personal-area/edit-find/"+edit_find_id,
    //        method: "POST",
    //        success: function(data){
    //            edit_description.html(
    //                "<form action='/personal-area/edit-find/"+edit_find_id+"' method='POST'>" +
    //                "<textarea class='edit_textarea' placeholder='Описание' name='update_description'>"+data+"</textarea>" +
    //                "<button class='button_link' type='submit' value='"+edit_find_id+"'>Сохранить</button>" +
    //                "</form>");
    //        }
    //    });
    //});


    $('.delete_lost').on('click', function(){
        var lost_id = $(this).attr('value');
        $.ajax({
            url: "/personal-area/delete-lost/"+lost_id,
            method: "DELETE",
            success: function(data){
                if(data){
                    $('.lost-'+lost_id).html("").css({
                        'borderBottom': 'none'
                    });
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
                    $('.find-'+find_id).html("").css({
                        'borderBottom': 'none'
                    });
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
            title: "Написать сообщение "+user,
            resizable: false,
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
            //modal: true,
            width: 600,
            height: 400,
            show: { effect: "slideDown", duration: 300},
            hide: { effect: "slideUp", duration: 300}
        });
        dont_read_messages.dialog('open');
    }

    var all_messages = $('#all_messages');
    if(all_messages.length > 0){
        var send_correspondence = $("#send_correspondence");
        var received_user_id = send_correspondence.attr('value');
        send_correspondence.on('click', function(){
            var send_message_input = $('#send_message_input');
            var message = send_message_input.val();
            if(message.length > 0){
                $.ajax({
                    url: "/personal-area/update-message/"+received_user_id,
                    method: "POST",
                    data:{
                        message: message
                    },
                    success: function(data){
                        $(all_messages).html(data);
                        all_messages.scrollTop(100000);
                    }
                });
                $('#send_message_input').val('');
            }else{
                setInterval(function(){
                    $.ajax({
                        url: "/personal-area/update-message/"+received_user_id,
                        method: "POST",
                        success: function(data){
                            $(all_messages).html(data);
                            all_messages.scrollTop(100000);
                        }
                    });
                },60000);
            }
        });
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



    //ФОРМА ВВОДА ЛОГИНА И ПАРОЛЯ
    var login_form = $('#login_form');
    var register_form = $('#register_form');
    var resetting_form = $('#resetting_form');
    var reset_password = $('#reset_password');
    var fos_user_user_show = $('.fos_user_user_show');
    var contact_form = $('#contact_form');
    if(login_form.length > 0
        || register_form.length > 0
        || resetting_form.length > 0
        || reset_password.length > 0
        || fos_user_user_show.length > 0
        || contact_form.length > 0
    ){
        var flag = $('a[href^="#"], a[href^="."]');
        if($(window).scrollTop != 0) {
            var scroll_el = flag.attr('href');
            if (scroll_el.length != 0) {
                $('html, body').animate({scrollTop: $(scroll_el).offset().top}, 800);
            }
            return false; // выключаем стандартное действие
        }
    }

    //КОНЕЦ ФОРМЫ ВВОДА ЛОГИНА И ПАРОЛЯ

    $('html').keydown(function(eventObject){ //отлавливаем нажатие клавиш
        if($('#send_correspondence').length >0){
            if (eventObject.keyCode == 13) { //если нажали Enter, то true
                $('#send_correspondence').click();
                return false;
            }
        }
    });
    $('.send_message_input').focus();

    //Colorbox
    $(".colorbox").on('click', function(){
        $(this).colorbox();
    });
    //
});
