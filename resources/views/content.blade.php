@extends('header-footer')

@section('title')
{{$blog['title']}}
@endsection

@section('active')
<ul class="links">
    <li><a>List Article</a></li>
    <li class="active"><a>Content Article</a></li>
    <li><a>Editor</a></li>
</ul>
@endsection

@section('content')
<!-- Main -->
<div id="main">

    <!-- Post -->
    <section class="post">
        <header class="major">
            <span class="date">{{$blog['created']}}</span>
            <h1>{{$blog['title']}}</h1>
        </header>
        <div class="image main"><img src="{{$blog['image']}}" alt="" /></div>
        <p>{!!$blog['content']!!}</p>
    </section>

</div>
@endsection