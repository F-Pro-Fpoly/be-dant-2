<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>PHẢN HỒI TIN LIÊN HỆ</h1>
    <h3>Chào: {{$contact->name}}</h3>
    <p>Cảm ơn bạn đã liên với chúng tôi với nội dung: </p>
    <p>{{$contact->contents}}</p>
    <br>
    <b>Chúng tôi xin thông tin đến quý khách: </b>
    <p>{{$contact->reply_contact}}</p>
</body>
</html>