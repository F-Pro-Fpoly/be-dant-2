<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$dataNews->name}}</title>
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
        div.mail a {
            font-family: Roboto-Regular, Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: rgba(146, 72, 232, 0.87);
            line-height: 20px;
        }
    </style>
</head>
<body style="text-align: center">
    <div class="mail">
    <h3>{{$dataNews->name}}</h3>
    <p></p>
    <a href="fpro.newweb.vn/tin-tuc">Xem ngay</a>
    </div>
</body>
</html>