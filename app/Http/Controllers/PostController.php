<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostController extends Controller
{
  

    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchBy = $request->input('search_by', 'title'); // Default to searching by title
        $title = $request->input('title');
        $content = $request->input('content');



        $posts = Post::query();

     // filter by search input
        if ($search) {
            if ($searchBy === 'title') {
                $posts->where('title', 'LIKE', "%{$search}%");
            } elseif ($searchBy === 'content') {
                $posts->where('content', 'LIKE', "%{$search}%");
            } else {
                // If neither title nor content is selected, search in both
                $posts->where(function ($query) use ($search) {
                    $query->where('title', 'LIKE', "%{$search}%")
                          ->orWhere('content', 'LIKE', "%{$search}%");
                });
            }
        }
    
        // filter posts using input-dropdown
        $posts->when($title,  function($query, $title){
            return $query->where('title', 'LIKE', "%{$title}%");
          })->when($content, function($query, $content){
            return $query->where('content', 'LIKE', "%{$content}%");
          });
          
          // Get unique titles and contents for the dropdowns
          $titles = Post::groupBy('title')->pluck('title');
          $contents = Post::groupBy('content')->pluck('content');
          


        $posts = $posts->paginate(5); // Paginate with 5 items per page

        // count posts today by created_at          
        $totalPostsToday = Post::whereDate('created_at', Carbon::today())->count();

        $totalPosts = $posts->count();

        return view('posts.index1', [
            'posts' => $posts,
            'search' => $search,
            'searchBy' => $searchBy,
            'title' => $title,
            'content' => $content,
            'titles' => $titles,
            'contents' => $contents,
            'totalPostsToday' => $totalPostsToday,
            'totalPosts' => $totalPosts,
    
        ]);
    }


    public function create(){
        
        return view('posts.create');
    }

    public function store(Request $request){

     $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
     ]);

     Post::create([
        'title' => $request->title,
        'content' => $request->content,
     ]);

     return redirect()->route('posts.index')->with('success', 'Post created successfully');

    }


    public function show(Post $post){
     
        return view('posts.show', ['post' => $post]);
    }

    public function destroy(Request $request, Post $post)
    {
        $ids = $request->input('ids', []);
        $deletedCount = Post::whereIn('id', $ids)->delete();
        $message = $deletedCount . ' post(s) have been deleted.';
        return redirect()->route('posts.index')->with('success', $message);
    }
    
}
