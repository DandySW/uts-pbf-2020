@extends('header-footer')

@section('title','UTS PBF 2020 - 182410101001')

@section('intro')
<div id="intro">
    <h1>UTS PBF</h1>
    <h2>Dandy Satrio W. - 182410101001</h2>
    <p>Mini Blog yang dibuat dengan PHP + Framework Laravel 5.8 untuk tugas Ujian Tengah Semester kelas Pemrograman <br />Berbasis Framework 2020. Tema dari Mini Blog ini seputar Game dan juga Gadeget. Siapa saja bebas untuk<br /> membaca, membuat, mengedit, dan menghapus artikel asalkan sesuai dengan tema Mini Blog ini :)<p>
            <ul class="actions">
                <li><a href="#header" class="button icon solid solo fa-arrow-down scrolly">Continue</a></li>
            </ul>
</div>
@endsection

@section('active')
<ul class="links">
    <li class="active"><a>List Article</a></li>
    <li><a href="{{url('article/create')}}"> Create Article</a></li>
    <li><a>Content Article</a></li>
    <li><a>Editor</a></li>
</ul>
@endsection

@section('content')
<!-- Main -->
<div id="main">
    <!-- Featured Post -->
    <article class="post featured">
        <header class="major">
            <span class="date">{{$json['0']['created']}}<br>Ditulis oleh: {{$json[0]['author']}} | Diedit oleh: {{$json[0]['editor']}}</span>
            <h2><a href="{{url('article/0')}}">{{$json['0']['title']}}</a></h2>
            <p>{!! ReadMoreSpace($json['0']['content'], 500)!!}</p>
        </header>
        <a href="#" class="image main"><img src="{{$json['0']['image']}}" alt="" /></a>
        <ul class="actions special">
            <li><a href="{{url('article/0')}}" class="button large">Readmore</a></li>
        </ul>
    </article>
    <!-- Posts -->
    <section class="posts">
        @foreach($json as $blog)
        @if($blog['id']>0)
        <article class="post featured">
            <header class="major">
                <span class="date">{{$blog['created']}}<br>Ditulis oleh: {{$blog['author']}} | Diedit oleh: {{$blog['editor']}}</span>
                <h2><a href="{{url('article/'.$blog['id'])}}">{{$blog['title']}}</a></h2>
                <p>{!! ReadMoreSpace($blog['content'], 500)!!}</p>
            </header>
            <a href="#" class="image main"><img src="{{$blog['image']}}" alt="" /></a>
            <ul class="actions special">
                <li><a href="#" class="button large">Readmore</a></li>
            </ul>
        </article>
        @endif
        @endforeach
    </section>
    @endsection

    @section('footer')
    <footer>
        <div class="pagination">
            <!--<a href="#" class="previous">Prev</a>-->
            <a href="#" class="page active">1</a>
            <a href="#" class="page">2</a>
            <a href="#" class="page">3</a>
            <span class="extra">&hellip;</span>
            <a href="#" class="page">8</a>
            <a href="#" class="page">9</a>
            <a href="#" class="page">10</a>
            <a href="#" class="next">Next</a>
        </div>
    </footer>
</div>

@endsection
<!-- Read More Function -->
<?php
function ReadMoreSpace($input, $length)
{
    if (strlen($input) <= $length) {
        return $input;
    } else {
        $trimmed_text = substr($input, 0, $length) . '...(baca selengkapnya)';
        return $trimmed_text;
    }
}
?>