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
      Have you forgotten your password?<br>New password as below:
    </p>
    <table>
      <tr>
        <th style="text-align: left;">Email: </th>
        <td> {{ $email }}</td>
      </tr>
      <tr>
        <th style="text-align: left;">Password: </th>
        <td>{{ $password }}</td>
      </tr>
    </table>
    <br>
    <p>Thanks & Regards!</p>
    <h4 style="text-align: center;">Multi Vendor Shop</h4>
  </div>
</body>
</html>