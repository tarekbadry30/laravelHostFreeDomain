@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $textalign= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@section('content')
    <div class=" login-container">
        <div class="container">
            <div dir="ltr" class="row">
                <div class="offset-2 col-md-8 login-form-2">
                    <h3 class="text-uppercase">{{ __('frontend.resetPass') }} </h3>
                    <form method="POST" action="{{ url('/password/reset') }}">
                        @csrf
                        <div dir="{{$dir}}" class="form-group row">
                            <label for="email" class="col-md-4 col-form-label">{{ __('frontend.email') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection






