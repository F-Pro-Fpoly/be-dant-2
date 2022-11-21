<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="text-align: center">
    <h1>TIN SỐT DẺO</h1>
    <h3>Xin chào quý khách</h3>
    <br>
    <h2>{{$post->title}}</h2>
    <p>{{$post->summary}}</p>
    <a href="{{url('/cate/'.$PostEmail->slugCate.'/'.$post->slug)}}.html">Xem ngay</a>
</body>
</html>