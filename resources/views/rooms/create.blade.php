@extends('layouts.app')

@section('content')
<section class="hbox stretch">
    <section>
        <section class="vbox">
            <section class="scrollable padder">              
                <section class="row m-b-md">
                    <div class="col-sm-6">
                        <h3 class="m-b-xs text-black">Create A Room</h3>
                        <small>Welcome, {{ Auth::user()->name}}</small>
                    </div>
                </section>

                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ route('rooms.store') }}">
                        @csrf
                        <div class="list-group">
                            <div class="list-group-item">
                                <input type="text" placeholder="Name" class="form-control no-border" name="name" value="{{ old('name') }}" required autofocus>
                            </div>

                            <div class="list-group-item">
                                <input type="text" placeholder="Description" class="form-control no-border" name="description" value="{{ old('description') }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg btn-primary btn-block">Create Room</button>

                    </form>
                </div>
                    
            </section>
        </section>
    </section>
</section>
@endsection