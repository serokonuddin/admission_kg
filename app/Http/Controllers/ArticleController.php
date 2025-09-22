<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;
use Session;
use Auth;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        Session::put('activemenu','website');
        Session::put('activesubmenu','at');
        $articles = Article::all();
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        Session::put('activemenu','website');
        Session::put('activesubmenu','at');
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
		if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
		$id=$request->id;
        $data = $request->validate([
            'article_type' => 'required|string',
            'article_title' => 'required|string',
            'article' => 'required',
            'image' => 'required',
            'publish_date' => 'required|date',
            'status' => 'boolean',
        ]);
		 
		if($id!=null){
			$article = Article::findOrFail($id);
			$data['updated_by']=Auth::user()->id;
			$article->update($data);
			 return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
		}else{
			$data['created_by']=Auth::user()->id;
			Article::create($data);
			 return redirect()->route('articles.index')->with('success', 'Article Create successfully.');
		}
        

        
       
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        $article = Article::findOrFail($id);
        return view('articles.create', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        $data = $request->validate([
            'article_type' => 'required|string|max:256',
            'article_title' => 'required|string|max:256',
            'article' => 'required|string',
            'image' => 'required',
            'publish_date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $article = Article::findOrFail($id);

        

        $article->update($data);
        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(Auth::user()->group_id!=2 && Auth::user()->group_id!=10){
            return 1;
        }
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }
}
