@extends('header-footer')

@section('title', 'Buat Artikel Baru')

@section('active')
<ul class="links">
    <li><a href="{{url('/')}}">List Article</a></li>
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
        <h2>Buat Artikelmu Sendiri</h2>
        <form method="PUT" action="{{route('article.update')}}" enctype="multipart/form-data">
            <div class="row gtr-uniform">
                @csrf
                <input type="hidden" name="created" value="{{date('j F Y')}}">
                <input type="hidden" name="edited" value="-">
                <input type="hidden" name="id" value={{$last_article+1}}>
                <div class="col-12">
                    Judul Artikel
                    <input type="text" name="title" id="title" placeholder="Judul Artikel" />
                    @error('title')
                    <label for="title">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-6 col-12-xsmall">
                    Penulis
                    <input type="text" name="author" id="author" value="" placeholder="Penulis" />
                    @error('author')
                    <label for="author">{{ $message }}</label>
                    @enderror
                </div>
                <div class="col-6 col-12-xsmall">
                    Penyunting
                    <input type="text" id="editor" value="-" disabled />
                </div>
                <div class="col-12">
                    Gambar Artikel:
                    <input type="file" name="image" id="image" placeholder="Link Gambar" accept='image/*' />
                    @error('image')
                    <label for="image">{{ $message }}</label>
                    @enderror
                </div>
                <!-- Break -->
                <div class="col-12">
                    Isi Artikel
                    <textarea name="content" id="content" placeholder="Enter your message" rows="6"></textarea>
                    @error('content')
                    <label for="content">{{ $message }}</label>
                    @enderror
                </div>
                <!-- Break -->
                <div class="col-12">
                    <ul class="actions">
                        <li><input type="submit" value="Send Message" class="primary" /></li>
                        <li><input type="reset" value="Reset" /></li>
                    </ul>
                </div>
            </div>
        </form>
    </section>

</div>
@endsection

<!-- Option Function -->
<!-- <script>
	function upload() {
		document.getElementById("satu").disabled = false;
		document.getElementById("dua").disabled = true;
	}

	function link() {
		document.getElementById("satu").disabled = true;
		document.getElementById("link").disabled = false;
	}
</script> -->