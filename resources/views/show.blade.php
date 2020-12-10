@extends('header-footer')

@section('title')
{{$article['title']}}
@endsection

@section('active')
<ul class="links">
    <li><a href="{{url('/')}}">List Article</a></li>
    <li><a href="{{route('article.create')}}"> Create Article</a></li>
    <li class="active"><a>Read Article</a></li>
    <li><a href="{{route('article.edit', $article['slug'])}}">Edit Article</a></li>
</ul>
@endsection


@section('content')
<!-- Main -->
<div id="main">

    <!-- Post -->
    <section class="post">
        <header class="major">
            <span class="date">{{$article['created']}} <br>Ditulis oleh: {{$article['author']}} | Diedit oleh:
                {{$article['editor']}}</span>
            <h1>{{$article['title']}}</h1>
        </header>
        <div class="image main"><img src="{{ url($article['image']) }}" alt="" /></div>
        <p>{!!$article['content']!!}</p>
    </section>

</div>
@endsection