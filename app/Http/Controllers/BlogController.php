<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $json = Storage::get('public/blog.json');
        $json = json_decode($json, true);
        // return $json;
        // $last_blog = end($json);
        // $last_blog = $last_blog['id'];
        // return ($last_blog);
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
        $file = base_path('storage/app/public/blog.json');
        $artikel = file_get_contents($file);
        $data = json_decode($artikel, true);
        $data[] = array(
            'id' => $request->input('id'),
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'image' => $request->input('image'),
            'content' => $request->input('content'),
            'created' => $request->input('created'),
            'editor' => $request->input('editor'),
            'edited' => $request->input('edited'),
        );

        $jsonFile = json_encode($data, JSON_PRETTY_PRINT);
        $artikel = file_put_contents($file, $jsonFile);
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $json = Storage::get('public/blog.json');
        $json = json_decode($json, true);
        $blog = $json[$id];
        return view('content', compact('blog'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $json = Storage::get('public/blog.json');
        $json = json_decode($json, true);
        $blog = $json[$id];
        return view('editor', compact('blog'));
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
        $json = Storage::get('public/blog.json');
        $json = json_decode($json, true);

        array_splice($json, $id, 1);

        $jsonFile = json_encode($json, JSON_PRETTY_PRINT);
        $getJson = file_put_contents($file, $jsonFile);

        return redirect()->route('index')->with(['artikel' => $artikel]);
    }
}
