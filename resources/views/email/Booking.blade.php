<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>HÔM NAY BẠN CÓ LỊCH KHÁM</h1>
    <h3>Chào: {{$booking->name}}</h3>
    <p>Hôm nay bạn có một lịch khám vào lúc  {{$booking->time_start}} {{$booking->interval == "M" ? "Sáng" : "Chiều" }} </p>
    <p>Xin mời bạn đến đúng giờ để có thể thăm khám đúng thời gian</p>
    <p>Chân thành cảm ơn</p>
    <span><i>Đường dẫn đến chi tiết lịch khám: <a href="http://localhost:3000/ho-so-ca-nhan/chi-tiet-lich-dat/{{$booking->id}}">Nhấn vào đây</a></i></span>
</body>
</html>