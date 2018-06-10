@extends('layouts.app')

@section('content')
<section class="hbox stretch">
    <section>
        <section class="vbox">
            <section class="scrollable padder">              
                <section class="row m-b-md">
                    <div class="col-sm-6">
                        <h3 class="m-b-xs text-black">Chat Rooms</h3>
                        <small>Welcome, {{ Auth::user()->name}}</small>
                    </div>
                    <div class="col-sm-6 text-right text-left-xs m-t-md">
                        <div class="btn-group">
                            <a class="btn btn-rounded btn-default b-2x" href="{{ route('rooms.create') }}">Create Room</a>
                        </div>
                    </div>
                    </section>
                        
                    <div class="row">
                        @if (count($rooms))
                        @foreach ($rooms as $room)
                        <div class="col-md-4">
                            <section class="panel b-a">
                                <div class="panel-heading b-b">
                                    <span class="badge pull-right">12</span>
                                    <a href="#" class="font-bold">{{$room->name}}</a>
                                </div>
                                <div class="panel-body">
                                    <p class="text-bg">{{$room->description}}</p>
                                    <a href="#" class="btn btn-default btn-sm btn-rounded m-b-xs pull-right"><i class="fa fa-plus"></i> Join</a>
                                </div>
                                <div class="clearfix panel-footer">
                                    <div class="clear">
                                        <a href="#"><strong>{{$room->owner->name}}</strong></a>
                                        <small class="block text-muted">$room->created_at</small>
                                    </div>
                                </div>
                            </section>
                        </div>
                        @endforeach
                        @else
                        <div class="col-md-12">
                            <section class="panel b-a">
                                <div class="panel-heading b-b">
                                    <p class="text-center"><a href="#" class="font-bold">No room available. Why don't you create one?</a></p>
                                </div>
                            </section>
                        </div>
                        @endif
                    </div>
                </section>
            </section>
        </section>
    </section>
</section>
@endsection
