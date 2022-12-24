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
            border-style: solid;
            border-width: thin;
            border-color: #dadce0;
            border-radius: 8px;
            padding: 20px 20px;
            text-align: center;
            width: 450px;
            font-family: 'Google Sans', Roboto, RobotoDraft, Helvetica, Arial, sans-serif;
        }

        div.mail hr {
            border-top: 1px solid #ccc;
        }

        div.mail p {
            font-family: Roboto-Regular, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: rgba(0, 0, 0, 0.87);
            line-height: 20px;
        }
    </style>
</head>

<body>
    <div class="mail">
        <h3>CẢM ƠN BẠN ĐÃ TIN TƯỞNG VÀ SỬ DỤNG DỊCH VỤ CỦA CHÚNG TÔI</h3>
        <hr>
        <h3>Chào: {{$data->name}}</h3>
        <h3>CHI TIẾT THÔNG TIN LỊCH ĐẶT</h3>
        <p>Mã lịch khám: {{$data->code}}</p>
        <p>Ngày đặt lịch: {{$data->ld}} </p>
        <br>
        <p>Chuyên khoa: {{$data->ck}}</p>
        <p>Ngày khám: {{$data->nk}}</p>
        <p>Thời gian: {{$data->bd}} - {{$data->kt}}</p>
    </div>
</body>

</html>