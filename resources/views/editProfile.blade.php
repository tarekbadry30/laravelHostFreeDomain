@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $textalign= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';


@endphp
@section('PageTitle')Aqar - edit profile @endsection
@section('notification')
    @if(auth()->user())
        <li class="nav-item text-white">
            <div class="dropdown show">

                <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i style="font-size: 1.4em" class="text-white far fa-bell"> {{$notification}}</i>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    @if(count($notificationContent)>0)
                        @foreach($notificationContent as $not_item)
                            <a class="dropdown-item" href="{{route('postDetails',['post_id'=>$not_item->post_id])}}">
                                <strong>{{$not_item->not_title}}</strong>
                                <span style="font-size: .8em" class="text-right">{{$not_item->created_at}}</span>
                            </a>
                        @endforeach
                    @else
                        <a class="dropdown-item" href="#!">
                            <strong>{{ __('frontend.no_notification') }}</strong>
                        </a>
                    @endif
                </div>
            </div>
        </li>

    @endif
@endsection
@section('content')
    <div class=" login-container">
        <div class="container">
            <div dir="ltr" class="row">
                <div class="offset-3 col-md-6 login-form-2">
                    <div  class="row">
                        <div class="col-4 offset-4">
                            <div class="profile-container">
                                <div class="profile-img">
                                    <img src="{{asset('/')}}img/employer.webp" class="img-fluid d-block m-auto">
                                </div>
                            </div>
                        </div>
                        <div class="col-8 offset-2">
                            <div class="profile-text">
                                <h2 class="text-center  text-white">{{Auth::user()->name}}</h2>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <h3>{{ __('frontend.edit_your_data') }} </h3>
                    @error('errors')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                    <form dir="{{$dir}}" method="post" class="{{$textalign}}" action="{{route('updateProfile')}}">
                        @csrf
                        <div class="form-group">
                            <label class="text-black" >{{ __('frontend.name') }}</label>
                            <input type="text" required class="form-control @error('username') is-invalid @enderror " name="username" placeholder="{{ __('frontend.name') }} " value="{{Auth::user()->name}}" />
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="text-black" >{{ __('frontend.email') }}</label>
                            <input required type="text" class="@error('email') is-invalid @enderror form-control" placeholder="{{ __('frontend.email') }} " name="email" value="{{Auth::user()->email}}" />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="text-black" >{{ __('frontend.old_password') }}</label>
                            <input required type="password" class="form-control" placeholder="{{ __('frontend.old_password') }}" name="oldPass" value="" />
                        </div>
                        <div class="form-group">
                            <label class="text-black" >{{ __('frontend.new_password') }}</label>

                            <input type="password" class="form-control" placeholder="{{ __('frontend.new_password') }}" name="newPass" value="" />

                        </div>
                        <div class="form-group">
                            <label class="text-black" >{{ __('frontend.confirm_password') }}</label>

                            <input type="password" class="form-control" name="repeatNewPass" placeholder="{{ __('frontend.confirm_password') }}" value="" />

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





