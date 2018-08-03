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
  </style>
  <title>课程视频</title>
</head>
<body>
  <div id="app" style="width:100%;height:100%;background-color: #f6f9fa;">
    <worlduc-video></worlduc-video>
  </div>
  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>