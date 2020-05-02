@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $textalign= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';


@endphp
@section('PageTitle')Aqar - error @endsection
@section('content')
    <div class=" login-container">
        <div class="container">
            <div dir="ltr" class="row">
                <div class="offset-3 col-md-6 login-form-2">
                    <h3 class="text-uppercase">
                        404 <br>
                        {{ __('frontend.'.$message) }} </h3>
                </div>
            </div>

        </div>
    </div>

@endsection





