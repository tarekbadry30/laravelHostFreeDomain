@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
@endphp
@section('firebaseCode')
    <!-- firebase code -->
    <script src="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.js"></script>
    <link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.css" />

    <script src="{{ asset('js/firebase_js_code.js') }}" defer></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-app.js"></script>

    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-auth.js"></script>

    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-database.js"></script>
    <!-- TODO: Add SDKs for Firebase products that you want to use
         https://firebase.google.com/docs/web/setup#available-libraries -->
    <script src="https://www.gstatic.com/firebasejs/7.14.0/firebase-analytics.js"></script>

    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyDtTPM1pomN8qoRKGH2RfFpbHQ-qM5b4zA",
            authDomain: "aqar-273812.firebaseapp.com",
            databaseURL: "https://aqar-273812.firebaseio.com",
            projectId: "aqar-273812",
            storageBucket: "aqar-273812.appspot.com",
            messagingSenderId: "122709647682",
            appId: "1:122709647682:web:19cedca567fae2194e68db",
            measurementId: "G-9EPDS91VRK"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        firebase.analytics();
    </script>
    <script src="{{ asset('js/firebase_js_code.js') }}" defer></script>
    <link href="{{ asset('css/firebase_style.css') }}" rel="stylesheet">
    <!-- firebase code -->

@endsection
@section('content')
    <div id="container">
        <h3>enter your mobile number </h3>
        <div id="loading">we allredy send email activation to your email address or you can use your mobile number...</div>
        <a href="{{route('verification.resend')}}"class="btn btn-primary">resend email</a>
        <div id="loaded" class="hidden">
            <div id="main">
                <div id="user-signed-in" class="hidden">
                    <div id="user-info">
                        <div id="photo-container">
                            <img id="photo">
                        </div>
                        <div id="name"></div>
                        <div id="email"></div>
                        <div id="phone"></div>
                        <div class="clearfix"></div>
                    </div>
                    <p>
                        <button id="sign-out">Sign Out</button>
                        <button id="delete-account">Delete account</button>
                    </p>
                </div>
                <div id="user-signed-out" class="hidden">
                    <h4>we allredy send email activation to your email address or you can use your mobile number...</h4>
                    <div id="firebaseui-spa">
                        <div id="firebaseui-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
