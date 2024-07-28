<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Layer GeoServer</title>
</head>
<body>
    <h1>Daftar Layer GeoServer</h1>
    <ul>
        @foreach($layers as $layer)
            <li>{{ $layer['name'] }} - {{ $layer['title'] }}</li>
        @endforeach
    </ul>
</body>
</html>
