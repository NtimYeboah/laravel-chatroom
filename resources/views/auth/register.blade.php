@extends('layouts.app')

@section('content')
<div class="container aside-xl" style="margin-top:10%">
        <section class="m-b-sm">
            <header class="wrapper text-center">
                <strong>Signup! It's awesome here</strong>
            </header>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="list-group">
                    <div class="list-group-item">
                        <input id="name" type="text" placeholder="Full name" class="form-control no-border" name="name" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="list-group-item">
                        <input id="email" type="email" placeholder="Email" class="form-control no-border" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="list-group-item">
                        <input id="password" type="password" placeholder="Password" class="form-control no-border" name="password" required>
                    </div>

                    <div class="list-group-item">
                        <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control no-border" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-lg btn-primary btn-block">{{ __('Register') }}</button>
            </form>
        </section>
    </div>
@endsection
