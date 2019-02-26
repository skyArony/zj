@php
  // 部分课程信息获取
  $token = auth('api')->parseToken()->getToken();
  $url = env('APP_URL') . "/api/customCourse/" . request('courseId') . "?token=" . $token;
  $data = json_decode(file_get_contents($url), 1);
  if ($data['errcode'] == 0) {
    $courseName = $data['data']['courseName'];
    $courseTeacher = $data['data']['courseTeacher'];
    $courseDesc = $data['data']['courseDesc'];
    $courseTargetFilter = $data['data']['courseTargetFilter'];
    $courseTree = $data['data']['courseTree'];
  } else {
    echo "数据获取发生了错误!";
  }

  // 填写记录获取
  $uid = auth('api')->parseToken()->payload()->get('sub');
  $SurveyRecord = App\Models\DB\SurveyRecord::where("creater_id", $uid)->where("course_id", request('courseId'))->first();
  $user = App\User::find($uid);
  $time = date("Y-m", $SurveyRecord->created_at->timestamp);
  $tagNeedToStudy = json_decode($SurveyRecord->tags, 1);
  $surveyRecordDetail = json_decode($SurveyRecord->detail, 1);
  $totalScore = $surveyRecordDetail['totalScore'];
  unset($surveyRecordDetail['totalScore']);

  // tag 数据获取
  $tagDataUrl = env('APP_URL') . "/api/tag/detail/" . request('courseId');
  $tagData = json_decode(file_get_contents($tagDataUrl), 1);
  $tagDataArr = [];
  if ($tagData['errcode'] == 0) {
    foreach($tagData['data'] as $key => $value) {
      $tagDataArr[$key] = $value['label'];
    }
  } else {
    $scoreDetail = "数据获取发生了错误!";
  }

  // 一句话课程目标
  $tagNeedToStudyStr = '';
  foreach($tagNeedToStudy as $key => $value) {
    $tagNeedToStudyStr .= $tagDataArr[$value] . "、";
  }
  $tagNeedToStudyStr = substr($tagNeedToStudyStr, 0 , -3);

  // 知识点得分详情
  $scoreDetail = '';
  foreach($surveyRecordDetail as $key => $value) {
    $scoreDetail .= $tagDataArr[$key] . ' ';
    if ($value >= 50) {
      $scoreDetail .= '<font class="green mini">' . $value . '分</font>、';
    } else {
      $scoreDetail .= '<font class="red mini">' . $value . '分</font>、';
    }
  }
  $scoreDetail = substr($scoreDetail, 0 , -3);
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>教育信息化定制课程大纲</title>
  <style>
    .green {
      color: #4caf50;
    }
    .blue {
      color: #2196f3;
    }
    .red {
      color: #f44336;
    }
    .mini {
      font-size: 12px;
    }
    .small {
      font-size: 14px;
    }
  </style>
</head>
<body>
  <xmp theme="united" style="display:none;">
# {{$courseName}}

- 学生: {{$user->name}}

- 教师: {{$courseTeacher}}

- 学年: {{$time}}

- 入学测验得分: <font class="red">{{$totalScore}} 分</font>

<!-- - **教师寄语**

  好好学习,天天向上 -->

- **课程知识点及得分**

@foreach ($surveyRecordDetail as $key => $value)
  {{$tagDataArr[$key] . " "}} @if ($value >= 50) <font class="green mini">{{$value}}分</font>；
  @else
    <font class="red mini">{{$value}}分</font>；
  @endif
@endforeach

- **课程简介**

  {{$courseDesc}}

## 一、课程目标

@if (count($tagNeedToStudy) == 0)

**课程知识点都通过了测验，没有可供学习的课程。**

@else

掌握 **{{$tagNeedToStudyStr}}** 等知识点。

@foreach ($courseTargetFilter as $chapter)

### {{$chapter['label']}}

@foreach ($chapter['children'] as $period)

- {{$period['label']}}
  @foreach ($period['children'] as $target)
  - {{$target}}
  @endforeach

@endforeach

@endforeach

@endif



## 二、课程目录

**蓝色字体:** 该课时的知识点

**绿色字体:** 经入学测试题测验需要学习的知识点

**黑色字体:** 经入学测试题测验已经掌握的知识点, 不计入学习计划


@if (count($tagNeedToStudy) == 0)

**课程知识点都通过了测验，没有可供学习的课程。**

@else

@foreach ($courseTree as $chapter)

### {{$chapter['chapter_name']}}

@foreach ($chapter as $key => $period)

@if (is_integer($key) && $period['status'] == true)
- <font class="green">{{$period['period_title']}}</font> @if (isset($period['tags']))
  @foreach ($period['tags'] as $tag)
  <font class="blue mini">{{$tag}}</font>
  @endforeach
@endif

@elseif (is_integer($key) && $period['status'] == false)
- {{$period['period_title']}} @if (isset($period['tags']))
  @foreach ($period['tags'] as $tag)
  <font class="blue mini">{{$tag}}</font>
  @endforeach
@endif

@endif

@endforeach

@endforeach

@endif

  </xmp>
  <!-- VUE -->
  <script src="{{ mix('js/app.js') }}"></script>
  <!-- MARKDOWN -->
  <script src="/js/strapdown/strapdown.js" ></script>
  <script>
    alert("使用快捷键『Ctrl + P』, 点击『更改』, 设置为『另存为 PDF』保存即可。")
  </script>
</body>
</html>