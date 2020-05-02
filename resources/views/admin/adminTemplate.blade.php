@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'ml-auto' : 'mr-auto';
@endphp
    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$dir}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('PageTitle')</title>


    @yield('firebaseCode')

    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Oswald:wght@500;600&family=Tajawal:wght@800&display=swap" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>


    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/my_slider.css')}}">
    <link rel="stylesheet" href="{{ asset('css/main.css')}}">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg  navbar-dark bg-primary fixed-top">
            <a class="navbar-brand text-uppercase" href="{{ url('/admin/dashboard') }}">{{ __('frontend.aqar') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav {{$margin}}">
                    <li class="nav-item active">
                        <a class="nav-link text-uppercase" href="{{route('usersDashboard')}}">{{ __('frontend.users') }} <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" href="{{route('postsDashboard')}}">{{ __('frontend.all') }} </a>
                    </li>
                    <!--li class="nav-item">
                        <a class="nav-link text-uppercase" href="sel">{{ __('frontend.sel') }} posts</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link text-uppercase" href="{{route('allPostsReport')}}">{{ __('frontend.reports') }}</a>
                    </li>
                @yield('notification')
                <!-- Authentication Links -->

                </ul>

                <form method="post" action="{{route('search')}}" class="form-inline my-2 my-lg-0">
                        @csrf
                    <input required name="filterType" class="form-control rounded-0 border-0 " type="search" placeholder="{{ __('frontend.search') }}" aria-label="Search">
                    <button class="btn bg-primary rounded-0 border-white my-2 m-0 my-sm-0" type="submit">
                        <i class="text-white fas fa-lg fa-search"></i>
                    </button>
                </form>


                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Admin
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <!--<a class="dropdown-item" href="{{route('myPosts')}}">{{ __('frontend.my_profile') }}</a>
                                <a class="dropdown-item" href="{{route('editMyProfile')}}">{{ __('frontend.edit_my_account') }}</a>
                                --><a class="dropdown-item" href="{{ url('/admin/logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                @if(str_replace('_', '-', app()->getLocale()) == 'en')
                    <a class="btn btn-primary"  id="ShawEn" href="{{ url('locale/ar') }}" >عربي</a>
                @else
                    <a class="btn btn-primary" id="ShawAr"  href="{{ url('locale/en') }}" >English</a>

                @endif

            </div>
        </nav>

        <main >
            @yield('content')
        </main>
    </div>



    <div class="modal fade" id="modalNewPost" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: transparent">
                <div class="position-relative">
                    <button type="button" class="btn  bg-danger close p-2 position-absolute" style="top:0;right: 0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div dir="ltr" class="">
                        <div class="login-form-2 rounded-0">
                            <h3 class="text-capitalize">{{ __('frontend.new_post') }} </h3>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            {!! Form::open(['url'=>route('addPost'),'files' => true,'class'=>' text-center arabicFont','dir'=>$dir,'id'=>'AddPostForm','method'=>'POST']) !!}
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="{{ __('frontend.post_title') }}" name="post_name" value="{{old('post_name')}}" />
                            </div>
                            <div class="form-group">
                                <textarea type="text" name="post_desc" placeholder="{{ __('frontend.post_description') }}" class="form-control">{{old('post_desc')}}</textarea>
                            </div>
                            <div class="form-group">
                                <textarea type="text" name="post_address" placeholder="{{ __('frontend.address') }}" class="form-control">{{old('post_address')}}</textarea>
                            </div>
                            <div class="form-group">
                                <select type="text" name="type" class="form-control">
                                    <option disabled selected value="">{{ __('frontend.type') }}</option>
                                    <option value="selling">{{ __('frontend.sel') }}</option>
                                    <option value="rent">{{ __('frontend.rent') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="price" placeholder="{{ __('frontend.price') }}" value="{{old('price')}}"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" name="mobile" placeholder="{{ __('frontend.phone') }}" value="{{old('mobile')}}"  class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="{{ __('frontend.email') }}" value="{{old('email')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                {!! Form::file('img[]',["class"=>"form-control","multiple" , "placeholder"=>"images","id"=>"img_url"]) !!}
                            </div>
                            <div class="form-group py-3">
                                <input type="submit" value="{{ __('frontend.add') }}" class="but btn-primary form-control">
                            </div>

                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>


    <footer class="page-footer font-small stylish-color-dark pt-4">

        <!-- Footer Links -->
        <div class="container text-center text-md-left">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12 mx-auto">

                    <!-- Content -->
                    <h3 class="text-center font-weight-bold text-uppercase mt-3 mb-4">{{ __('frontend.aqar') }}</h3>
                    <h4  class="text-center font-weight-bold "> {{ __('frontend.aqarDesc') }}</h4>

                </div>
                <hr class="clearfix w-100 d-md-none">

            </div>
            <!-- Grid row -->

        </div>
        <!-- Footer Links -->

        <hr>

        <!-- Copyright -->
        <div class="col-12 footer-copyright text-center ">© 2020 Copyright:
            <a href="#">  leen.com</a>
        </div>
        <!-- Copyright -->

    </footer>

    <!-- Scripts -->
    <script type="text/javascript">
        $(".input").focus(function() {
            $(this).parent().addClass("focus");
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>
    <script src="{{ asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('js/new_slider.js')}}"></script>
    <script src="https://kit.fontawesome.com/8aaad534d4.js" crossorigin="anonymous"></script>

</body>
</html>
