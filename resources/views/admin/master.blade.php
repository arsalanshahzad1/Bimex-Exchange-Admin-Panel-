<!DOCTYPE HTML>
<html class="no-js" lang="en">
<head>
    @include('admin.include.header_asset')
</head>
@php
    $menu = $menu ?? '';
    $sub_menu = $sub_menu ?? '';
@endphp
<body class="body-bg">
<!-- google_analytics start -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{allsetting('google_analytics_tracking_id')}}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', {{allsetting('google_analytics_tracking_id')}});
</script>
<!-- google_analytics end -->
<!-- Start sidebar -->
@yield('sidebar',view('admin.include.sidebar',compact(['menu','sub_menu'])))
<!-- End sidebar -->
<!-- top bar -->
@include('admin.include.header')
<!-- /top bar -->

<!-- main wrapper -->
<div class="main-wrapper">
    <div class="container-fluid">
        @yield('content')
        @include('admin.chat.chat-list')
        @include('admin.chat.chat')
        @include('admin.chat.add-user-to-chat')
    </div>
</div>
<!-- /main wrapper -->

<!-- js file start -->

<!-- JavaScript -->
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
@include('admin.include.footer_asset')

<script>

    (function($) {
        "use strict";
        @if(session()->has('success'))
            window.onload = function () {
            VanillaToasts.create({
                text: '{{session('success')}}',
                backgroundColor: "linear-gradient(135deg, #73a5ff, #5477f5)",
                type: 'success',
                timeout: 40000
            });
        };
        @elseif(session()->has('dismiss'))
            window.onload = function () {
            VanillaToasts.create({
                text: '{{session('dismiss')}}',
                type: 'warning',
                timeout: 40000
            });
        };
        @elseif($errors->any())
            @foreach($errors->getMessages() as $error)
            window.onload = function () {
            VanillaToasts.create({
                text: '{{ $error[0] }}',
                type: 'warning',
                timeout: 40000
                });
             };
             @break
             @endforeach
        @endif

        /* Add here all your JS customizations */
        $('.number-only').keypress(function (e) {
            alert(11);
            var regex = /^[+0-9+.\b]+$/;
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });
        $('.no-regx').keypress(function (e) {
            var regex = /^[a-zA-Z+0-9+\b]+$/;
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            e.preventDefault();
            return false;
        });


        /*Setting Modal*/
        $(".setting").click(function () {
            $(".setting > div.dropdown-menu ").toggleClass("show");
        }).on("focusout", function() {
            $(".setting > div.dropdown-menu ").removeClass("show");
        })

        /*Notification Modal*/
        $(".notification_dropdown > .bell-icon").click(function(){
            $(`.of-visible`).toggleClass("show");
        }).on("focusout", function() {
            $(`.of-visible`).removeClass("show");
        })

        /*Chat Modal*/
        

        var chat_list = $("#chat_list_main");
        var chat_main = $("#chat_main");
        var user_list_main = $("#user_list_main");
        $(".close-chat-box").click(function(){
            $(".chatbox").removeClass('active')
        });
        $("li.messages").click(function() {
            getChatList();
            chat_list.toggleClass("active");
        })
        $(".show-message-box").click(function(){
            getChatList();
            chat_list.addClass('show-aside');
        })
        $(".chat-close").click(function(){
            chat_list.removeClass('show-aside')
        });
        $(document).on('click','.show-chat-btn',function(){
            getSingleChat($(this).data('friendship_id'),$(this).data('user_id'))
            chat_list.removeClass('active')
            chat_main.addClass('active')
        });
        $(".back-chat-btn").click(function(){
            getChatList();
            chat_main.removeClass('active')
            chat_list.addClass('active')
        });
        $(".back-user-list-btn").click(function(){
            getChatList();
            user_list_main.removeClass('active')
            chat_list.addClass('active')
        });
        $(".open-user-list").click(function(){
            getAllUser()
            chat_list.removeClass('active')
            user_list_main.addClass('active')
        });
        $(document).on('click','.add-to-chat-list',function(){
            addUserToChat($(this).data('id'),$(this))
        })
        function addUserToChat(user_id,event)
        {
            event.find('.title').text('Loading...');
            $.ajax({
                url: "{{url('/admin/add-user-to-chat')}}",
                headers: {
                    'userapisecret':'h0vWu6MkInNlWHJVfIXmHbIbC66cQvlbSUQI09Whbp',
                },
                method:'post',
                data:{_token:"{{csrf_token()}}",user_id:user_id},
                success:function(data){
                    user_list_main.removeClass('active');
                    chat_main.addClass('active')
                    getSingleChat(data?.data?.id);
                },
                error:function(error){
                }
            });
        }
        function getAllUser()
        {
            var user_loader = $("#user_list_main .data-loader");
            user_loader.show();
            $("#user_list").empty();
            $.ajax({
                url: "{{url('/admin/get-all-users')}}",
                headers: {
                    'userapisecret':'h0vWu6MkInNlWHJVfIXmHbIbC66cQvlbSUQI09Whbp',
                },
                method:'get',
                success:function(data){
                    user_loader.hide();
                    const user = data?.data;
                    userListMap(user);
                },
                error:function(error){
                    user_loader.hide();
                }
            });
        }
        function userListMap(user)
        {
            $("#user_list").empty();
            $.each(user, function (key, obj) {
                const {id,display_name,first_name,last_name} = obj;
                $("#user_list").append(`
                <li class="active dz-chat-user add-to-chat-list" data-id="${id}">
                    <div class="d-flex bd-highlight">
                        <div class="img_cont">
                            <img src="{{show_image('${id}','user')}}" class="rounded-circle user_img"
                                alt="">
                        </div>
                        <div class="user_info">
                            <span class="title">${display_name || first_name+last_name || 'No Name'}</span>
                        </div>
                    </div>
                </li>
                `)
            });
        }
        function getChatList()
        {
            var chat_list_loader = $("#chat_list_main .data-loader");
            chat_list_loader.show();
            $("#user_chat_list").empty();
            $.ajax({
                url: "{{url('/admin/get-all-chat-list')}}",
                headers: {
                    'userapisecret':'h0vWu6MkInNlWHJVfIXmHbIbC66cQvlbSUQI09Whbp',
                },
                method:'get',
                success:function(data){
                    chat_list_loader.hide();
                    const chat_list = data?.data;
                    chatListMap(chat_list)
                },
                error:function(error){
                    chat_list_loader.hide();
                }
            });
        }
        function chatListMap(chat_list)
        {
            $("#user_chat_list").empty();
            $.each(chat_list, function (key, obj) {
                const {body,is_seen,friendship_id,friend} = obj;
                const {id,display_name,first_name,last_name} = friend[0]?.user;
                $("#user_chat_list").append(`
                <li class="active dz-chat-user show-chat-btn" data-user_id="${id}" data-friendship_id="${friendship_id}">
                    <div class="d-flex bd-highlight">
                        <div class="img_cont">
                            <img src="{{show_image('${id}','user')}}" class="rounded-circle user_img"
                                alt="">
                        </div>
                        <div class="user_info">
                            <span>${display_name || first_name+last_name || 'No Name'}</span>
                            <p class="description ${is_seen == '0' ? 'primary-text' : ''}">${body.substring(0,20)}</p>
                        </div>
                    </div>
                </li>`)
            });
        }
        function getSingleChat(friendship_id,user_id = 0)
        {
            $(".friendship_id").val(friendship_id)
            $(".send-chat-form .user_id").val(user_id)
            var single_chat_loader = $("#chat_main .data-loader");
            single_chat_loader.show();
            $("#single_chat_messages").empty();
            $.ajax({
                url: "{{url('/admin/get-single-chat')}}",
                headers: {
                    'userapisecret':'h0vWu6MkInNlWHJVfIXmHbIbC66cQvlbSUQI09Whbp',
                },
                data:{friendship_id:friendship_id},
                method:'get',
                success:function(data){
                    single_chat_loader.hide();
                    const friend = data?.data;
                    const user = friend?.user;
                    $(".chat-user-name").text(user?.first_name+' '+user?.last_name);
                    singleChatMap(friend);
                },
                error:function(error){
                    single_chat_loader.hide();
                }
            });
        }
        function singleChatMap(friend)
        {
            $("#single_chat_messages").empty();
            $.each(friend.chats, function (key, obj) {
                if(obj?.user_id == friend?.user_id){
                    $("#single_chat_messages").append(`
                        <div class="d-flex justify-content-start mb-4">
                            <div class="img_cont_msg">
                                <img src="images/avatar/1.jpg" class="rounded-circle user_img_msg" alt="">
                            </div>
                            <div class="msg_cotainer">
                                ${obj?.body}
                                <span class="msg_time">${obj?.created_at}</span>
                            </div>
                        </div>
                    `)
                }
                else{
                    $("#single_chat_messages").append(`
                        <div class="d-flex justify-content-end mb-4">
                            <div class="msg_cotainer_send">
                                ${obj?.body}
                                <span class="msg_time_send">${obj?.created_at}</span>
                            </div>
                            <div class="img_cont_msg">
                                <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="">
                            </div>
                        </div>
                    `)
                }
                
            });
        }
        $(document).on('submit', '.send-chat-form', function (e) {
            e.preventDefault();
            var send_message_btn = $(".send-message-btn");
            send_message_btn.attr('disabled',true);
            send_message_btn.text('Loading...');
            $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        send_message_btn.attr('disabled',false);
                        send_message_btn.text('Send');
                        $(".message-body").val('');
                        const message = data?.data;
                        $("#single_chat_messages").append(`<div class="d-flex justify-content-end mb-4">
                            <div class="msg_cotainer_send">
                                ${message?.body}
                                <span class="msg_time_send">${message?.created_at}</span>
                            </div>
                            <div class="img_cont_msg">
                                <img src="images/avatar/2.jpg" class="rounded-circle user_img_msg" alt="">
                            </div>
                        </div>`)
                    },
                    error:function(error){
                        send_message_btn.attr('disabled',false);
                        send_message_btn.text('Send');
                        $(".message-body").val('');
                        alert(error?.message);
                    }
            });
        });
        
        const login_user = "{{Auth::user()}}";
        const login_user_id = "{{Auth::id()}}";
        window.Echo.channel(
            `chat`
        ).listen( `.chat_list${ login_user_id }`, ( e ) => {
            chatListMap(e);
        } );
        window.Echo.channel(
            `chat`
        ).listen( `.user_list${ login_user_id }`, ( e ) => {
            userListMap(e);
        } );
        window.Echo.channel(
            `chat`
        ).listen( `.chatting${ login_user_id }`, ( e ) => {
            singleChatMap(e);
        } );

    })(jQuery)

</script>
@yield('script')
<!-- End js file -->
</body>
</html>

