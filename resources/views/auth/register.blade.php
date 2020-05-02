@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
@endphp
@section('content')
    <div class=" login-container">
        <div class="container">
            <div dir="ltr" class="row">
                <div class="offset-3 col-md-6 login-form-2">
                    <h3 class="text-uppercase">{{ __('frontend.register') }} </h3>
                    <form dir="{{$dir}}" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                                <input id="name" placeholder="{{ __('frontend.name') }}" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                                <input id="email" placeholder="{{ __('frontend.email') }}" type="email" class="text-capitalize form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                                <input id="phone" placeholder="{{ __('frontend.phone') }}" type="text" class="text-capitalize form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">

                                <input id="password" placeholder="{{ __('frontend.password') }}" type="password" class="text-capitalize form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">

                                <input id="password-confirm" placeholder="{{ __('frontend.confirm_password') }}" type="password" class="text-capitalize form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>


                        <div class="form-group">
                            <input type="submit" class="text-capitalize btnSubmit w-50 p-lg-2 m-auto d-block" value="{{ __('frontend.register') }}" />
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
