
{{--  filter by search input --}}
<form action="{{ route('posts.index') }}" method="GET">
    <select name="search_by">
        <option value="title" {{ request('search_by') == 'title' ? 'selected' : '' }}>Title</option>
        <option value="content" {{ request('search_by') == 'content' ? 'selected' : '' }}>Content</option>
    </select>
    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
    <button type="submit">Search</button>
</form>

<p>Total posts created today: {{ $totalPostsToday }}</p>
<p>Total posts: {{ $totalPosts }}</p>

{{-- filter posts by input --}}
<form action="{{route('posts.index')}}" method="GET">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="{{ request('title') }}">
    
    <label for="content">Content:</label>
    <input type="text" name="content" id="content" value="{{ request('content') }}">

    <button type="submit">Filter</button>
</form>

{{-- filter posts using input and dropdown --}}
<form action="{{ route('posts.index') }}" method="GET">
    <label for="title">Title:</label>
    <select name="title" id="title">
        <option value="">Select Title</option>
        @foreach($titles as $option)
            <option value="{{ $option }}" {{ request('title') == $option ? 'selected' : '' }}>{{ $option }}</option>
        @endforeach
    </select>
    
    <label for="content">Content:</label>
    <select name="content" id="content">
        <option value="">Select Content</option>
        @foreach($contents as $option)
            <option value="{{ $option }}" {{ request('content') == $option ? 'selected' : '' }}>{{ $option }}</option>
        @endforeach
    </select>

    <button type="submit">Filter</button>
</form>


@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('posts.destroy') }}" method="POST">
    @csrf
    @method('DELETE')
   
    <table class="table-fixed">
        <thead>
          <tr>
            <th>ID</th>
            <th>TITLE</th>
            <th>CONTENT</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr>
                <td><input type="checkbox" name="ids[]" value="{{ $post->id }}"></td>
                <td><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></td>
                <td>{{ $post->content }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
      
  <br/>
  <br/>
    <button type="submit">Delete Selected</button>
</form>

<a href="{{ route('posts.create') }}">Create Post</a>
<br/>
  <br/>

    <!-- Pagination -->
<div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
    <div class="flex flex-1 justify-between sm:hidden">
        <!-- Previous & Next Links for Mobile -->
        @if ($posts->onFirstPage())
            <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400">Previous</span>
        @else
            <a href="{{ $posts->previousPageUrl() }}" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
        @endif

        @if ($posts->hasMorePages())
            <a href="{{ $posts->nextPageUrl() }}" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        @else
            <span class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-400">Next</span>
        @endif
    </div>

    <!-- Full Pagination Links for Desktop -->
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-700">
                Showing
                <span class="font-medium">{{ $posts->firstItem() }}</span>
                to
                <span class="font-medium">{{ $posts->lastItem() }}</span>
                of
                <span class="font-medium">{{ $posts->total() }}</span>
                results
            </p>
        </div>
        <div>
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                {{-- Previous Button --}}
                @if ($posts->onFirstPage())
                    <span class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300">Previous</span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Previous</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($posts->links()->elements[0] as $page => $url)
                    @if ($page == $posts->currentPage())
                        <span class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Button --}}
                @if ($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Next</a>
                @else
                    <span class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300">Next</span>
                @endif
            </nav>
        </div>
    </div>
</div>
  </div>

    {{-- {{ $posts->appends(request()->query())->links() }} --}}
</div>