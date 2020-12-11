<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mendapatkan file JSON dari Storage
        $getjson = Storage::get('public/article.json');
        $json = json_decode($getjson, true);

        return view('index', compact('json'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Mendapatkan file JSON dari Storage
        $getjson = Storage::get('public/article.json');
        $json = json_decode($getjson, true);

        $request->validate(
            [
                'title' => 'required',
                'author' => 'required',
                'image' => 'required|max:5000',
                'content' => 'required|min:10',
            ],
            [
                'title.required' => 'Kolom "judul artikel" harus diisi',
                'author.required' => 'Kolom "penulis" Harus diisi',
                'image.required' => 'Harus ada gambar yang diupload',
                'image.max' => 'Ukuran gambar maksimal 5,0 MB',
                'content.required' => 'Kolom "isi artikel" Harus diisi',
                'content.min' => 'Isi artikel minimal 10 karakter',
            ]
        );

        // Membuat nama baru untuk gambar menggunakan slug judul dan tanggal
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $slug = Str::slug($request->title) . '-' . Str::slug(date('dmy H:i:s'));
        $imagename = $slug . '.' . strtolower($extension);
        $imagepath = 'uploads/' . $imagename;

        //  Menyimpan gambar menggunakan store as
        $image->storeAs('public/uploads', $imagename);

        $json[] = array(
            'status' => 1,
            'title' => $request->title,
            'slug' => $slug,
            'author' => $request->author,
            'image' => $imagepath,
            'content' => $request->content,
            'created' => date('j F Y H:i'),
            'editor' => "-",
            'edited' => "",
        );

        // Menyimpan ke dalam JSON
        $savejson = json_encode($json, JSON_PRETTY_PRINT);
        Storage::put('public/article.json', $savejson);

        return redirect(url('/article', $slug));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // Mendapatkan file JSON dari Storage
        $json = Storage::get('public/article.json');
        $json = json_decode($json, true);

        // Cari artikel yang memiliki slug tersebut
        $count = count($json);
        for ($id = 0; $id < $count; $id++) {
            $article = $json[$id];
            $article_slug = $article['slug'];
            if ($article_slug == $slug) {
                return view('show', compact('article'));
            }
        }
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        // Mendapatkan file JSON dari Storage
        $json = Storage::get('public/article.json');
        $json = json_decode($json, true);

        //Cek apakah merupakan artikel contoh, jika ya tolak
        if ($json[0]['slug'] != $slug) {

            // Cari artikel yang memiliki slug tersebut
            $count = count($json);
            for ($id = 1; $id < $count; $id++) {
                $article = $json[$id];
                $article_slug = $article['slug'];
                if ($article_slug == $slug) {
                    return view('edit', compact('article', 'id'));
                }
            }
        }
        return redirect(url('article/' . $slug));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Mendapatkan file JSON dari Storage
        $getjson = Storage::get('public/article.json');
        $json = json_decode($getjson, true);

        $request->validate(
            [
                'title' => 'required',
                'editor' => 'required',
                'image' => 'max:5000',
                'content' => 'required|min:10',
            ],
            [
                'title.required' => 'Kolom "judul artikel" harus diisi',
                'editor.required' => 'Kolom "penyunting" Harus diisi',
                'image.max' => 'Ukuran gambar maksimal 5,0 MB',
                'content.required' => 'Kolom "isi artikel" Harus diisi',
                'content.min' => 'Isi artikel minimal 10 karakter',
            ]
        );

        // MMembuat slug baru dari judul dan junggal tanggal
        $slug = Str::slug($request->title) . '-' . Str::slug(date('dmy H:i:s'));

        //Cek apakah ada gambar yang diupload atau tidak
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imagename = $slug . '.' . strtolower($extension);
            $imagepath = 'uploads/' . $imagename;

            //  Menyimpan gambar baru ke dalam storage dan menghapus gambar lama
            Storage::delete('public/' . $request->old_image);
            $image->storeAs('public/uploads', $imagename);
        } else {
            // Mendapatkan ekstensi gambar lama
            $image = pathinfo($request->old_image);
            $extension = $image['extension'];
            $imagename = $slug . '.' . $extension;
            $imagepath = 'uploads/' . $imagename;

            //Mengubah nama gambar saat ini
            Storage::move('public/' . $request->old_image, 'public/' . $imagepath);
        };

        $json[$request->id] = array(
            'status' => 1,
            'title' => $request->title,
            'slug' => $slug,
            'author' => $json[$request->id]['author'],
            'image' => $imagepath,
            'content' => $request->content,
            'created' => $json[$request->id]['created'],
            'editor' => $request->editor,
            'edited' => date('j F Y H:i:s'),
        );

        // Menyimpan ke dalam JSON
        $savejson = json_encode($json, JSON_PRETTY_PRINT);
        Storage::put('public/article.json', $savejson);

        return redirect(url('/article', $slug));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        // Mendapatkan file JSON dari Storage
        $getjson = Storage::get('public/article.json');
        $json = json_decode($getjson, true);

        // Cari artikel yang memiliki slug tersebut lalu menghapus gambar serta data artikel
        $count = count($json);
        for ($id = 0; $id < $count; $id++) {
            $article = $json[$id];
            $article_slug = $article['slug'];
            if ($article_slug == $slug) {
                Storage::delete('public/' . $json[$id]['image']);
                unset($json[$id]);
                break;
            }
        }

        // Menyimpan ke dalam JSON
        $savejson = json_encode($json, JSON_PRETTY_PRINT);
        Storage::put('public/article.json', $savejson);
        return redirect('/');
    }
}
