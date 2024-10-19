<form action="{{ route('posts.index') }}" method="GET">
    <select name="search_by">
        <option value="title" {{ request('search_by') == 'title' ? 'selected' : '' }}>Title</option>
        <option value="content" {{ request('search_by') == 'content' ? 'selected' : '' }}>Content</option>
    </select>
    <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
    <button type="submit">Search</button>
</form>

<p>Total posts created today: {{ $totalPostsToday }}</p>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('posts.destroy') }}" method="POST">
    @csrf
    @method('DELETE')
    
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Content</th>
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

<!--pagination-->
{{ $posts->appends(request()->query())->links() }}
