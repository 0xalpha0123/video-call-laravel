@extends('layouts.videochat')
@section('page_css')

<style>

.active{
    display:block!important;
}

@media (max-width: 991px) {
    .remote-stream {
        background-color: #111111; 
        position: absolute; 
        width:100%;
        top:69px;
        height:100vh;
    }
    .sp-hide{
        display:none!important;
    }
    .local-stream {
        background-color: #333333; 
        position: absolute;
        z-index: 9; 
        width:30%; 
        min-height:120px;
    }
}

@media (min-width: 992px) {
    .remote-stream {
        background-color: #111111; 
        position: absolute; 
        width:100%;
        height:100%
    }
    .local-stream {
        background-color: #333333; 
        position: absolute;
        z-index: 9; 
        width:25%; 
        width:250px;
    }
}

</style>

@endsection

<?php
    $remote_name = $type=='create'?'Client-B':'Client-A';
    $local_avatar = '';
    $remote_avatar = '';

    if (empty($local_avatar))
        $local_avatar = asset('images/default-avatar.png');
    if (empty($remote_avatar))
        $remote_avatar = asset('images/default-avatar.png');

?>

@section('content')
<div class='page-wrapper chiller-theme'>
    <nav class='sidebar-wrapper sp-show'>
        <div class="sidebar-content-c">
            <div class="sidebar-brand">
                <a>切換</a>
                <div id="close-sidebar">
                <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>メニュー</span>
                    </li>
                    <li>
                        <a class="sidebar-menu-selected" href="#" id="switch-to-video">
                            <i class="fa fa-video"></i>
                            <span>ビデオ</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" id="switch-to-chatting">
                            <i class="fa fa-book"></i>
                            <span>チャット</span>
                        </a>
                    </li>
                </ul>
            </div>  
        </div>
    </nav>
    <div class="row">
        <div class="col-lg-9  ml-0 mr-0 pl-0 pr-0">
            <div class="d-flex align-items-end flex-column">
                <video id="js-local-stream" class="local-stream"></video>
            </div>
            <div>
                <video id="js-remote-stream" class="remote-stream"></video>
            </div>
        </div>
        <div class="col-lg-3 ml-0 mr-0 pl-0 pr-0 ">
            <div class="content-area-wrapper">
                <div class="content-detached">
                    <div class="content-wrapper">
                        <div class="content-body">
                            <section class="chat-app-window">
                                <div class="start-chat-area d-none">
                                    <span class="mb-1 start-chat-icon feather icon-message-square"></span>
                                    <h4 class="py-50 px-1 sidebar-toggle start-chat-text">Start Conversation</h4>
                                </div>
                                <div class="active-chat">
                                    <div class="chat_navbar">
                                        <header class="chat_header d-flex justify-content-between align-items-center p-1">
                                            <div class="vs-con-items d-flex align-items-center">
                                                <div class="sidebar-toggle d-block d-lg-none mr-1" style='z-index:99;' id="show-sidebar"><a href='#'><i class="feather icon-menu font-large-1"></i></a></div>
                                                <div class="avatar user-profile-toggle m-0 m-0 mr-1">
                                                    <img src="{{$remote_avatar}}" alt="" height="40" width="40" />
                                                    <span class="avatar-status-busy"></span>
                                                </div>
                                                <h6 class="mb-0">{{$remote_name}} (<span id="span_left_time">00:00</span>)</h6>
                                            </div>
                                        </header>
                                    </div>
                                    <div class="user-chats sp-hide">
                                        <div class="chats">
                                        </div>
                                    </div>
                                    <div class="chat-app-form sp-hide">
                                        <form class="chat-app-input d-flex " onsubmit="" action="javascript:void(0);">
                                            <input type="text" class="form-control message ml-1 " id="iconLeft4-1" placeholder="Type your message">
                                            <button type="button" id="btn_send" class="btn btn-primary send ml-1 mr-1" disabled ><i class="fas fa-paper-plane"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
<script src="https://cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
<script>
const Peer = window.Peer;
var g_connectoin_status = false;
var g_is_first = true;
var g_data_connectoin = null;
var g_chart_history = new cookieList("chart-history-{{$reservation_id}}");
var g_handle_time;
var g_expired_duration = eval("{{VIDEOCHAT_EXPIRED_DURATION}}");


function getLastChatStatus()
{
    if ($(".chat").length == 0) {
        return 0;
    } else {
        if ($(".chat:last-child").hasClass('chat-left')) {
            return -1;
        }
        else {
            return 1;
        }
    }
}

function addChatByMe(message, avatar_url, is_saving = true) {
    if (message == "")
        return;

    if (is_saving)
        g_chart_history.add(message, "1");

    var last_status = getLastChatStatus();

    if (last_status == 0 || last_status == -1) {
        var html = '<div class="chat"><div class="chat-avatar"><a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title=""><img src="' + avatar_url + '" alt="avatar" height="40" width="40" /></a></div><div class="chat-body"><div class="chat-content"><p>' + message + '</p></div></div></div>';
        $(".chats").append(html);
    } else {
        var html = '<div class="chat-content">' + "<p>" + message + "</p>" + "</div>";
        $(".chat:last-child .chat-body").append(html);
    }

    $(".message").val("");
    $(".user-chats").scrollTop($(".user-chats > .chats").height());
}

function addChatByPartner(message, avatar_url, is_saving = true) {
    if (message == "")
        return;

    if (is_saving)
        g_chart_history.add(message, "-1");

    var last_status = getLastChatStatus();

    if (last_status == 0 || last_status == 1) {
        var html = '<div class="chat chat-left""><div class="chat-avatar"><a class="avatar m-0" data-toggle="tooltip" href="#" data-placement="left" title="" data-original-title=""><img src="' + avatar_url + '" alt="avatar" height="40" width="40" /></a></div><div class="chat-body"><div class="chat-content"><p>' + message + '</p></div></div></div>';
        $(".chats").append(html);
    } else {
        var html = '<div class="chat-content">' + "<p>" + message + "</p>" + "</div>";
        $(".chat:last-child .chat-body").append(html);
    }

    $(".user-chats").scrollTop($(".user-chats > .chats").height());
}

function loadChatHistory() {
    var count = g_chart_history.items().length;

    for (var index = 0; index < count; index++) {
        if (g_chart_history.at(index)[0] == 1)
            addChatByMe(g_chart_history.at(index)[1], "{{$local_avatar}}", false);
        else
            addChatByPartner(g_chart_history.at(index)[1], "{{$remote_avatar}}", false);
    }
}

function cookieList(cookieName) {
    var cookie = $.cookie(cookieName);
    var items = cookie ? cookie.split('$,$') : new Array();
    return {
        "add": function(val, type) {
            items.push(type + '$:$' + val);
            $.cookie(cookieName, items.join('$,$'));
        },
        "remove": function (indx) {
            if(indx!=-1) items.splice(indx, 1);
            $.cookie(cookieName, items.join('$,$'));
        },
        "clear": function() {
            items = null;
            $.cookie(cookieName, null);
        },
        "items": function() {
            return items;
        },
        "at": function(index) {
            return items[index].split('$:$');
        }
    }
}

function changeConnectionStatus(flag, data_connection) {
    g_connectoin_status = flag;
    g_data_connectoin = data_connection

    if (g_connectoin_status == true) {
        $("#btn_send").attr("disabled", false);
    } else {
        $('#btn_send').attr("disabled", true);
    }
    if (g_chart_history.items().length == 0 && g_connectoin_status) {
        addChatByPartner("{{$remote_name}} さんがチャットルームに入場しました。", "{{$remote_avatar}}");
    }

}

function timeCountFunc() {
    var additionalTime = {{ ADDITIONAL_TIME }};
    if (g_expired_duration <= (-1 * additionalTime)) {
        clearTimeout(g_handle_time);

        var remote_video = document.getElementById('js-remote-stream');
        if (remote_video.srcObject != null) {
            remote_video.srcObject.getTracks().forEach(track => track.stop());
            remote_video.srcObject = null;
        }

        var local_video = document.getElementById('js-local-stream');
        if (local_video.srcObject != null) {
            local_video.srcObject.getTracks().forEach(track => track.stop());
            local_video.srcObject = null;
        }

        g_data_connectoin = null;

        addChatByPartner("問診時間が完了しました。", "{{$remote_avatar}}");

        return;
    }

    g_expired_duration--;

    var seconds = g_expired_duration % 60;
    var minutes = (g_expired_duration - seconds) / 60;

    if (g_expired_duration <= 0) {
        $("#span_left_time").html('00:00');
    } else {
        $("#span_left_time").html(minutes.toString().padStart(2,"0") + ":" + seconds.toString().padStart(2,"0"));
    }
}

function authStart() {
    $.ajax({
        url: "{{ route('ajax.videochat.authentication') }}",
        type: 'POST',
        data: {
            reservation_id:"{{$reservation_id}}",
            type:"{{$type}}",
        },
        dataType: 'JSON',
        beforeSend: function() {
            showOverlaySpinner();
        },
        success: function (response) {
            hideOverlaySpinner();
            if (response.error_code == 0) {
                main(response.auth_info);
            } else {
                basicAlert("認証に失敗しました。");
            }
        },
        error: function(err){
            hideOverlaySpinner();
        },
        complete: function(){
            hideOverlaySpinner();
        }
    });
    return null;
}

async function main(auth_info) {
    const local_video = document.getElementById('js-local-stream');
    const remote_video = document.getElementById('js-remote-stream');

    var check_local_camera = true;

    const local_stream = await navigator.mediaDevices
    .getUserMedia({
        audio: true,
        video: true,
    })
    .catch((error)=>{
        basicAlert('カメラに接続できません。カメラ接続確認後ページをリフレッシュしてください。');
        check_local_camera = false;
    });

    if (!check_local_camera)
        return false;

    local_video.muted = true;
    local_video.srcObject = local_stream;
    local_video.playsInline = true;
    await local_video.play().catch(console.error);

    const skyway_peer = (window.peer = new Peer(auth_info.peerId, {
        key: '{{config("app.skyway_app_key")}}',
        credential: auth_info ,
        debug: 3,
    }));

    skyway_peer.once('open', id => {
    });

    skyway_peer.on('open', id => {
        const media_connection = skyway_peer.call(auth_info.remotePeerId, local_stream);

        media_connection.on('stream', async stream => {
            if (remote_video.srcObject != null && remote_video.srcObject.getTracks() != null) {
                remote_video.srcObject.getTracks().forEach(track => track.stop());
                remote_video.srcObject = null;
            }

            remote_video.srcObject = stream;
            remote_video.playsInline = true;
            await remote_video.play().catch(console.error);
        });

        media_connection.once('close', () => {
        });

        const data_connection = peer.connect(auth_info.remotePeerId);

        data_connection.once('open', async () => {
            console.log("data_connection-open(A)");
            changeConnectionStatus(true, data_connection);
        });

        data_connection.on('data', data => {
            addChatByPartner(data, "{{$remote_avatar}}");
            console.log("data_connection-data(A):" + data);
        });

        data_connection.once('close', () => {
            console.log("data_connection-close(A)");
        });
    });

//----video----
    skyway_peer.on('call', media_connection  => {
        media_connection.answer(local_stream);

        media_connection.on('stream', async stream => {
            if (remote_video.srcObject != null && remote_video.srcObject.getTracks() != null) {
                remote_video.srcObject.getTracks().forEach(track => track.stop());
                remote_video.srcObject = null;
            }

            remote_video.srcObject = stream;
            remote_video.playsInline = true;

            await remote_video.play().catch(console.error);
        });

        media_connection.once('close', () => {
            console.log("call-close");
        });
    })

//----message----
    skyway_peer.on('connection', data_connection => {
        data_connection.once('open', async () => {
            console.log("data_connection-open(B)");
            changeConnectionStatus(true, data_connection);
        });

        data_connection.on('data', data => {
            addChatByPartner(data, "{{$remote_avatar}}");
            console.log("data_connection-data(B):" + data);
        });

        data_connection.once('close', () => {
            console.log("data_connection-close(B)");
        });
    });

    skyway_peer.on('close', () => {
        console.log('close');
    });

    skyway_peer.on('disconnected', id => {
        console.log('disconnected');
    });

    skyway_peer.on('expiresin', sec => {
        console.log('expiresin');
    });

    skyway_peer.on('error', error => {
        if (error.type != "peer-unavailable") {
            console.log('error: type=' + error.type + ", message=" + error.message);
            setTimeout(authStart, 10000);
        }
    });
}

function sendMessage() {
    if ($(".message").val() == "")
        return false;

    if (g_connectoin_status) {
        g_data_connectoin.send($(".message").val());
        addChatByMe($(".message").val(), "{{$local_avatar}}");
    }
    else
        basicAlert("{{$type=='create'?'Client-Aがまだ接続されていません。':'Client-Bがまだ接続されていません。'}}");
}

if (g_expired_duration > 0) {
    authStart();
    g_handle_time = setInterval(timeCountFunc, 1000);
    addChatByPartner("接続待機中です...", "{{$remote_avatar}}", false);

} else {
    basicAlert("予約時間ではありません。");
}

loadChatHistory();

$("#btn_send").on("click", function(e){
    sendMessage();
});

$(".chat-app-input").on("submit", function(e){
    sendMessage();
});

$(document).bind("contextmenu",function(e){
  return false;
});

</script>
@endsection

