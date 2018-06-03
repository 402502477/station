@extends('layouts.auth')
@section('title','用户注册')
@section('content')
<div class="left">
    <div class="content">
        <div class="header">
            <div class="logo text-center"><img src="{{ asset('ui/img/logo-dark.png') }}" alt="Klorofil Logo"></div>
            <p class="lead">Login to your account</p>
        </div>
        <form class="form-auth-small" action="{{ route('register') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="signin-email" class="control-label sr-only">Name</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="signin-email" value="{{ old('name') }}" placeholder="Name" name="name">
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                @endif
            </div>
            <div class="form-group">
                <label for="signin-email" class="control-label sr-only">Email</label>
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="signin-email" value="{{ old('email') }}" placeholder="Email" name="email">
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                @endif
            </div>
            <div class="form-group">
                <label for="signin-password" class="control-label sr-only">Password</label>
                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="signin-password" value="" placeholder="Password" name="password">
                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                @endif
            </div>
            <div class="form-group">
                <label for="password-confirm" class="control-label sr-only">Password</label>
                <input type="password" class="form-control{{ $errors->has('password-confirm') ? ' is-invalid' : '' }}" id="password-confirm" value="" placeholder="Confirm Passwird" name="password_confirmation">
                @if ($errors->has('password-confirm'))
                    <span class="invalid-feedback">
                            <strong>{{ $errors->first('password-confirm') }}</strong>
                        </span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">REGISTER</button>

        </form>
    </div>
</div>
<div class="right">
    <div class="overlay"></div>
    <div class="content text">
        <h1 class="heading">Free Bootstrap dashboard template</h1>
        <p>by The Develovers</p>
    </div>
</div>
<div class="clearfix"></div>
@endsection
