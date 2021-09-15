@extends('layouts.videochat')

@section('page_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/chat-connect.css') }}">
@endsection
@section('content')
<div class="container mt-5 ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header center-block d-block mx-auto">
                    <h2 class='text-center mt-2 mb-5'>
                        接続するためのURLをクリックしてください
                    </h2>
                    <a class='text-center reservation-url text-5' href="{{  Request::url() . '/' . $reservation_id}}">
                        <p class="mt-2 mb-2">
                            <strong><em>Connect URL:</em></strong> &nbsp; {{ Request::url() . '/' . $reservation_id}}
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
