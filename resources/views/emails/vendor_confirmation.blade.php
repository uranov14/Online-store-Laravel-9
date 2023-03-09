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
      Please click on below link to confirm your Vendor Account:
    </p>
    <a href="{{ url('vendor/confirm/'.$code) }}">
      {{ url('vendor/confirm/'.$code) }}
    </a>
    <p>Thanks & Regards! &nbsp;<span style="font-weight:bolder;">Multi Vendor Shop</span></p>
  </div>
</body>
</html>