<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ブログ</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="/">TOP [ブログ一覧]</a></li>
            
            @auth
                <li><a href="/mypage">マイブログ一覧</a></li>
                <li>ようこそ{{ auth()->user()->name }}さん</li>
                <li>
                    <form action="/mypage/logout" method="post">
                    @csrf
                        <input type="submit" value="ログアウト">
                    </form>
                </li>
            @else
                <li><a href="{{ route(('login')) }}">ログイン</a></li>
            @endauth
        </ul>
    </nav>
    @yield('content')
</body>
</html>