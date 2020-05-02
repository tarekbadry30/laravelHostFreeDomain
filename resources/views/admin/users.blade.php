@extends('admin.adminTemplate')
@section('PageTitle')Aqar - my profile @endsection
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $textalign= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';

@endphp
@section('content')
    <div class="main-news-container">
        <div class="container">
            <div dir="ltr" class="row">
                <div class="col-4 offset-4">
                    <div class="profile-container">
                        <br>
                        <div class="profile-text">
                            <h2 class="text-center">users</h2>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <ul dir="{{$dir}}" class="nav nav-pills row full-menu mb-3 m-auto ml-auto mr-auto" id="pills-tab" role="tablist">
                <li class="col text-center nav-item">
                    <a class="text-uppercase border nav-link active" id="pills-active-users-tab" data-toggle="pill" href="#pills-active-users" role="tab" aria-controls="pills-active-users" aria-selected="false">
                        {{ __('frontend.active_users') }} [{{count($activeUsers)}}]
                    </a>
                </li>
                <li class="col text-center nav-item">
                    <a class="text-uppercase border nav-link" id="pills-blocked-users-tab" data-toggle="pill" href="#pills-blocked-users" role="tab" aria-controls="pills-active-users" aria-selected="false">
                        {{ __('frontend.disActive_users') }} [{{count($disActiveUsers)}}]
                    </a>
                </li>
            </ul>
            <hr>
            <div class="tab-content full-menu-container text-center" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-active-users" role="tabpanel" aria-labelledby="pills-active-users-tab">
                    <h3 class="text-center">{{ __('frontend.active_users') }}</h3>
                    <div class="row border">
                        @foreach($activeUsers as $userItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset('/')}}img/employer.webp">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('userProfile',['user_id'=>$userItem->id])}}">{{$userItem->name}}</a></h4>
                                        <div class="card-text">
                                            posts[{{$userItem->postsCount}}]

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$userItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i>{{$userItem->commentsCount}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="tab-pane fade" id="pills-blocked-users" role="tabpanel" aria-labelledby="pills-active-users-tab">
                    <h3 class="text-center">{{ __('frontend.disActive_users') }}</h3>
                    <div class="row border">
                        @foreach($disActiveUsers as $userItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset('/')}}img/employer.webp">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('userProfile',['user_id'=>$userItem->id])}}">{{$userItem->name}}</a></h4>
                                        <div class="card-text">
                                            posts[{{$userItem->postsCount}}]

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$userItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i>{{$userItem->commentsCount}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection





