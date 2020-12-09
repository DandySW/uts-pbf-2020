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
        // $getjson = Storage::get('public/article.json');
        // $json = json_decode($getjson, true);
        // $last_article = end($json);
        // $last_article = $last_article['id'];
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
        $getjson = Storage::get('public/article.json');
        $json = json_decode($getjson, true);
        $last_id = end($json);
        $id = $last_id['id'] + 1;
        // $file = base_path('storage/app/public/article.json');
        // $artikel = file_get_contents($file);
        // $data = json_decode($artikel, true);
        $request->validate(
            [
                'title' => 'required',
                'author' => 'required',
                'image' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'Kolom "judul artikel" harus diisi',
                'author.required' => 'Kolom "penulis" Harus diisi',
                'image.required' => 'Harus ada gambar yang diupload',
                'content.required' => 'Kolom "isi artikel" Harus diisi',
            ]
        );
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $slug = Str::slug($request->title);
        $imagename = 'artikel-' . $id . '_' . $slug . '.' . strtolower($extension);
        $imagepath = 'storage/uploads/' . $imagename;

        $json[] = array(
            'id' => $id,
            'slug' => $slug,
            'title' => $request->title,
            'author' => $request->author,
            'image' => $imagepath,
            'content' => $request->content,
            'created' => date('j F Y'),
            'editor' => "-",
            'edited' => "-",
        );
        $image->storeAs('public/uploads', $imagename);
        // return $imagepath;

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
        $json = Storage::get('public/article.json');
        $json = json_decode($json, true);

        $last_id = end($json);
        for ($id = 0; $id < $last_id; $id++) {
            $article = $json[$id];
            $article_slug = $article['slug'];
            if ($article_slug == $slug) {
                return view('show', compact('article'));
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $json = Storage::get('public/article.json');
        $json = json_decode($json, true);
        $article = $json[$id];
        return view('editor', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getjson = Storage::get('public/article.json');
        $json = json_decode($getjson, true);
        // $file = base_path('storage/app/public/article.json');
        // $getJson = file_get_contents($file);
        // $artikel = json_decode($getJson, true);

        array_splice($json, $id, 1);

        $savejson = json_encode($json, JSON_PRETTY_PRINT);
        Storage::put('public/article.json', $savejson);

        return redirect('/');
        // return redirect()->route('index')->with(['artikel' => $artikel]);
    }
}
