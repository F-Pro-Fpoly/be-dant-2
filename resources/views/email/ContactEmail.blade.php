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
   
                    <div class="mail" >
                    <div style="font-size:24px; font-weight:400"> PHẢN HỒI TIN LIÊN HỆ</div>
                    <h3>Chào: {{$contact->name}}</h3>
                    <hr>
                    <p>Cảm ơn bạn đã liên với chúng tôi với nội dung: </p>
                    <p>{{$contact->contents}}</p>
                    <br>
                    <b>Chúng tôi xin thông tin đến quý khách: </b>
                    <p>{{$contact->reply_contact}}</p>
                    </div>
 

</body>
</html>