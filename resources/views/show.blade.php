@extends('header-footer')

@section('title')
{{ $article['title'] }}
@endsection

@section('active')
<ul class="links">
    <li><a href="/">List Article</a></li>
    <li><a href="{{route('article.create')}}"> Create Article</a></li>
    <li class="active"><a>Read Article</a></li>
    @if($article['status'] == 1)
    <li><a href="{{route('article.edit', $article['slug'])}}">Edit Article</a></li>
    @endif
</ul>
@endsection

@section('content')
<!-- Main -->
<div id="main">

    <!-- Post -->
    <section class="post">
        <header class="major">
            <span class="date">Ditulis oleh: {{$article['author']}} ({{$article['created']}})
                @if( $article['editor'] == "")
                <br>Diedit oleh: -
                @else
                <br>Diedit oleh: {{$article['editor']}} ({{$article['edited']}})
                @endif
                <h1>{{$article['title']}}</h1>
        </header>
        <div class="image main"><img src="{{url('storage/'.$article['image'])}}"
                alt="{{url('storage/'.$article['image'])}}" /></div>
        <p>{!!$article['content']!!}</p>
    </section>

</div>
@endsection