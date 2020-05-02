@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
@endphp
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


    <div class="social-box">
        <div class="container">
            <h3 class="text-center">AQAR {{$page_title}}</h3>
            <div class="links text-center">
                <a class="btn btn-primary" href="{{ route('notifications',['filterType'=>'notRead']) }}">new notifications</a>
                <a class="btn btn-primary" href="{{ route('notifications') }}">All notifications</a>
            </div>
            <div class="text-center">
                <strong >{{count($Allnotifications)}}</strong>
            </div>

            <div class="row">
                @foreach($Allnotifications as $not_item)
                    <div class="alert alert-primary col-xs-12 text-center">
                        <div class="box">
                            <i class="fa fa-behance fa-3x" aria-hidden="true"></i>

                            <div class="box-title">
                                <a href="{{route('postDetails',['post_id'=>$not_item->post_id])}}"> <h3>{{$not_item->not_title}}</h3></a>
                                <span class="text-right">{{$not_item->created_at}}</span>
                            </div>
                        </div>
                    </div>

                @endforeach


            </div>
        </div>
    </div>
@endsection





