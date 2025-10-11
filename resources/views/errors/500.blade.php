<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Something Went Wrong</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        h1 { font-size: 50px; }
        p { font-size: 20px; }
    </style>
</head>
<body>
    <h1>Oops!</h1>
    <p>Something went wrong. Please try again later.</p>
    @if(env('APP_DEBUG'))
        <p>{{ $exception->getMessage() }}</p>
    @endif
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
</body>
</html>
