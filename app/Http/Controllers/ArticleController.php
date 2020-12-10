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
        // Get JSON file 
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
        // Get JSON file and article's last id 
        $getjson = Storage::get('public/article.json');
        $json = json_decode($getjson, true);
        $last_id = end($json);
        $id = $last_id['id'] + 1;

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

        // Make new name for image (use slug title) with original extension
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $slug = Str::slug($request->title) . '-' . $id;
        $imagename = 'artikel-' . $id . '_' . $slug . '.' . strtolower($extension);
        $imagepath = 'storage/uploads/' . $imagename;

        $json[] = array(
            'id' => $id,
            'title' => $request->title,
            'slug' => $slug,
            'author' => $request->author,
            'image' => $imagepath,
            'content' => $request->content,
            'created' => date('j F Y'),
            'editor' => "-",
            'edited' => "",
        );
        $image->storeAs('public/uploads', $imagename);

        // Save to JSON
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
        // Get JSON file
        $json = Storage::get('public/article.json');
        $json = json_decode($json, true);

        // Search ID from last article
        $last_id = end($json);
        $last_id = $last_id['id'];

        // Search with looping the full data of article that has slug value
        for ($id = 0; $id <= $last_id; $id++) {
            $article_slug = $json[$id]['slug'];
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
    public function edit($slug)
    {
        $json = Storage::get('public/article.json');
        $json = json_decode($json, true);

        $last_id = end($json);
        $last_id = $last_id['id'];
        for ($id = 0; $id <= $last_id; $id++) {
            $article = $json[$id];
            $article_slug = $article['slug'];
            if ($article_slug == $slug) {
                return view('edit', compact('article'));
            }
        }
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
        // Get JSON file
        $json = Storage::get('public/article.json');
        $json = json_decode($json, true);

        // $last_id = end($json);
        // $last_id = $last_id['id'];
        // for ($id = 0; $id <= $last_id; $id++) {
        //     $article = $json[$id];
        //     $article_slug = $article['slug'];
        //     if ($article_slug == $slug) {
        //         return $json[$id];
        //     }
        // }

        array_splice($json, $id, 1);

        $savejson = json_encode($json, JSON_PRETTY_PRINT);
        Storage::put('public/article.json', $savejson);

        return redirect('/');
        // return redirect()->route('index')->with(['artikel' => $artikel]);
    }
}
