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
                    <h3 class="text-uppercase">{{ __('frontend.sendToAdmin') }} </h3>
                    <form autocomplete="false" dir="{{$dir}}" method="POST" action="{{ url('/sendMessage/') }}">
                        @csrf
                        <div class="form-group">
                            <input id="name" type="text" onautocomplete="false" placeholder="{{ __('frontend.name') }}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="email" type="email" onautocomplete="false" placeholder="{{ __('frontend.email') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="phone" type="text" placeholder="{{ __('frontend.phone') }}" class="form-control @error('phone') is-invalid @enderror" name="phone" required>

                            @error('phone')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea rows="5" id="message" placeholder="{{ __('frontend.your_message') }}" class="form-control @error('message') is-invalid @enderror" name="message" required></textarea>
                            @error('message')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="submit" class="text-capitalize btnSubmit w-50 p-lg-2 m-auto d-block" value="{{ __('frontend.send') }}" />
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
