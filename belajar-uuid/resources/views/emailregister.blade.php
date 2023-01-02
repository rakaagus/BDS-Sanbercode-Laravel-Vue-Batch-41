<!doctype html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  </head>
  <body style="font-family: sans-serif;">
    <div style="display: block; margin: auto; max-width: 600px;" class="main">
      <h1 style="font-size: 18px; font-weight: bold; margin-top: 20px">Selamat Bapak/ibu {{ $name }} Email Berhasil Diregister</h1>
      <small>Silahkan Gunakan otp code dibawah batas kadaluarsanya 5 menit dari sekarang</small>
      <p style="text-align: center; background-color: yellow; font-weight: bold">{{ $otp }}</p>
    </div>
    <!-- Example of invalid for email html/css, will be detected by Mailtrap: -->
    <style>
      .main { background-color: white; }
      a:hover { border-left-width: 1em; min-height: 2em; }
    </style>
  </body>
</html>
