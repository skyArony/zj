<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <style>
    html,body {
      width: 100%;
      height: 100%;
      margin: 0px;
    }
    body {
      background-image: url("/storage/img/bg2018.png");
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
  <title>教育信息化-问卷</title>
</head>
<body>
  <div id="app" style="width:100%;height:100%;">
    <worlduc-autosurvey></worlduc-autosurvey>
  </div>
  <!-- QRCODE -->
  <script src="/js/qrcode.min.js" ></script>
  <!-- VUE -->
  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>