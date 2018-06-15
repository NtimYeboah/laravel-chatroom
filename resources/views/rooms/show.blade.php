@extends('layouts.app')

@section('content')
<section id="content">
    <section class="hbox stretch">
    <section>
        <section class="vbox">
        <header class="header bg-light lt b-b b-light">
            <a href="{{route('rooms.index')}}" class="btn btn-sm btn-default pull-right btn-rounded">All Rooms</a>
            <p><strong>{{$room->name}}</strong></p>
        </header>
        @if (count($room->messages))
        <section class="w-f scrollable wrapper">              
            <section class="chat-list">
                @foreach($room->messages as $message)
                <article class="chat-item {{ Auth::user()->id === $message->user->id ? 'right': 'left' }} ">
                    <section class="chat-body">
                        <div class="panel b-light text-sm m-b-none">
                        <div class="panel-body">
                            <span class="arrow {{ Auth::user()->id === $message->user->id ? 'right': 'left' }} "></span>
                            @if (Auth()->user()->id !== $message->user->id)
                            <strong><small class="text-muted"><i class="fa fa-ok text-success"></i>{{ $message->user->name}}</small></strong>
                            @endif
                            <p class="m-b-none">{{ $message->body }}</p>
                        </div>
                        </div>
                        <small class="text-muted"><i class="fa fa-ok text-success"></i>{{ $message->created_at }}</small>
                    </section>
                </article>
                @endforeach
                
            </section>                    
        </section>
        @else
        <div class="col-md-12" style="margin-top:2%">
            <section class="panel b-a">
                <div class="panel-heading b-b">
                    <p class="text-center"><a href="#" class="font-bold">No convo yet. Why don't you start it?</a></p>
                </div>
            </section>
        </div>
        @endif

        <footer class="footer bg-light lt b-t b-light" style="padding-top:.5%">
            <form id="msg-form">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control input-sm rounded" id="msg-input" placeholder="Say something">
                <input type="hidden" id="room-id-input" value="{{$room->id}}">
                <input type="hidden" id="auth-user-name-input" value="{{Auth::user()->name}}">
                <span class="input-group-btn">
                    <button class="btn btn-sm btn-danger font-bold btn-rounded" id="send-msg-btn" type="button">Send</button>
                </span>
            </div>
            <small id="whisper-typing" style="font-style:italic"></small>
            </form>
        </footer>
        </section>
    </section>
    <!-- side content -->
    <aside class="aside-md bg-primary dker" id="sidebar">
        <section class="vbox animated fadeInRight">
        <section class="scrollable">
            <h4 class="font-thin text-white padder m-b-none m-t">Chat</h4>
            <div class="wrapper text-u-c"><strong>Online</strong></div>
            <ul class="list-group no-bg no-borders auto m-b-none">
            <li class="list-group-item">
                <div class="media">
                    <div class="media-body" id="online-list-container">
                    </div>
                </div>
            </li>
            </ul>
        </section>
        </section>              
    </aside>
    <!-- / side content -->
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
</section>
@endsection