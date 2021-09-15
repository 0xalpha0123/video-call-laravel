@extends('layouts.videochat')

@section('page_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/chat-home.css') }}">
@endsection
@section('content')
<div class="container mt-5 ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header center-block d-block mx-auto">
                    {{$status}}
                @if ($status === 'create')
                    <h1 class='text-center mt-2'>IDを入力</h1>
                @else
                    <h2 class='text-center mt-2 mb-5'>
                        接続するためのURLをクリックしてください
                    </h2>
                @endif
                </div>
                <div class="card-body home-form">
                @if ($status === 'create')
                    <form action="{{route('home.generate')}}" method="post">
                        @csrf
                        <input type="text" id="input-userid" class="form-control form-control-lg id-input my-2" name="userid" placeholder="IDを入力"/>
                        <button type="submit" class="btn bg-gradient-primary waves-effect waves-light mt-2" >送&nbsp;&nbsp;&nbsp;信</button>
                    </form>
                @else
                    <a class='text-center reservation-url text-5' href="{{  Request::root() . '/' . $reservation_id}}">
                        <p class="mt-2 mb-2">
                            <strong><em>Connect URL:</em></strong> &nbsp; {{ Request::root() . '/' . $reservation_id}}
                        </p>
                    </a>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
