@extends('admin.adminTemplate')

@section('content')
<div class="container">
    <br>
    <h2 class="text-center text-uppercase">Admin dashboard</h2>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card card-inverse card-primary h-100 text-center pt-2">
                <div class="card-block card-title">
                    <a href="{{route('postsDashboard')}}"><h3 class="mb-2"><i class="fas fa-pen"></i></h3>All posts [{{$result['AllpostsCount']}}]</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-inverse card-primary h-100 text-center pt-2">
                <div class="card-block card-title">
                    <a href="{{route('usersDashboard')}}"><h3 class="mb-2"><i class="fas fa-users"></i></h3>All users [{{$result['usersCount']}}]</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
