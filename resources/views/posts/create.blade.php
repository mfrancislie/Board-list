<h1>Create Post</h1>

<form action="{{ route('posts.store') }}" method="post">
    @csrf
    <input type="text" name="title" placeholder="Title">
    <input type="text" name="content" placeholder="Content">
    <button type="submit">Create</button>
</form>

<a href="{{ route('posts.index') }}">Back to Posts</a>
