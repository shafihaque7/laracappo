<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use App\Http\Resources\Article as ArticleResource;
use DB;
use Response;

class ArticleController extends Controller
{
   function __construct(){
      return $this->middleware('auth:api');
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get articles
 
        $theid = request()->user()->id;
        $articles = Article::where('user_id',$theid )->orderBy('created_at', 'desc')->paginate(1000);

        // This is to add row to the json
        $articles->map(function($post){
         //   $post['rows'] = (strlen($post['body']))/10;

            if ((strlen($post['body']) /10) < 10 ){
               $post['rows'] = 10;
            }
            else if ((strlen($post['body']) /10) > 30 ){

               $post['rows'] = 30;
            }
            else{
               $post['rows'] = (strlen($post['body']) /10);
            }
           
           return $post;
        });
         // return $articles;
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
        $article->title = $request->input('title') ? $request -> input('title') : "";
        $article->body = $request -> input('body') ? $request -> input('body') : "";
        $article->label = $request->input('label') ? $request -> input('label') : "";
        $article->user_id = $request->user()->id;

        

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
      $theid = request()->user()->id;
      $articles = Article::where('user_id',$theid )->where('label', $label)->orderBy('created_at', 'desc')->paginate(1000);
      // This is to add row to the json
      $articles->map(function($post){
         //   $post['rows'] = (strlen($post['body']))/10;

            if ((strlen($post['body']) /10) < 10 ){
               $post['rows'] = 10;
            }
            else if ((strlen($post['body']) /10) > 30 ){

               $post['rows'] = 30;
            }
            else{
               $post['rows'] = (strlen($post['body']) /10);
            }
           
           return $post;
        });

        // Return collection of articles as a resource
        return ArticleResource::collection($articles);
    }

    public function getuniquelabels()
    {
      // $arr = array('a' => '1', 'b' => '2', 'c' => '3', 'd' => '4', 'e' => '5');

      $theid = request()->user()->id;

      $query = "select distinct label from articles where user_id = $theid and not label = 'All Labels' ORDER BY label" ;
      $post = DB::select($query );

      return Response::json($post);
      // return env('OAUTH_KEY', '111');


    }
}
