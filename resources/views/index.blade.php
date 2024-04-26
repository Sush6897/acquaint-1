<!-- employee/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
</head>
<body>

<div class="container">
        <h1>Posts</h1>
        <div class="row">
        <table class="table table-bordered table-responsive">
    <thead>
        <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Author</th>
            <th>Comments Count</th>
            <th>Tags</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->content }}</td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->comments_count }}</td>
                <td>
                    @foreach ($post->tags as $tag)
                        <span class="badge bg-primary">{{ $tag->name }}</span>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
        </div>
    </div>
</body>
</html>
