@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $text_dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@section('notification')
    @if(auth()->user())
        <li class="nav-item text-white" xmlns="http://www.w3.org/1999/html">
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

    <div class="main-news-container">
        <div class="container">
            <div dir="ltr" class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            @php
                                $active='active';
                            @endphp
                            @foreach($posts->allImages as $img)

                            <div class="carousel-item {{$active}}">
                                {{$active=''}}
                                <img src="{{asset($img->img_url)}}" class="img-fluid">
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <div dir="ltr" class="row full-det-post">
                <div class="col-12 full-det-title">
                    <h3 class="text-center text-primary"><i class="fas fa-home"></i> {{$posts->post_name}}</h3>
                </div>
                <div class="p-2 col-lg-8 offset-lg-2 col-12 full-det-more">
                    <p class="">
                        <textarea class="text-right" disabled style="resize: none;width: 100%;min-height: 50px; background-color: transparent;border: none">{{$posts->desc}}</textarea>
                    </p>
                    <div dir="{{$dir}}" class="p-3 row {{$text_dir}} full-det-more-primary" >
                        <h4 class="p-0 col-lg-5 col-12 col-sm-6"><i class="text-primary fas fa-map-marked-alt"></i> {{$posts->address}}  </h4>
                        <strong class="p-0 col-lg-3 col-12 col-sm-6"><i class="text-primary fas fa-dollar-sign"></i> {{$posts->price}}</strong>
                        <strong class="p-0 col-lg-4 col-12 col-sm-6"><i class="text-primary far fa-calendar-check" ></i> {{$posts->created_at}}</strong>
                    </div>
                    <div dir="{{$dir}}" class="p-3 row {{$text_dir}} full-det-more-secondary">
                        <strong class="p-0 col-lg-5 col-12 col-sm-6"><i class="text-primary fas fa-user-check"></i> {{$posts->username}}</strong>
                        <strong class="p-0 col-lg-3 col-12 col-sm-6"><i class="text-primary fas fa-phone-alt"></i> {{$posts->phone}}</strong>
                        <strong class="p-0 col-lg-4 col-12 col-sm-6"><i class="text-primary fas fa-envelope"></i> {{$posts->email}}</strong>
                    </div>
                </div>
            </div>
            @if(auth()->id() == $posts->user_id)
                <hr>
                <div class="text-center row align-items-center">
                    <div class="col-md-5 m-auto btn-group" role="group" aria-label="First group">
                        <br>
                        <a href="{{route('editPost',['post_id'=>$posts->id])}}" type="button" class="btn btn-primary">{{ __('frontend.edit') }}</a>
                        <a href="{{route('disablePost',['post_id'=>$posts->id])}}" type="button" class="btn {{ __('frontend.'.$posts->status.'_class') }} ">{{ __('frontend.'.$posts->status) }}</a>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">{{ __('frontend.delete') }}</button>
                    </div>
                </div>
            @endif

            <hr class="border">


    </div>
    <div class="modal" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">confirm !!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>dou you want to delete <strong>{{$posts->post_name}}</strong> !!!</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('deletePost',['post_id'=>$posts->id])}}" type="button" class="btn btn-danger">confirm</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection





