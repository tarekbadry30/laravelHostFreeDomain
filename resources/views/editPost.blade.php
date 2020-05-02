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

    <div class=" login-container">
        <div class="container">
            <div dir="ltr" class="row ">
                <div class="offset-3 col-md-6 login-form-2">
                    <h3 class="text-uppercase">{{ __('frontend.edit_post') }} </h3>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {!! Form::open(['url'=>route('updatePost'),'files' => true,'dir'=>$dir,'class'=>' text-center arabicFont','id'=>'AddPostForm','method'=>'POST']) !!}
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="{{ __('frontend.post_title') }}" name="post_name" value="{{$posts->post_name}}" />
                        <input placeholder="title" type="hidden" name="id" value="{{$posts->id}}" class="input">

                    </div>
                    <div class="form-group">
                        <textarea type="text" name="post_desc" placeholder="{{ __('frontend.post_description') }}" class="form-control">{{$posts->desc}}</textarea>
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="post_address" placeholder="{{ __('frontend.address') }}" class="form-control">{{$posts->address}}</textarea>
                    </div>
                    <div class="form-group">
                        <select type="text" name="type" class="form-control">
                            <option disabled selected value="{{$posts->type}}">{{__('frontend.'.$posts->type)}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" name="price" placeholder="{{ __('frontend.price') }}" value="{{$posts->price}}"  class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="text" name="mobile" placeholder="{{ __('frontend.phone') }}" value="{{$posts->phone}}"  class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="{{ __('frontend.email') }}" value="{{$posts->email}}" class="form-control">
                    </div>
                    <div class="form-group">
                        {!! Form::file('img[]',["class"=>"form-control","multiple" , "placeholder"=>"images","id"=>"img_url"]) !!}
                    </div>
                    <div class="form-group py-3">
                        <input type="submit" value="{{ __('frontend.update') }}" class="but btn-primary form-control">
                    </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection





