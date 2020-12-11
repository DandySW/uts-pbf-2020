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
        $slug = Str::slug($request->title) . '-' . Str::slug(date('dmy H:i:s'));
        $imagename = $slug . '.' . strtolower($extension);
        $imagepath = 'uploads/' . $imagename;

        //  Save Image to Storage use StoreAs
        $image->storeAs('public/uploads', $imagename);

        $json[] = array(
            'status' => 1,
            'title' => $request->title,
            'slug' => $slug,
            'author' => $request->author,
            'image' => $imagepath,
            'content' => $request->content,
            'created' => date('j F Y H:i:s'),
            'editor' => "-",
            'edited' => "",
        );

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

        // Search with looping the full data of article that has slug value
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
        // Get JSON file
        $json = Storage::get('public/article.json');
        $json = json_decode($json, true);

        // Search with looping the full data of article that has slug value
        $count = count($json);
        for ($id = 0; $id < $count; $id++) {
            $article = $json[$id];
            $article_slug = $article['slug'];
            if ($article_slug == $slug) {
                return view('edit', compact('article', 'id'));
            }
        }

        return redirect('/');
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
        // Get JSON file and article's last id 
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

        $slug = Str::slug($request->title) . '-' . Str::slug(date('dmy H:i:s'));

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imagename = $slug . '.' . strtolower($extension);
            $imagepath = 'uploads/' . $imagename;

            //  Save Image to Storage use StoreAs and delete Old Image
            Storage::delete('public/' . $request->old_image);
            $image->storeAs('public/uploads', $imagename);
        } else {
            $image = pathinfo($request->old_image);
            $extension = $image['extension'];

            $imagename = $slug . '.' . $extension;
            $imagepath = 'uploads/' . $imagename;

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

        // Save to JSON
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
        // Get JSON file 
        $getjson = Storage::get('public/article.json');
        $json = json_decode($getjson, true);

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

        $savejson = json_encode($json, JSON_PRETTY_PRINT);
        Storage::put('public/article.json', $savejson);
        return redirect('/');
    }
}
