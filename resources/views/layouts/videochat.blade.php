<!DOCTYPE html>
<html class="loading" lang="ja" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Language" content="ja">
    <meta name="google" content="notranslate">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>VideoChatting</title>

    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" >

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-chat.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('component/overlay-spinner/overlay-spinner.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('component/side-menu/side-menu.css') }}">

    @yield('page_css')
    <!-- END: Page CSS-->

</head>
<!-- END: Head-->

<div class="modal fade overlay-spinner" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 0px">
            <span class="loader"></span>
        </div>
    </div>
</div>
<body class="vertical-layout vertical-menu-modern dark-layout content-left-sidebar chat-application navbar-floating footer-static  " style="overflow-x:hidden;overflow-y:hidden;" data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar" data-layout="dark-layout">
    <div class="app-content" >
    @yield('content')
    </div>

    <div class="sidenav-overlay"></div>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @yield('page_vendor_js')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/components.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>

    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/app-chat.js?1') }}"></script>
    <script src="{{ asset('component/sweet-alert/sweet-alert.js') }}"></script>
    <script src="{{ asset('component/overlay-spinner/overlay-spinner.js') }}"></script>
    <script src="{{ asset('component/side-menu/side-menu.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    </script>

    @yield('page_js')
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
