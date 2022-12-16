<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hồ sơ bệnh án</title>
    <style>
        body{
            font-family: DejaVu Sans;
            font-size: 14px;
        }
        *{
            margin: 0;
            padding: 5px;
        }
        .medical{
            /* float: left; */
            min-height: 700px;
            /* padding-top: 150px; */
            /* display: flex; */
            margin-top: 20px;
        }
        .medical-left{
            /* flex: 0 0 30%; */
            /* width: 30%; */
            /* height: 700px; */
            background: #4990E2;
            /* display: inline-block; */
            padding-left: 30px;
            padding-top: 20px;  
            color: #fff;
            margin-bottom: 30px;
        }
        .medical-right{
            /* flex: 0 0 70%; */
            /* display: inline-block; */
            /* width: 63%; */
            height: 700px;
            transform: translateY(-15px);
        }
        .medical-avatar{
            
            /* margin: 0 auto; */
            margin-bottom: 10px;
        }
        .medical-avatar>img{
            width: 100px;
            height: auto;
            object-fit: cover;
        }
        .text-color-blue{
            color: #45A4E4;
        }
        .medical-title{
            margin-bottom: 20px;
        }
        .medical-content{
            margin: 10px 0;
            
        }

        .medical-content-title{
            margin-bottom: 5px;
        }
        .medical-content-item{
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="medical">
        <div class="medical-left">
            <div class="medical-avatar">
                <img src="{{strstr($user->avatar, "http") != false  ? $user->avatar :(env('APP_URL').$user->avatar)}}" alt="">
            </div>

            <div class="mediacal-left-content">
                <p>
                    <b>Họ tên: </b>
                    <span>{{$user->name}}</span>
                </p>
                <p>
                    <b>Ngày sinh: </b>
                    <span>{{$user->birthday ?? ''}}</span>
                </p>
                <p>
                    <b>Địa chỉ: </b>
                    <span>
                        {{$user->address ?? ''}}
                        {{$user->ward->full_name ? ", ".$user->ward->full_name: ''}}
                        {{$user->district->full_name ? ", ".$user->district->full_name: ''}}
                        {{ $user->city->full_name ? ", ".$user->city->full_name: ''}}
                    </span>
                </p>
                <p>
                    <b>Số điện thoại: </b>
                    <span>{{$user->phone ?? ''}}</span>
                </p>
            </div>
        </div>
        <div class="medical-right">
            <h2 class="text-color-blue medical-title">HỒ SƠ BỆNH ÁN</h2>
            <h3 class="text-color-blue">
                Lịch sử khám   
            </h3>

            @foreach ($bookings as $booking)    
                <div class="medical-content">
                    <h4 class="medical-content-title">{{$booking->code}}</h4>
                    <div class="medical-content-item">
                        <span>Tên chuyên khoa: {{$booking->specialist->name ?? ''}}</span><br>
                        <span>Trạng thái thanh toán: {{$booking->payment_method == 'default' ? 'Thanh toán tại cơ sở y tế' : 'Thanh toán qua online'}}</span> <br>
                        <span>Thông tin từ bệnh nhân: {{$booking->description ?? ''}}</span><br>
                        <span>Trạng thái: {{$booking->status->name ?? ''}}</span><br>
                        <span>Thông tin sau khám: {{$booking->infoAfterExamination ?? ''}}</span>
                    </div>
                </div>
            @endforeach

            <h3 class="text-color-blue">
                Lịch sử tiêm  
            </h3>
            @foreach ($booking_vaccines as $booking_vaccine)    
                <div class="medical-content">
                    <h4 class="medical-content-title">{{$booking_vaccine->vaccine->name ?? ''}}</h4>
                    <div class="medical-content-item">
                        @php
                            $injection_infos = $booking_vaccine->Injection_info ?? null;
                        @endphp
                        @if($injection_infos)
                            @foreach ($injection_infos as $injection_info)    
                                <div class="medical-vaccine">
                                    <h5>{{$injection_info->type_name ?? ''}}</h5>
                                    <span>Ngày khám: {{date_format(date_create($injection_info->time_apointment), "d/m/Y")}}</span><br>
                                    <span>Kết quả: {{$injection_info->description ?? ''}}</span><br>
                                    <span>Trạng thái: {{$injection_info->status->name ?? ''}}</span>
                                </div>
                            @endforeach
                        @endif
                        {{-- <div class="medical-vaccine">
                            <h5>Mũi 1</h5>
                            <span>Ngày khám: 2022-12-06</span><br>
                            <span>Kết quả: Không đủ điều kiện tiêm chủng</span><br>
                            <span>Trạng thái: Hủy</span>
                        </div>
                        <div class="medical-vaccine">
                            <h5>Mũi 2</h5>
                            <span>Ngày khám: 2022-12-06</span><br>
                            <span>Kết quả: Không đủ điều kiện tiêm chủng</span><br>
                            <span>Trạng thái: Hủy</span>
                        </div> --}}
                    </div>
                </div>
            @endforeach

            {{-- <div class="medical-content">
                <h4 class="medical-content-title">VẮC XIN 6 TRONG 1 HEXAXIM (6IN1)</h4>
                <div class="medical-content-item">
                    <div class="medical-vaccine">
                        <h5>Khám sàn lọc</h5>
                        <span>Ngày khám: 2022-12-06</span><br>
                        <span>Kết quả: Không đủ điều kiện tiêm chủng</span><br>
                        <span>Trạng thái: Hủy</span>
                    </div>
                    <div class="medical-vaccine">
                        <h5>Mũi 1</h5>
                        <span>Ngày khám: 2022-12-06</span><br>
                        <span>Kết quả: Không đủ điều kiện tiêm chủng</span><br>
                        <span>Trạng thái: Hủy</span>
                    </div>
                    <div class="medical-vaccine">
                        <h5>Mũi 2</h5>
                        <span>Ngày khám: 2022-12-06</span><br>
                        <span>Kết quả: Không đủ điều kiện tiêm chủng</span><br>
                        <span>Trạng thái: Hủy</span>
                    </div>
                </div>
            </div> --}}
            
        </div>
    </div>
</body>
</html>