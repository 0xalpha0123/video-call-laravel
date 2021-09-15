@extends('layouts.videochat')

@section('page_css')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/home.css') }}">
@endsection
@section('content')
<div class="container mt-5 ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header center-block d-block mx-auto">
                    <h1 class='text-center mt-2'>IDを入力</h1>
                </div>
                <div class="card-body home-form">
                    <form action="{{route('videochat.create', $reservation['id'])}}" method="get" target='_blank'>
                        <input type="text" id="input-userid" class="form-control form-control-lg id-input my-2" name="userid" placeholder="IDを入力"/>
                        <button type="submit" class="btn bg-gradient-primary waves-effect waves-light mt-2" >送&nbsp;&nbsp;&nbsp;信</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
