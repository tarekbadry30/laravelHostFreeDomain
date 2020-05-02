@extends('admin.adminTemplate')
@section('PageTitle')Aqar - my profile @endsection
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $phone_ico= str_replace('_', '-', app()->getLocale()) =='ar' ? '-alt' : '';
    $textalign= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';

@endphp
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
                            <h2 class="text-center">{{$user->name}}</h2>
                        <br>
                        </div>
                        <div class="row">
                            <span class="col-4 p-0"><i class="fas fa-phone{{$phone_ico}}"></i> {{$user->phone}}</span>
                            <span class="col-8 p-0"><i class="fas fa-envelope"></i> {{$user->email}}</span>
                        </div>
                        <br>
                        <div class="text-center row align-items-center">
                            <div class="col-md-5 m-auto btn-group" role="group" aria-label="First group">
                                <br>
                                <a href="{{route('controlUser',['user_id'=>$user->id])}}" type="button" class="btn {{ __('frontend.'.$user->status.'_class') }} ">{{ __('frontend.user_'.$user->status) }}</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">{{ __('frontend.delete') }}</button>
                            </div>
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
                                        <h4 class="card-title text-center"><a href="{{route('admin.postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i> {{$postItem->comments}} </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($DisActiveRentPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('admin.postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i>{{$postItem->comments}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($ActiveSellPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('admin.postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i>{{$postItem->comments}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($DisActiveSellPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('admin.postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i>{{$postItem->comments}}</span>
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
                                        <h4 class="card-title text-center"><a href="{{route('admin.postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i>{{$postItem->comments}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($DisActiveRentPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('admin.postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i>{{$postItem->comments}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-sell" role="tabpanel" aria-labelledby="pills-sel-tab"><h3 class="text-center">{{ __('frontend.sel_posts') }}</h3>
                    <div class="row border">
                        @foreach($ActiveSellPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('admin.postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i>{{$postItem->comments}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @foreach($DisActiveSellPosts as $postItem)
                            <div data-aos="fade-right"   data-aos-duration="500" class="col-sm-6 col-md-4 col-lg-3 mt-4">
                                <div class="card rounded-0">
                                    <img height="270" class="card-img-top" src="{{asset($postItem->mainImage)}}">
                                    <div class="card-block">
                                        <h4 class="card-title text-center"><a href="{{route('admin.postDetails',['post_id'=>$postItem->id])}}">{{$postItem->post_name}}</a></h4>
                                        <div class="card-text">
                                            {{$postItem->desc}}
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="float-right"><i class="far fa-calendar-check"></i> {{$postItem->created_at}}</span>
                                        <span><i class=""></i><i class="far fa-comments"></i>{{$postItem->comments}}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div dir="ltr" class="modal" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">confirm !!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>dou you want to delete<span class="font-weight-bolder"> {{$user->name}} </span> !!!</p>
                </div>
                <div class="modal-footer">
                    <a href="{{route('admin.deleteUser',['user_id'=>$user->id])}}" type="button" class="btn btn-danger">confirm</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection





