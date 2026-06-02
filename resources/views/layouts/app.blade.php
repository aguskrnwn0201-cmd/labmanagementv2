<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Management Lab</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<nav style="padding:10px;border-bottom:1px solid #ccc;">
    <a href="/">Home</a>
</nav>

<div style="padding:20px;">
    @yield('content')
</div>

</body>
</html>