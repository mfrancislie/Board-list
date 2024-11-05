<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite('resources/css/app.css')
    </head>

<body>          
    <div class="min-h-screen bg-gray-100 py-8 px-4 sm:px-6 lg:px-8">

        <div class="max-w-7xl mx-auto">
          <h1 class="text-3xl font-bold text-gray-900 mb-8">Posts</h1>

            {{-- Search and filter section --}}
        <div class="bg-white shadow-sm rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Search and Filter</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <form onSubmit={handleSearch} class="space-y-4">
                <div class="flex space-x-4">
                  <select
                    value={searchBy}
                    class="block w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  >
                    <option value="title">Title</option>
                    <option value="content">Content</option>
                  </select>
                  <input
                    type="text"
                    value=""
                    placeholder="Search..."
                    class="block w-2/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  />
                </div>
                <button
                  type="submit"
                  class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                  Search
                </button>
              </form>
              <form onSubmit={handleFilter} class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label htmlFor="title" class="block text-sm font-medium text-gray-700">
                      Title
                    </label>
                    <select
                      name="title"
                      id="title"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                      <option value="">Select Title</option>
                      {titles.map((title) => (
                        <option key={title} value={title}>
                          {title}
                        </option>
                      ))}
                    </select>
                  </div>
                  <div>
                    <label htmlFor="content" class="block text-sm font-medium text-gray-700">
                      Content
                    </label>
                    <select
                      name="content"
                      id="content"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                      <option value="">Select Content</option>
                      {contents.map((content) => (
                        <option key={content} value={content}>
                          {content}
                        </option>
                      ))}
                    </select>
                  </div>
                </div>
                <button
                  type="submit"
                  class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                  Filter
                </button>
              </form>

         </div>
        </div>

      
        {{-- Post list --}}
        <div class="bg-white shadow-sm rounded-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Posts List</h2>
                <div class="text-sm text-gray-600">
                    <p>Total posts created today: {{$totalPostsToday}}</p>
                    <p>Total posts: {{$totalPosts}}</p>
                </div>
            </div>
            <form >
                <div class="overflow-x-auto">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Select
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Content
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($posts as $post)
                        <tr >
                          <td class="px-6 py-4 whitespace-nowrap">
                            <input
                              type="checkbox"
                              name="ids[]" 
                              value="{{ $post->id }}"
                              class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                            />
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            <Link href="{{ route('posts.show', $post->id) }}" class="text-indigo-600 hover:text-indigo-900">
                             {{$post->title}}
                            </Link>
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            {{-- limit text --}}
                            {{ \Illuminate\Support\Str::limit($post->content, 20) }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap"></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="mt-4 flex justify-between items-center">
                  <button
                    type="submit"
                    class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                  >
                    Delete Selected
                  </button>
                  <Link
                    href="/posts/create"
                    class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                  >
                    Create Post
                  </Link>
                </div>
              </form>
        </div>

    </div>  
</body>
</html>
