{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <h1>Oops! Something went wrong...</h1>

    <p> 請先建立入雛表的資料!</p>

    <a href="{{ url()->previous() }}">回上一頁</a>


    <div class="error-container">
        <h1 class="error-heading">Error</h1>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>
    </div>
</body>

</html> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Error</title>
    <style>
        body {
            /* background-image: url("https://picsum.photos/1920/1080"); */
            background-color: #353740;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .error-container {
            width: 400px;
            height: 200px;
            /* background-color: rgba(0, 0, 0, 0.7); */
            background-color: #6e6e80;
            margin: auto;
            margin-top: 200px;
            text-align: center;
            border-radius: 10px;
            padding: 20px;
        }

        h1 {
            font-size: 30px;
            margin-bottom: 30px;
        }

        p {
            font-size: 20px;
            margin-bottom: 20px;
        }

        a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <h1>Oops! Something went wrong.</h1>
        <p>We're sorry, but an error has occurred. Please try again later.</p>
        <p>Error code: 請先建立入雛表的資料！</p>
        <a href="/">回首頁</a> <a href="{{ url()->previous() }}">回上一頁</a>

    </div>
</body>

</html>
