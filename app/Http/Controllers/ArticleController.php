<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get articles
 
        $articles = Article::orderBy('created_at', 'desc')->paginate(20);

        // Return collection of articles as a resource
        return ArticleResource::collection($articles);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         // Put is for update. So if its asking update then we have to find the article, otherwise we don't
         // Otherwise create a new Article
        $article = $request->isMethod('put') ? Article::findorFail($request->article_id) : new Article;

        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');

        if ($article->save()){
           return new ArticleResource($article);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get article
        $article = Article::findOrFail($id);

        //Return single article as a resource
        return new ArticleResource($article);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get article
      $article = Article::findOrFail($id);

      if ($article->delete()){
         return new ArticleResource($article);
      }
    
    }

    public function indexlabel($label)
    {
      $articles = Article::where('label', $label)->orderBy('created_at', 'desc')->paginate(20);

        // Return collection of articles as a resource
        return ArticleResource::collection($articles);
    }
}
