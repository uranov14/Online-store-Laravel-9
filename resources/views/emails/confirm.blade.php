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
    <h2>Dear {{ $name }}!</h2>
    <p>
      Please click on below link to activate your Account:
    </p>
    <a href="{{ url('user/confirm/'.$code) }}">Confirm Account</a>
    <p>Thanks & Regards!</p>
    <h4 style="text-align: center;">Multi Vendor Shop</h4>
  </div>
</body>
</html>