@extends('layouts.app')

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
            <h3 class="text-center">AQAR Last Posts</h3>
            <div class="links">
                <a href="{{ route('addPost') }}">add Post</a>

            </div>

            <div class="row">
                <div class="col-lg-4 col-xs-12 text-center">
                    <div class="box">
                        <i class="fa fa-behance fa-3x" aria-hidden="true"></i>
                        <div class="box-title">
                            <h3>post 1 title</h3>
                        </div>
                        <div class="box-text">
                            <span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
                        </div>
                        <div class="box-btn">
                            <a href="#">Load More</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12  text-center">
                    <div class="box">
                        <i class="fa fa-twitter fa-3x" aria-hidden="true"></i>
                        <div class="box-title">
                            <h3>post 2 title</h3>
                        </div>
                        <div class="box-text">
                            <span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
                        </div>
                        <div class="box-btn">
                            <a href="#">Load More</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 text-center">
                    <div class="box">
                        <i class="fa fa-facebook fa-3x" aria-hidden="true"></i>
                        <div class="box-title">
                            <h3>post 3 title</h3>
                        </div>
                        <div class="box-text">
                            <span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
                        </div>
                        <div class="box-btn">
                            <a href="#">Load More</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 text-center">
                    <div class="box">
                        <i class="fa fa-pinterest-p fa-3x" aria-hidden="true"></i>
                        <div class="box-title">
                            <h3>post 4 title</h3>
                        </div>
                        <div class="box-text">
                            <span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
                        </div>
                        <div class="box-btn">
                            <a href="#">Load More</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 text-center">
                    <div class="box">
                        <i class="fa fa-google-plus fa-3x" aria-hidden="true"></i>
                        <div class="box-title">
                            <h3>post 5 title</h3>
                        </div>
                        <div class="box-text">
                            <span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
                        </div>
                        <div class="box-btn">
                            <a href="#">Load More</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 text-center">
                    <div class="box">
                        <i class="fa fa-github fa-3x" aria-hidden="true"></i>
                        <div class="box-title">
                            <h3>post 5 title</h3>
                        </div>
                        <div class="box-text">
                            <span>Lorem ipsum dolor sit amet, id quo eruditi eloquentiam. Assum decore te sed. Elitr scripta ocurreret qui ad.</span>
                        </div>
                        <div class="box-btn">
                            <a href="#">Load More</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection





