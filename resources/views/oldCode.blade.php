<!-- comments -->
<hr class="border">
@if($posts->allComments !='')
    <div class="container" style="max-height: 400px; overflow-y: auto">
        @foreach($posts->allComments as $comment)
            <div dir="ltr" class="row py-1" >
                <div class="col-3"></div>
                <div class=" col-6 comments-container" style="border-radius:5px;width: 80%; margin: 2px auto 0 auto ; background-color:rgba(132,144,148,0.52)">
                    <div dir="ltr" class="row">
                        <div class="col-4 main-img-container text-center"><img class="d-block m-auto img-fluid" src="{{asset('img/employer.webp')}}">{{$comment->user}}</div>
                        <div class="col-8 position-relative p-0">
                            <textarea class="main-comment col-12" disabled>{{$comment->com_content}}</textarea>
                            @if($comment->user_id==Auth::id())
                                <div class="dropdown position-absolute" style="right: 0;top: 0;">
                                    <button type="button" style="background-color: transparent;" class="border-0" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu text-center">
                                        <a class="text-danger" href="{{route('deleteComment',['comment_id'=>$comment->id])}}" >Delete</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if($comment->replies!='')
                            @foreach($comment->replies as $reply)
                                <div class="col-10 offset-2">
                                    <div style="max-height: 150px; overflow-y: auto" class="row">
                                        <div class="text-center offset-1 col-4 sub-img-container"><img class="d-block m-auto img-fluid" src="{{asset('img/employer.webp')}}">{{$reply->user}} </div>
                                        <div class="col-7">
                                            <textarea class="sub-comment col-11" disabled>{{$reply->com_content}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @if(($posts->user_id==Auth::id() && $posts->status=='active') || ($comment->user_id==Auth::id() && $posts->status=='active') )
                            <div class="insert-reply col-10 offset-2">
                                <div class="formBox">
                                    {!! Form::open(['url'=>route('replyComment',$comment->id),'class'=>'form-row text-center arabicFont','dir'=>$dir,'id'=>'replyCommentForm','method'=>'POST']) !!}
                                    <div class="offset-2 col-8">
                                        <input type="hidden" value="{{$comment->id}}" name="comment_id">
                                        <textarea type="text" name="comment" class="col-12" placeholder="reply"></textarea>
                                    </div>
                                    <div class="col-2">
                                        <input type="submit" name="" class="btn btn-success" value="reply">
                                    </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-3">
                </div>
            </div>
        @endforeach
    </div>
@endif
@if($posts->status=='active' && \Auth::check())
    <div dir="{{$dir}}" class="row py-3" style="width: 80%; margin: auto">
        <div class="col-3">
        </div>
        <div class=" col-6 position-relative p-0 insert-comment">
            <form class="text-center form-row" id="AddCommentForm" method="post" action="{{route('addComment',$posts->id)}}">
                @csrf
                <div class="offset-2 col-8">
                    <div class="input-group">
                        <input type="hidden" value="{{$posts->id}}" name="post_id">
                        <textarea name="comment" class="main-comment col-12" placeholder="add comment"></textarea>
                    </div>
                </div>

                <div class="col-2">
                    <input type="submit" class="btn btn-success" value="add">
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
    </div>
@endif
<!-- comments -->

<!--admin comments -->
<hr class="border">
@if(count($posts->allComments) !=0)
    <div class="container" style="max-height: 400px; overflow-y: auto">
        @foreach($posts->allComments as $comment)
            <div dir="ltr" class="row py-1" >
                <div class="col-3"></div>
                <div class=" col-6 comments-container" style="border-radius:5px;width: 80%; margin: 2px auto 0 auto ; background-color:rgba(132,144,148,0.52)">
                    <div dir="ltr" class="row">
                        <div class="col-4 main-img-container text-center"><img class="d-block m-auto img-fluid" src="{{asset('img/employer.webp')}}">{{$comment->user}}</div>
                        <div class="col-8 position-relative p-0">
                            <textarea class="main-comment col-12" disabled>{{$comment->com_content}}</textarea>
                            <div class="dropdown position-absolute" style="right: 0;top: 0;">
                                <button type="button" style="background-color: transparent;" class="border-0" data-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu text-center">
                                    <a class="text-danger" href="{{route('admin.deleteComment',['comment_id'=>$comment->id])}}" >Delete</a>
                                </div>
                            </div>
                        </div>
                        @if($comment->replies!='')
                            @foreach($comment->replies as $reply)
                                <div class="col-10 offset-2">
                                    <div style="max-height: 150px; overflow-y: auto" class="row">
                                        <div class="text-center offset-1 col-4 sub-img-container"><img class="d-block m-auto img-fluid" src="{{asset('img/employer.webp')}}">{{$reply->user}} </div>
                                        <div class="col-7">
                                            <textarea class="sub-comment col-11" disabled>{{$reply->com_content}}</textarea>
                                            <div class="dropdown position-absolute" style="right: 0;top: 0;">
                                                <button type="button" style="background-color: transparent;" class="border-0" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu text-center">
                                                    <a class="text-danger" href="{{route('admin.deleteReplay',['replay_id'=>$reply->id])}}" >Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        @if(($posts->user_id==Auth::id() && $posts->status=='active') || ($comment->user_id==Auth::id() && $posts->status=='active') )
                            <div class="insert-reply col-10 offset-2">
                                <div class="formBox">
                                    {!! Form::open(['url'=>route('replyComment',$comment->id),'class'=>'form-row text-center arabicFont','dir'=>$dir,'id'=>'replyCommentForm','method'=>'POST']) !!}
                                    <div class="offset-2 col-8">
                                        <input type="hidden" value="{{$comment->id}}" name="comment_id">
                                        <textarea type="text" name="comment" class="col-12" placeholder="reply"></textarea>
                                    </div>
                                    <div class="col-2">
                                        <input type="submit" name="" class="btn btn-success" value="reply">
                                    </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-3">
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="container">
        <h4 class="text-center">no comment !!</h4>
    </div>
@endif
@if($posts->status=='active' && \Auth::check())
    <div dir="{{$dir}}" class="row py-3" style="width: 80%; margin: auto">
        <div class="col-3">
        </div>
        <div class=" col-6 position-relative p-0 insert-comment">
            <form class="text-center form-row" id="AddCommentForm" method="post" action="{{route('addComment',$posts->id)}}">
                @csrf
                <div class="offset-2 col-8">
                    <div class="input-group">
                        <input type="hidden" value="{{$posts->id}}" name="post_id">
                        <textarea name="comment" class="main-comment col-12" placeholder="add comment"></textarea>
                    </div>
                </div>

                <div class="col-2">
                    <input type="submit" class="btn btn-success" value="add">
                </div>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
@endif
<!--admin comments -->
