<?php

namespace App\Http\Controllers;

use App\News;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;


class NewsController extends Controller
{

    /**
     * Create a new controller instance.
     * User must be logged in to access these pages
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $query = \Request::get('search');

        if ($query)
        {
            $news = News::where('title', 'LIKE', '%' . $query . '%')
                ->orderBy('date')
                ->paginate(10);

        }
        else
        {
            $news = News::orderBy('date', 'desc')
                ->paginate(5);
        }


        return view('news.index')->with('news', $news);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',
            'choice' => 'required'
        ]);

        $post = new News;
        $post->title = $request->input('title');
        $post->text = Purifier::clean($request->input('text'));
        $post->etablissement = $request->input('choice');
        $post->date = time();
        $post->save();

        return redirect('/dashboard')->with('success', 'Information postée');





    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $news = News::find($id);
        return view('news/edit')->with('news', $news);
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
        $this->validate($request, [
            'title' => 'required|string|max:50',
            'text' => 'required|string|max:255',
            'choice' => 'required'
        ]);

        $post = News::find($id);
        $post->title = $request->input('title');
        $post->text = Purifier::clean($request->input('text'));
        $post->etablissement = $request->input('choice');
        $post->date = time();
        $post->save();

        return redirect('/news')->with('success', 'Information modifiée');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::find($id);
        $news->delete();
        return redirect('/news')->with('success', 'Information supprimée');

    }
}
