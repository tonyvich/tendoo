@inject( 'Page', 'App\Services\Page' )
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $Page::getTitle() }}</title>
    @include( 'partials.shared.header-css' )
    @include( 'partials.shared.header-js' )
    @yield( 'partials.shared.head' )
    <script>
    var tendoo      =   new Object;
    </script>
</head>
<body>