<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            box-sizing: border-box;
            width: 100%;
            height: 100%;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        h1 {
            font-size: 1.2em;
            margin: 0;
        }
        p {
            font-size: 0.9em;
            margin: 5px 0 0;
        }
    </style>
</head>
<body>
    <a href="%%CLICK_URL%%" target="_blank">
        <h1>{{ $title }}</h1>
        <p>{{ $description }}</p>
    </a>
</body>
</html>
