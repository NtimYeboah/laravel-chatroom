@extends('layouts.app')

@section('content')
    <div class="container aside-xl" style="margin-top:10%">
        <section class="m-b-sm">
            <header class="wrapper text-center">
                <strong>Login to have an awesome convo</strong>
            </header>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="list-group">
                    <div class="list-group-item">
                        <input type="email" placeholder="Email" class="form-control no-border" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="list-group-item">
                        <input type="password" placeholder="Password" class="form-control no-border" name="password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-lg btn-primary btn-block">{{ __('Login') }}</button>

                <p class="text-center" style="margin-top:10%">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                    </label>
                </p>

                <div class="text-center m-t m-b"><a href="{{ route('password.request') }}"><small>{{ __('Forgot Your Password?') }}</small></a></div>
            </form>
        </section>
    </div>
@endsection
