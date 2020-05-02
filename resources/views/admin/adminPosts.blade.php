@extends('admin.adminTemplate')
@section('PageTitle')Aqar -{{$page_title}} posts @endsection
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $inputBorder= str_replace('_', '-', app()->getLocale()) =='ar' ? 'border-left-0' : 'border-right-0';
    $buttonBorder=  str_replace('_', '-', app()->getLocale()) =='ar' ? 'border-right-0' : 'border-left-0';
@endphp
@section('content')

    <div class="main-form-container ">
        <div class="container">
            <h2 class="text-center text-uppercase text-white"><strong>{{ __('frontend.discover_your_city') }}</strong></h2>
            <br>
            <br>
            <div class="text-center row align-items-center">

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
                    <form method="post" action="{{route('admin.search')}}" class="form-row">
                        @csrf
                        <div class="form-group col-10 p-0">
                            <input type="hidden" name="searchOption" value="'all" id="searchOption">
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
        <div class="container">
            <ul dir="{{$dir}}" class="nav nav-pills row full-menu mb-3 m-auto ml-auto mr-auto" id="pills-tab" role="tablist">
                <li class="col text-center nav-item">
                    <a class="text-uppercase nav-link active" id="pills-rent-tab" data-toggle="pill" href="#pills-rent" role="tab" aria-controls="pills-rent" aria-selected="true">{{ __('frontend.rent_posts') }} [{{count($posts['rent']['active'])+count($posts['rent']['disActive'])}}]</a>
                </li>
                <li class="col text-center nav-item">
                    <a class="text-uppercase nav-link" id="pills-sell-tab" data-toggle="pill" href="#pills-sell" role="tab" aria-controls="pills-rent" aria-selected="false">{{ __('frontend.sel_posts') }} [{{count($posts['sel']['active'])+count($posts['sel']['disActive'])}}]</a>
                </li>
            </ul>

        </div>
        <br>
        <div class="tab-content full-menu-container text-center" id="pills-tabContent">

            <div id="pills-rent" role="tabpanel" aria-labelledby="pills-rent-tab" class="show active tab-pane fade container border">
                <h2 class="text-center text-capitalize"><a href="#">{{ __('frontend.allPosts').' ' .__('frontend.rent')." ".__('frontend.active') }} [{{count($posts['rent']['active'])}}]</a></h2>
                <div class="row ">
                    @foreach($posts['rent']['active'] as $postItem)
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
                                    <span><i class="fas fa-images"></i> {{$postItem->imgCount}} </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <br>
                <h2 class="text-center text-capitalize"><a href="#">{{ __('frontend.allPosts').' ' .__('frontend.rent')." ".__('frontend.disactive') }} [{{count($posts['rent']['disActive'])}}]</a></h2>
                <div class="row ">
                    @foreach($posts['rent']['disActive'] as $postItem)
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
                                    <span><i class="fas fa-images"></i> {{$postItem->imgCount}} </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
            <div id="pills-sell" role="tabpanel" aria-labelledby="pills-sell-tab" class="tab-pane fade container border">
                <h2 class="text-center text-capitalize"><a href="#">{{ __('frontend.allPosts').' ' .__('frontend.sel')." ".__('frontend.active') }} [{{count($posts['sel']['active'])}}]</a></h2>
                <div class="row ">
                    @foreach($posts['sel']['active'] as $postItem)
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
                                    <span><i class="fas fa-images"></i> {{$postItem->imgCount}} </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <br>
                <h2 class="text-center text-capitalize"><a href="#">{{ __('frontend.allPosts').' ' .__('frontend.sel')." ".__('frontend.disactive') }} [{{count($posts['sel']['disActive'])}}]</a></h2>
                <div class="row ">
                    @foreach($posts['sel']['disActive'] as $postItem)
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
                                    <span><i class="fas fa-images"></i> {{$postItem->imgCount}} </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection





