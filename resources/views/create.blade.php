@extends('header-footer')

@section('title', 'Buat Artikel Baru')

@section('active')
<ul class="links">
	<li><a href="{{url('/')}}">List Article</a></li>
	<li class="active"><a>Create Article</a></li>
	<li><a>Read Article</a></li>
	<li><a>Edit Article</a></li>
</ul>
@endsection

@section('content')
<!-- Main -->
<div id="main">

	<!-- Post -->
	<section class="post">

		<!-- Form -->
		<h2>Buat Artikelmu Sendiri</h2>
		<form method="POST" action="{{route('article.store')}}" enctype="multipart/form-data">
			<div class="row gtr-uniform">
				@csrf
				<div class="col-12">
					Judul Artikel
					<input type="text" name="title" id="title" placeholder="Judul Artikel" value="{{ old('title') }}" />
					@error('title')
					<label for="title">{{ $message }}</label>
					@enderror
				</div>
				<div class="col-6 col-12-xsmall">
					Penulis
					<input type="text" name="author" id="author" placeholder="Penulis" value="{{ old('author') }}" />
					@error('author')
					<label for=" title">{{ $message }}</label>
					@enderror
				</div>
				<div class="col-6 col-12-xsmall">
					Penyunting
					<input type="text" id="editor" value="-" disabled />
				</div>
				<div class="col-12">
					Gambar Artikel:
					<input type="file" name="image" id="image" accept='image/*' />
					@error('image')
					<label for="image">{{ $message }}</label>
					@enderror
				</div>
				<!-- Break -->
				<div class="col-12">
					Isi Artikel
					<textarea name="content" id="content" placeholder="Isi Artikel"
						rows="6"> {{ old('content') }} </textarea>
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