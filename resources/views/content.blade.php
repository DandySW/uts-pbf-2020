@extends('header-footer')

@section('title')
{{$blog['title']}}
@endsection

@section('active')
<ul class="links">
    <li><a href="{{url('/')}}">List Article</a></li>
    <li class="active"><a>Content Article</a></li>
    <li><a href="{{url('/edit')}}">Editor</a></li>
</ul>
@endsection

@section('content')
<!-- Main -->
<div id="main">

    <!-- Post -->
    <section class="post">
        <header class="major">
            <span class="date">{{$blog['created']}} <br>Ditulis oleh: {{$blog['author']}} | Diedit oleh: {{$blog['editor']}}</span>
            <h1>{{$blog['title']}}</h1>
        </header>
        <div class="image main"><img src="{{$blog['image']}}" alt="" /></div>
        <p>{!!$blog['content']!!}</p>
    </section>

</div>
@endsection