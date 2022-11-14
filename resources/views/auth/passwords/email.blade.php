@extends('layouts.auth')
@section('content')
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <div class="login-logo">
        <p>{{\Config::get('app.name')}}</p>
      </div>
    </div>
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
      @endif
      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="input-group mb-3">
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
          </div>
        </div>
      </form>
      <p class="mb-1">
        <a class="btn btn-link" href="{{ route('login') }}">{{ __('Login here?') }}</a>
      </p>
    </div>
  </div>
</div>
@endsection