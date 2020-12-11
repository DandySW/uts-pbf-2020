@extends('header-footer')

@section('title')
Edit | {{ $article['title'] }}
@endsection

@section('active')
<ul class="links">
    <li><a href="/">List Article</a></li>
    <li><a href="{{route('article.create')}}"> Create Article</a></li>
    <li><a href="{{route('article.show', $article['slug'])}}">Read Article</a></li>
    <li class="active"><a>Edit Article</a></li>
</ul>
@endsection

@section('content')
<!-- Main -->
<div id="main">

    <!-- Post -->
    <section class="post">

        <!-- Form -->
        <h2>Edit Artikel Ini</h2>
        <form method="POST" action="{{route('article.update', $article['slug'])}}" enctype="multipart/form-data">
            <div class="row gtr-uniform">
                @method('put')
                @csrf
                <div class="col-12">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="old_image" value="{{ $article['image'] }}">

                    Judul Artikel
                    <input type="text" name="title" id="title" placeholder="{{ $article['title'] }}"
                        value="{{ $article['title'] }}" />
                    @error('title')
                    <label for="title">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-6 col-12-xsmall">
                    Penulis
                    <input type="text" id="author" value="{{ $article['author'] }}" disabled />
                </div>
                <div class="col-6 col-12-xsmall">
                    Penyunting
                    <input type="text" name="editor" id="editor" placeholder="Penyunting" value="{{ old('editor') }}" />
                    @error('editor')
                    <label for=" editor">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-12">
                    Gambar Artikel:
                    <input type="file" name="image" id="image" accept='image/*' />
                    <a href="{{url('storage/'.$article['image'])}}" target='_blank'>Lihat gambar saat ini</a>
                    @error('image')
                    <label for="image">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-12">
                    Isi Artikel
                    <textarea name="content" id="content" placeholder="{{ $article['content'] }}"
                        rows="6"> {{ $article['content'] }} </textarea>
                    @error('content')
                    <label for="content">{{ $message }}</label>
                    @enderror
                </div>

                <div class="col-12">
                    <ul class="actions">
                        <li><input type="submit" value="Ubah Artikel" class="primary" /></li>
                        <li><input type="reset" value="Reset" /></li>
                    </ul>
                </div>
            </div>
        </form>
    </section>

</div>
@endsection