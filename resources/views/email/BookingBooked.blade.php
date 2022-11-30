<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>CẢM ƠN BẠN ĐÃ TIN TƯỞNG VÀ SỬ DỤNG DỊCH VỤ CỦA CHÚNG TÔI</h1>
        <h3>Chào: {{$data->name}},</h3>
        
        <h3>CHI TIẾT THÔNG TIN LỊCH ĐẶT</h3>
        <p>Mã lịch khám: {{$data->code}}</p>
        <p>Ngày đặt lịch: {{$data->ld}}	</p>
            <br>
        <p>Chuyên khoa: {{$data->ck}}</p>
        <p>Ngày khám: {{$data->nk}}</p>
        <p>Thời gian: {{$data->bd}} - {{$data->kt}}</p>
    </div>
</body>
</html>