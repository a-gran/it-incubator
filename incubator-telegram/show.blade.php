@extends('FrontEnd.layouts.master')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('FrontEnd/css/modal-video.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .btn_like_a {
        border: none !important;
        background: transparent !important;
    }

    .display_block {
        display: block;
    }

    .mt-10 {
        margin-top: 10% !important;
    }

    .like_active {
        color: #EC5538;
    }

    .like_color {
        color: rgb(86, 109, 255);
    }

    @media only screen and (min-width:320px) and (max-width:768px) {
        #reply_body {
            margin-top: 43px;
        }
    }
</style>
@endsection
@section('content')
<div class="page-title" style="background-image: url({{ asset('FrontEnd/images/page-title.png') }})">
    <h1>Single product</h1>
</div>

<section id="blog">

    <div class="blog container">
        <div class="row">
            <div class="col-md-8">

                <div class="blog-item">
                    @if($product->video)
                    <div class='video-outter' style=" position: relative;/* left: 50%; */">
                        <img class="img-responsive img-blog" src="{{ $product->image }}" width="100%"
                            alt="{{ $product->name }}" />
                        <div class='video-inner' style=" position: absolute;left: 50%;bottom: 50%;">
                            <a class="js-modal-btn" data-channel="video" data-video-url={{ $product->video }} href="#">
                                <i class="fa fa-play" style="font-size:42px;color:red;"></i>
                            </a>
                        </div>
                    </div>
                    @else
                    <img class="img-responsive img-blog" src="{{ $product->image }}" width="100%"
                        alt="{{ $product->name }}" />
                    @endif
                    <div class="blog-content">
                        {{-- {{ dd($product->category) }} --}}
                        <a href="#" class="blog_cat">{{ $product->category->name }}</a>
                        <h2><a href="blog-item.html">{{ $product->name }}</a></h2>

                        <div class="post-meta">

                            {{--  <p>By <a href="#">Martin Garrix</a></p>

                                <p><i class="fa fa-clock-o"></i> <a href="#">18 May 2017</a></p>  --}}

                            <p><i class="fa fa-comment"></i> <a href="#">32</a></p>

                            <p>

                                share:

                                <a href="#" class="fa fa-facebook"></a>

                                <a href="#" class="fa fa-twitter"></a>

                                <a href="#" class="fa fa-linkedin"></a>

                                <a href="#" class="fa fa-pinterest"></a>

                            </p>

                        </div>
                        {!! $product->body !!}


                        <div class="comments">
                            <h2>Comments</h2>
                            @foreach($comments as $comment)
                            @if($comment->confirmation == 1)
                            <div class="single-comment">
                                <div class="comment-img">
                                    <img src="{{ asset('FrontEnd/images/graverter.jpg') }}" alt="author">
                                </div>
                                <div class="comment-content">
                                    <h5>{{ $comment->user->name }} {{ $comment->user->last_name }}</h5>
                                    <p>{!! $comment->body !!}</p>
                                </div>
                                <div class="comment-count">
                                    <button class="btn_like_a reply-btn"><i class="fa fa-reply"></i> Reply
                                        (1)</button>
                                    <button class="btn_like_a like"> <i class="fa fa-thumbs-o-up like-hand"
                                            aria-hidden="true"></i>
                                        {{ $like_counter }}</button>
                                </div>
                            </div>
                            <div class="single-comment reply_div display_none reply">
                                <div id="demo" class="comment-content comment-form">
                                    <form action="{{ route('products.reply_store',['id'=>$product->id]) }}"
                                        method="POST" class="replyForm">
                                        @csrf
                                        <textarea id="body" name="body"></textarea>
                                        <input type="submit" value="Save" onClick={{ !auth()->check()? "noAuth()":""}}>
                                    </form>
                                </div>
                            </div>
                            @endif
                            @endforeach


                            <div class="single-comment">
                                <div class="comment-img">
                                    <img src="{{ asset('FrontEnd/images/graverter.jpg') }}" alt="author">
                                </div>
                                <div class="comment-content comment-form">
                                    <form action="{{ route('products.store',['id'=>$product->id]) }}" method="POST"
                                        id="commentForm">
                                        @csrf
                                        <textarea id="body" name="body"></textarea>
                                        <input type="submit" value="Comment"
                                            onClick={{ !auth()->check()? "noAuth()":""}}>
                                    </form>
                                    @if(auth()->check())
                                    <div class="alert alert-success mt display_none" id="success-msg">
                                        Your comment has been recorded and will be displayed on the screen after
                                        approval.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </div>
                    <!--/.blog-item-->


                </div>
                <!--/.col-md-8-->
            </div>
            <aside class="col-md-4">
                <div class="widget search">
                    <form role="form">
                        <input type="text" class="form-control search_box" autocomplete="off" placeholder="Search Here">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <!--/.search-->


                <div class="widget archieve">
                    <h3>Categories</h3>
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="blog_archieve">
                                @foreach($categories as $category)
                                <li><a href="#">{{ $category->name }} <span
                                            class="pull-right">({{ $products->where('category_id',$category->id)->count() }})</span></a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/.archieve-->



                {{--  <div class="widget blog_gallery">
                    <h3>Our Gallery</h3>
                    <ul class="sidebar-gallery clearfix">
                        <li>
                            <a href="#"><img src="images/sidebar-g-1.png" alt="" /></a>
                        </li>
                        <li>
                            <a href="#"><img src="images/sidebar-g-2.png" alt="" /></a>
                        </li>
                        <li>
                            <a href="#"><img src="images/sidebar-g-3.png" alt="" /></a>
                        </li>
                        <li>
                            <a href="#"><img src="images/sidebar-g-4.png" alt="" /></a>
                        </li>
                        <li>
                            <a href="#"><img src="images/sidebar-g-5.png" alt="" /></a>
                        </li>
                        <li>
                            <a href="#"><img src="images/sidebar-g-6.png" alt="" /></a>
                        </li>
                    </ul>
                </div>
                <!--/.blog_gallery-->  --}}

                <div class="widget social_icon">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-linkedin"></a>
                    <a href="#" class="fa fa-pinterest"></a>
                    <a href="#" class="fa fa-github"></a>
                </div>

            </aside>

            <!--/.row-->
        </div>
</section>
<!--/#blog-->
@endsection
@push('scripts')
<script src="{{ asset('FrontEnd/js/modal-video.js') }}"></script>
<script>
    var video = new ModalVideo('.js-modal-btn');
</script>
<script>
    $("#commentForm").submit(function(event){
        event.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ route('products.store',['id'=>$product->id]) }}',
            data: $('#commentForm').serialize(),
            async: false,
            success: function (data) {
                $('#success-msg').css("display","block");

            },
            error: function (data) {
                //console.log(data.responseText);
                Swal.fire({
                    title: 'noComment Error!',
                    text: 'please write your comment!',
                    type: 'error',
                    confirmButtonText: 'Cool'
                  })
            }
        });
    });
    $('.replyForm').submit(function(event){
        event.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '{{ route('products.reply_store',['id'=>$product->id]) }}',
            data: $('.replyForm').serialize(),
            async: false,
            success: function (data) {
                //$('#success-msg').css("display","block");

            },
            error: function (data) {
                console.log(data.responseText);
                Swal.fire({
                    title: 'noComment Error!',
                    text: 'please write your comment!',
                    type: 'error',
                    confirmButtonText: 'Cool'
                  })
            }
        });
    });
    function noAuth(){
        Swal.fire({
            title: 'noLogin Error!',
            text: 'please first login',
            type: 'error',
            confirmButtonText: 'Cool'
          })
    }
</script>
<script>
    $('.like').click(function(){
         $(this).children().toggleClass('fa-thumbs-o-up');
         $(this).children().toggleClass('fa-thumbs-up');
         $(this).children().toggleClass('like_color');
         //console.log($(this).children().hasClass('fa-thumbs-o-up'));
         //console.log(parseInt($(this).text()));
         if($(this).children().hasClass('fa-thumbs-up')){
            var x = parseInt($(this).text())+1;
            console.log(x);
         }
    });
</script>
<script>
    $('.reply-btn').click(function(){
         $(this).parent().parent().next().toggle();
    });
</script>

@endpush
