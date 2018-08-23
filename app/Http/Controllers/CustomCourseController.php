<?php

namespace App\Http\Controllers;

require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');

use TCPDF;
use TCPDF_FONTS;
use Illuminate\Http\Request;
use App\Models\DB\AnswerRecord;
use App\Models\DB\Survey;
use App\Models\DB\Course;

class CustomCourseController extends ApiController
{
    // 创建一个 PDF
    public function getPDF(Request $request)
    {
        // TODO validate

        $response = $this->getCustomCourse($request);
        $data = json_decode($response->getContent());
        $surveyName = $data->data->surveyName;
        $courseName = $data->data->courseName;
        $courseTeacher = $data->data->courseTeacher;
        $courseTree = $this->treeData($data->data->courseTreeTags);
        $courseTarget = $this->targetData($data->data->courseTreeTags);

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        // 基础信息
        $pdf->SetCreator('skyArony');
        $pdf->SetAuthor('skyArony');
        $pdf->SetTitle($courseName . "-" . $surveyName);
        $pdf->SetSubject('教育信息化定制课程系统');
        $pdf->SetKeywords('教育信息化, 课程定制, 问卷');
        // 字体设置
        TCPDF_FONTS::addTTFfont(storage_path('app/other/droidsansfallback.ttf'), 'TrueTypeUnicode', '', 32);
        $pdf->AddFont('droidsansfallback', '', 'droidsansfallback.php');
        $pdf->SetFont('droidsansfallback', '', 12);
        // 设置页边距
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // 页眉
        $pdf->setHeaderFont(array('droidsansfallback', '', 10));
        $pdf->SetHeaderData('', 0, "教育信息化定制课程系统", "$courseTeacher | $surveyName");
        // 页设置
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        // 添加一页
        $pdf->AddPage();
        $pdf->setCellHeightRatio(1.5);

        // 设置数据
        $html = '
<style>
h1 {
    text-align: center;
    font-size: 18pt;
}
h2 {
    font-size: 16pt;
}
p {
    font-size: 14pt;
}
</style>
<h1>' . $courseName . '</h1 >
<h2>一、课程目标</h2><ul>';

        foreach ($courseTarget as $key => $value) {
            $html .= "<li>" . $value['label'] . "<ul>";
            foreach ($value['children'] as $key2 => $value2) {
                $html .= "<li>" . $value2['label'] . "<ul>";
                foreach ($value2['children'] as $key3 => $value3) {
                    $html .= "<li>" . $value3 . "</li>";
                }
                $html .= "</ul></li>";
            }
            $html .= "</ul></li>";
        }
        $html .= "</ul>";

        $html .= '<h2>二、课程目录</h2><ul>';
        foreach ($courseTree as $key => $value) {
            $html .= "<li>" . $value['label'] . "<ul>";
            foreach ($value['children'] as $key2 => $value2) {
                $html .= "<li>" . $value2['label'] . "</li>";
            }
            $html .= "</ul></li>";
        }
        $html .= "</ul>";
        
        $pdf->writeHTML($html, true, false, true, false, '');

        // 输出
        $pdf->Output($courseName."-定制化课程大纲", 'I');
    }

    // 获取一个定制化课程信息
    public function getCustomCourse(Request $request)
    {
        // TODO validate

        $answerRecord = AnswerRecord::find($request->id);
        $survey = $answerRecord->belongsToSurvey;
        $course = $survey->belongsToCourse;
        $courseTree = $course->hasOneCourseTree;
        $user = $course->belongsToUser;

        // coursetag 和 问卷标记的 tag
        $courseTreeTags = json_decode($courseTree->data, 1);
        $answerRecordTags = json_decode($answerRecord->tags, 1);

        // 需要选择性展示的 tree 和 target 处理
        foreach ($courseTreeTags as $key => $value) {
            foreach ($value as $key2 => $value2) {
                if ($key2 == 'chapter_name') {
                    continue;
                }
                if (isset($value2['tags'])) {
                    if (array_intersect($value2['tags'], $answerRecordTags)) {
                        $courseTreeTags[$key][$key2]["status"] = true;
                        $courseTreeTags[$key]["status"] = true;
                    } else {
                        $courseTreeTags[$key][$key2]["status"] = false;
                        $courseTreeTags[$key]["status"] = false;
                    }
                } else {
                    $courseTreeTags[$key][$key2]["status"] = false;
                    $courseTreeTags[$key]["status"] = false;
                }
            }
        }

        // 课程信息
        $courseName = $course->name;
        $courseDesc = $course->intro;
        $courseImg = $course->pic;
        $courseTeacher = $user->name;
        $courseId = $course->id;
        // 问卷信息
        $surveyName = $survey->title;

        $data = [
            'courseId' => $courseId,
            'courseName' => $courseName,
            'courseDesc' => $courseDesc,
            'courseImg' => $courseImg,
            'courseTeacher' => $courseTeacher,
            'surveyName' => $surveyName,
            'answerRecordTags' => $answerRecordTags,
            'courseTreeTags' => $courseTreeTags,
        ];

        return self::setResponse($data, 200, 0);
    }

    //  计算课程树
    protected function treeData($data)
    {
        $res = [];
        foreach ($data as $key => $value) {
            if ($value->status) {
                $children = [];
                foreach ($value as $key2 => $value2) {
                    if ($key2 != "chapter_name" && $key2 != "status") {
                        if ($value2->status) {
                            $obj2 = [
                                "id" => $key2,
                                "label" => $value2->period_title
                            ];
                            $children[] = $obj2;
                        }
                    }
                }
                $res[] = [
                    "id" => $key,
                    "label" => $value->chapter_name,
                    "children" => $children
                ];
            }
        }
        return $res;
    }

    //  计算课程目标
    protected function targetData($data)
    {
        $res = [];
        foreach ($data as $key => $value) {
            if ($value->status) {
                $children = [];
                foreach ($value as $key2 => $value2) {
                    if ($key2 != "chapter_name" && $key2 != "status") {
                        if ($value2->status) {
                            $obj2 = [
                                "id" => $key2,
                                "label" => $value2->period_title,
                                "children" => $value2->claims
                            ];
                            $children[] = $obj2;
                        }
                    }
                }
                $res[] = [
                    "id" => $key,
                    "label" => $value->chapter_name,
                    "children" => $children
                ];
            }
        }
        return $res;
    }
}
