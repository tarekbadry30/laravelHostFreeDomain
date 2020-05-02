@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $textalign= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';


@endphp
@section('PageTitle')Aqar - reset password @endsection
@section('content')
    <div class=" login-container">
        <div class="container">
            <div dir="ltr" class="row">
                <div class="offset-3 col-md-6 login-form-2">
                    <div  class="row">

                        <div class="col-8 offset-2">
                            <div class="profile-text">
                                <h2 class="text-center  text-white">{{$name}}</h2>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <h3>{{ __('frontend.resetPass') }} </h3>

                    <form autocomplete="off" dir="{{$dir}}" method="post" class="{{$textalign}}" action="{{route('resetNewPass')}}">
                        @csrf

                        <div class="form-group">
                            <label class="text-black" >{{ __('frontend.email') }}</label>
                            <input required type="email" class="@error('email') is-invalid @enderror form-control" placeholder="{{ __('frontend.email') }} " name="email" value="{{$email}}" />
                            <input required type="hidden" name="username" value="{{$name}}" />
                            <input required type="hidden" name="code" value="{{$code}}" />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="text-black" >{{ __('frontend.new_password') }}</label>

                            <input type="password" class="form-control" placeholder="{{ __('frontend.new_password') }}" name="newPassword" autocomplete="off" value="" />

                        </div>
                        <div class="form-group">
                            <label class="text-black" >{{ __('frontend.confirm_password') }}</label>

                            <input type="password" class="form-control" name="repeatNewPass" placeholder="{{ __('frontend.confirm_password') }}" autocomplete="off" value="" />

                        </div>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit w-50 p-lg-2 m-auto d-block" value="{{ __('frontend.update') }}" />
                        </div>
                        <div class="form-group">

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection





