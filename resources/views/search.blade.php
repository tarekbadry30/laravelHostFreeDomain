@extends('layouts.app')
@section('PageTitle')Aqar -{{$page_title}} posts @endsection
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $inputBorder= str_replace('_', '-', app()->getLocale()) =='ar' ? 'border-left-0' : 'border-right-0';
    $buttonBorder=  str_replace('_', '-', app()->getLocale()) =='ar' ? 'border-right-0' : 'border-left-0';
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

    <div class="main-form-container ">
        <div class="container">
            <h2 class="text-center text-uppercase text-white"><strong>{{ __('frontend.discover_your_city') }}</strong></h2>
            <br>
            <br><div class="text-center row align-items-center">

                <div class="col-md-5 m-auto btn-group" role="group" aria-label="First group">
                    <br>
                    <button type="button" class="text-uppercase serch-filtering btn btn-secondary" filter-type="rent">{{ __('frontend.rent') }}</button>
                    <button type="button" class="text-uppercase serch-filtering btn btn-secondary" filter-type="selling">{{ __('frontend.sel') }}</button>
                    <button type="button" class="text-uppercase serch-filtering btn btn-secondary" filter-type="">{{ __('frontend.all_news') }}</button>
                    <script>
                        $('button.serch-filtering').click(function () {
                            $("#searchOption").val($(this).attr('filter-type'));
                        });
                    </script>
                </div>
            </div>
            <div class="text-center row align-items-center">

                <div class="col-md-5 m-auto">
                    <form method="post" action="{{route('search')}}" class="form-row">
                        @csrf
                        <div class="form-group col-10 p-0">
                            <input type="hidden" name="searchOption" value="" id="searchOption">
                            <input type="text" placeholder="{{ __('frontend.search') }}" name="filterType" class="form-control rounded-0 {{$inputBorder}} form-control-lg">
                        </div>
                        <div class="form-group col-2 p-0">
                            <button type="submit" class="form-control bg-primary rounded-0 {{$buttonBorder}} form-control-lg p-0">
                                <i class="fas fa-lg fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="main-news-container">
        <div class="container-fluid">
            <h2 class="text-center text-capitalize">{{$seachText}}</h2>

        </div>
        <div class="container">
            <div class="row border">
                @foreach($posts as $postItem)
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
@endsection





