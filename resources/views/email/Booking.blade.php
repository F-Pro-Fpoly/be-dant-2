<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <style>
        div.mail {
            margin-left: 25%;
            border-style:solid;
            border-width:thin;
            border-color:#dadce0;
            border-radius:8px;
            padding:20px 20px;
            text-align:center;
            width:450px;
            font-family: 'Google Sans',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;
         }
         div.mail hr{
            border-top: 1px solid #ccc;
        }
       
        div.mail p {
            font-family:Roboto-Regular,Helvetica,Arial,sans-serif;
            font-size:14px;
            color:rgba(0,0,0,0.87);
            line-height:20px;
        }      
    </style>
</head>
<body>
    <div class="mail">
    <h3>HÔM NAY BẠN CÓ LỊCH KHÁM</h3>
    <hr>
    <h3>Chào: {{$booking->name}}</h3>
    <p>Hôm nay bạn có một lịch khám vào lúc  {{$booking->time_start}} {{$booking->interval == "M" ? "Sáng" : "Chiều" }} </p>
    <p>Xin mời bạn đến đúng giờ để có thể thăm khám đúng thời gian</p>
    <p>Chân thành cảm ơn</p>
    <span><i>Đường dẫn đến chi tiết lịch khám: <a href="http://localhost:3000/ho-so-ca-nhan/chi-tiet-lich-dat/{{$booking->id}}">Nhấn vào đây</a></i></span>
</div>
</body>
</html>