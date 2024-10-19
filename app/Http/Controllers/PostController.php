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

        $posts = Post::query();

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

        $posts = $posts->paginate(5); // Paginate with 5 items per page

        $totalPostsToday = Post::whereDate('created_at', Carbon::today())->count();

        return view('posts.index', [
            'posts' => $posts,
            'search' => $search,
            'searchBy' => $searchBy,
            'totalPostsToday' => $totalPostsToday
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

    public function destroy(Request $request)
    {
        $ids = $request->input('ids', []);
        $deletedCount = Post::whereIn('id', $ids)->delete();
        $message = $deletedCount . ' post(s) have been deleted.';
        return redirect()->route('posts.index')->with('success', $message);
    }
}
