@extends('header-footer')

@section('title', 'Buat Artikel Baru')

@section('active')
<ul class="links">
	<li><a>List Article</a></li>
	<li class="active"><a href="{{url('article/create')}}"> Create Article</a></li>
	<li><a>Content Article</a></li>
	<li><a>Editor</a></li>
</ul>
@endsection

@section('content')
<!-- Main -->
<div id="main">

	<!-- Post -->
	<section class="post">
		<!-- Form -->
		<h2>Buat Artikelmu Sendiri</h2>

		<form method="post" action="{{route('article.store')}}" onsubmit="">
			<div class="row gtr-uniform">
				@csrf
				<input type="hidden" name="created" value="{{date('j F Y')}}">
				<input type="hidden" name="edited" value="-">
				<div class="col-12">
					Judul Artikel
					<input type="text" name="title" id="title" value="" placeholder="Judul Artikel" required />
				</div>
				<div class="col-6 col-12-xsmall">
					Nama Penulis
					<input type="text" name="author" id="author" value="" placeholder="Nama Penulis" required />
				</div>
				<div class="col-6 col-12-xsmall">
					Nama Penyunting
					<input type="text" name="editor" id="editor" value="-" placeholder="Nama Editor" readonly />
				</div>
				<!-- <div class="col-12">
					<input type="button" onclick="upload()" value="Upload Gambar">
					<input type="button" onclick="link()" value="Melalui Link">
				</div> -->
				<!-- <div class="col-6 col-12-xsmall">
					<input type="file" name="upload" id="satu" accept="image/*" disabled /> </div> -->
				<div class="col-6 col-12-xsmall">
					<input type="text" name="image" id="image" value="" placeholder="Link Gambar" disabled />
				</div>
				<!-- Break -->
				<div class="col-12">
					<textarea name="content" id="content" placeholder="Enter your message" rows="6"></textarea>
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