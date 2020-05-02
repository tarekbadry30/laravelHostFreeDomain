@extends('layouts.app')
@section('PageTitle')Aqar - my profile @endsection
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $textalign= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';

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
    <div class="main-news-container">
        <div class="container">
            <div dir="ltr" class="row">
                <div class="col-4 offset-4">
                    <div class="profile-container">
                        <div class="profile-img">
                            <img src="{{asset('/')}}img/employer.webp" class="img-fluid d-block m-auto">
                        </div>
                        <br>
                        <br>
                        <br>
                        <div class="profile-text">
                            <h2 class="text-center">{{Auth::user()->name}}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <ul dir="{{$dir}}" class="nav nav-pills row full-menu mb-3 m-auto ml-auto mr-auto" id="pills-tab" role="tablist">
                <li class="col text-center nav-item">
                    <a class="text-uppercase nav-link active" id="all-tab" data-toggle="pill" href="#all" role="tab" aria-controls="all" aria-selected="true">{{ __('frontend.all_posts') }}
                        [{{count($ActiveRentPosts)+count($DisActiveRentPosts)+count($ActiveSellPosts)+count($DisActiveSellPosts)}}]</a>
                </li>
                <li class="col text-center nav-item">
                    <a class="text-uppercase nav-link" id="pills-rent-tab" data-toggle="pill" href="#pills-rent" role="tab" aria-controls="pills-rent" aria-selected="false">{{ __('frontend.rent_posts') }} [{{count($ActiveRentPosts)+count($DisActiveRentPosts)}}]</a>
                </li>
                <li class="col text-center nav-item">
                    <a class="text-uppercase nav-link" id="pills-sell-tab" data-toggle="pill" href="#pills-sell" role="tab" aria-controls="pills-rent" aria-selected="false">{{ __('frontend.sel_posts') }} [{{count($ActiveSellPosts)+count($DisActiveSellPosts)}}]</a>
                </li>
            </ul>
            <hr>
            <div class="tab-content full-menu-container text-center" id="pills-tabContent">
                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab"><h3 class="text-center">{{ __('frontend.all_posts') }}</h3>
                    <div class="row border">
                        @foreach($ActiveRentPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i> 75 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($DisActiveRentPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i> 75 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($ActiveSellPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i> 75 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($DisActiveSellPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i> 75 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-rent" role="tabpanel" aria-labelledby="pills-rent-tab"><h3 class="text-center">{{ __('frontend.rent_posts') }}</h3>
                    <div class="row border">
                        @foreach($ActiveRentPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i> 75 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($DisActiveRentPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i> 75 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-sell" role="tabpanel" aria-labelledby="pills-rent-tab"><h3 class="text-center">{{ __('frontend.sel_posts') }}</h3>
                    <div class="row border">
                        @foreach($ActiveSellPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i> 75 </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($DisActiveSellPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i> 75 </span>
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





