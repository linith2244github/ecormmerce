<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>LIKA ONLINE SHOP</h3>
    <h2>Thank you {{ $data['name'] }}</h2>
    <h4>Code verify : <span style="color:rgb(240, 158, 6)">{{ $data['code'] }}</span></h4>
    <p>code Expire in 20 minutes</p>
</body>
</html>