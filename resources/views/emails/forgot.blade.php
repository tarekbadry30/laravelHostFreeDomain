<!DOCTYPE html>
<html>
    <head>
        <title>password reset</title>
        <style>
            body {
                min-height: 500px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';

            }
            nav{
                background-color: #007BFF;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                color: #fff;
            }
            a.btn{
                box-sizing: border-box;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                position: relative;
                -webkit-text-size-adjust: none;
                border-radius: 4px;
                color: #fff;
                display: inline-block;
                overflow: hidden;
                text-decoration: none;
                background-color: #2d3748;
                border-bottom: 8px solid #2d3748;
                border-left: 18px solid #2d3748;
                border-right: 18px solid #2d3748;
                border-top: 8px solid #2d3748;

            }
            nav>a{
                box-sizing: border-box;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                position: relative;
                color: #3d4852;
                font-size: 19px;
                font-weight: bold;
                text-decoration: none;
                display: inline-block;
            }
            }
        </style>
    </head>
    <body>
        <nav style="text-align: center">
            <h1><a href="{{url('/')}}">AQAR</a></h1>
        </nav>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <main style="text-align: center">
        <h2>hello {{$user->name}}</h2>
        <p> You are receiving this email because we received a password reset request for your account.',<br>
            'Click the button below to reset your password:</p>
        <a href="{{url('/password/newPassword?email='.$user->email.'&username='.$user->name.'&code='.$code)}}" class="btn">reset password</a>
    </main>
    </body>
</html>

