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
      Your Vendor Email is confirmed. Please login and add your personal, business  and bank details so that your account will approved.
    </p>
    <p>
      Your Vendor Account Details are as below:
    </p>
    <h5>Name: <span>{{ $name }}</span></h5>
    <h5>Mobile: <span>{{ $mobile }}</span></h5>
    <h5>Email: <span>{{ $email }}</span></h5>
    <h5>Password: <span>****** (as chosen by you)</span></h5>
    <p>Thanks & Regards! &nbsp;<span style="font-weight:bolder;">Multi Vendor Shop</span></p>
  </div>
</body>
</html>