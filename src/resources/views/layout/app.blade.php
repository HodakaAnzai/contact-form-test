<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面</title>
    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    @yield('css')
</head>

<body>
    <header class="header">
        <h1 class="header_logo">FashionablyLate</h1>
        @yield('logoutbutton')
    </header>

    @yield('content')
</body>

</html>