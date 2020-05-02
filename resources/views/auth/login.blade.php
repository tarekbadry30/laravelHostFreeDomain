@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $textalign= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@section('content')
    <div class=" login-container">
        <div class="container">
            <div dir="ltr" class="row">
                <div class="offset-3 col-md-6 login-form-2">
                    <h3 class="text-uppercase">{{ __('frontend.login') }} </h3>
                    <form dir="{{$dir}}" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email" placeholder="{{ __('frontend.username') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" placeholder="{{ __('frontend.password') }}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div dir="{{$dir}}" class="form-group">
                            <div dir="ltr" class="{{$textalign}} form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('frontend.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="text-capitalize btnSubmit w-50 p-lg-2 m-auto d-block" value="{{ __('frontend.login') }}" />
                        </div>
                        <div class="form-group {{$textalign}} m-3">
                            <a class=" ForgetPwd" href="{{ url('/password/reset') }}">
                                {{ __('frontend.forget_pass') }}
                            </a>
                        </div>
                        <div class="form-group position-relative m-3">

                            <hr class="font-weight-bolder border-light" style="height: 10px">
                            <span style="top: -12px;position: absolute!important;left: 38%;background: #eee;color: #007BFF;padding: 5px;border-radius:5px ;" >
                                {{ __('frontend.or_login_with') }}
                            </span>

                        </div>
                        <div class="form-group row">
                                <a href="{{ url('/google/redirect') }}" class="col-md-5 offset-md-1 btn btn-danger"><i class="fab fa-google fa-2x"></i></a>
                                <a href="{{ url('/facebook/redirect') }}" class="col-md-5 offset-md-1 btn btn-primary"> <i class="fab fa-facebook fa-2x"></i> </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
