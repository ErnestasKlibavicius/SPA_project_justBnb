<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>JustBnb</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        @vite(['resources/js/app.js', 'resources/scss/app.scss', 'resources/css/app.css'])
    </head>
    <body class="antialiased">
        <div id="app">
            <h1>hello blade </h1>
            <index></index>
        </div>
    </body>
</html>
