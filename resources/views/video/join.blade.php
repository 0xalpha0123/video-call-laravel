@extends('layouts.videochat')

@section('content')
<div class="container mt-5 ">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header center-block d-block mx-auto">
                    <h1 class='text-center'>One-To-One<br>DEMO</h1>
                </div>
                <div class="card-body">
                    <div class="row col-12 mt-2">
                        <div class="col-6">
                            <img class="img-responsive center-block d-block mx-auto" src="http://api.qrserver.com/v1/create-qr-code/?data={{urlencode(route('videochat.create', $reservation['id']))}}!&size=200x200" />
                        </div>
                        <div class="col-6">
                            <img class="img-responsive center-block d-block mx-auto" src="http://api.qrserver.com/v1/create-qr-code/?data={{urlencode(route('videochat.join', $reservation['id']))}}!&size=200x200" />
                        </div>
                    </div>
                    <div class="row col-12 mt-2">
                        <div class="col-6 d-flex justify-content-center">
                            <form action="{{route('videochat.create', $reservation['id'])}}" method="get" target='_blank'>
                                <button type="submit" class="btn bg-gradient-primary mr-1 mb-1 waves-effect waves-light" >Create Room</button>
                            </form>
                        </div>
                        <div class="col-6 d-flex justify-content-center">
                            <form action="{{route('videochat.join', $reservation['id'])}}" method="get" target='_blank'>
                                <button type="submit" class="btn bg-gradient-primary mr-1 mb-1 waves-effect waves-light" >Join Room</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
