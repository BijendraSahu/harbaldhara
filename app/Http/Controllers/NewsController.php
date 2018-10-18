<?php

namespace App\Http\Controllers;

use App\NewsModel;
use Illuminate\Http\Request;

session_start();

class NewsController extends Controller
{
    public function index()
    {
        return view('news.view_news')->with('news', NewsModel::get());
    }

    public function create()
    {
        return view('news.create_news');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ads = new NewsModel();
        $ads->text = request('text');
        $ads->save();
        return redirect('news')->with('message', 'News has been saved');
    }

    public function edit($id)
    {
        $news = NewsModel::find($id);
        return view('news.edit_news')->with(['news' => $news]);
    }


    public function update($id, Request $request)
    {

        $user_master = NewsModel::find($id);
        $user_master->text = request('text');
        $user_master->save();
        return redirect('news')->with('message', 'News has been updated...!');
    }

    public function destroy($id)
    {
        $user_master = NewsModel::find($id)->delete();
        return redirect('news')->with('message', 'News has been deleted');
    }
}
