<template>
  <div class="container">
    <div class="main">
      <div class="header">
        <div id="qrcodeIcon"
             @click="showQRcode"></div>
        <div id="copyShareText"
             :data-clipboard-text="shareText"
             @click="copyText"></div>
        <el-card v-show="qrcodeVisible"
                 id="shareCard"
                 :body-style="{ padding: '0px' }">
          <div id="qrcode"
               ref="qrcode"></div>
          <div style="padding-top: 15px;">
            <el-input id="shareText"
                      type="textarea"
                      :rows="3"
                      size="mini"
                      v-model="shareText">
            </el-input>
            <div class="bottom clearfix">
              <el-button :data-clipboard-text="shareText"
                         type="primary"
                         size="mini"
                         id="copyQRText"
                         class="button"
                         @click="copyText">复制</el-button>
            </div>
          </div>
        </el-card>
        <img src="/storage/img/header.jpg" />
        <div class="header-content">
          <div class="title">{{title}}</div>
          <div class="desc">{{desc}}</div>
        </div>
      </div>
      <div class="body">
        <div v-if="!isComplete"
             class="questions">
          <worlduc-question v-for="item in surveyQuesList"
                            :key="item.id"
                            :question="item"
                            @setAnswer="setAnswerData"></worlduc-question>
          <el-button type="primary"
                     plain
                     @click="submit"
                     :disabled="isOpen"
                     class="submit">提交</el-button>
        </div>
        <div v-else
             class="complete">
          <img src="/storage/img/complete.svg">
          <h2>填写完成!</h2>
          <div>
            <el-button type="info"
                       icon="el-icon-refresh"
                       round
                       @click="again">我想重做一次</el-button>
            <el-button type="success"
                       icon="el-icon-view"
                       round
                       @click="view">查看定制课程</el-button>
          </div>
        </div>
      </div>
      <div class="footer">教学定制化问卷系统 -
        <el-tooltip effect="dark"
                    content="QQ: 1450872874"
                    placement="bottom">
          <font>skyArony</font>
        </el-tooltip>
      </div>
    </div>
  </div>
</template>

<script>
import Clipboard from "clipboard/dist/clipboard"

export default {
  data() {
    return {
      MyAxios: axios.create({
        headers: { "Content-Type": "application/json" }
      }),
      isOpen: true, // 是否开放提交
      courseId: "", // 课程 ID
      courseName: '', // 课程名
      // courseTeacher: '', // 课程教师
      questionList: [], // 当前课程所有问题
      surveyQuesList: [], // 显示在页面上的问卷题
      isComplete: false, // 是否填写完问卷
      qrcodeVisible: false, // 是否显示二维码分享框
      desc: "填写问卷,定制课程大纲",   // 问卷简介
    }
  },
  computed: {
    // 分享文字内容
    shareText: function() {
      return "填写问卷,定制化『" + this.courseName + "』课程大纲.";
    },
    // 问卷标题
    title: function() {
      return this.courseName + "课程问卷"
    }
  },
  methods: {
    // 问题的填写状态结果
    setAnswerData(data) {
      this.surveyQuesList[data.id].status = data.status
    },
    // 提交
    submit() {
      // 检查填写状态
      for (let key in this.surveyQuesList) {
        if (this.surveyQuesList[key].status == null) {
          this.$notify({
              title: "提示",
              message: "存在题目没选择答案!",
              type: "info",
              duration: "2000",
              position: "top-left"
          })
          return
        }
      }
      // 检查得分状态
      let score = {}
      for(let key in this.surveyQuesList) {
        if (this.surveyQuesList[key].status == true) {
          if (!score.hasOwnProperty(this.surveyQuesList[key].tag_id)) score[this.surveyQuesList[key].tag_id] = 0
          score[this.surveyQuesList[key].tag_id] += parseInt(this.surveyQuesList[key].level)
        }
      }
      let res = []
      for(let key in score) {
        if (score[key] < 5) res.push(key) // 阈值设置为 0.5
      }
      // 发送结果到后台
      let that = this
      this.MyAxios.post("/api/surveyRecord/" + this.courseId, {
        tags: res
      })
        .then(function(response) {
          that.isComplete = true
        })
        .catch(function(error) {
          if (error.response.data.errcode == -4007) alert("请先登录!")
          else alert(error.response.data.errmsg)
        })
    },
    // 重新做
    again() {
      this.isComplete = false
      for (let key in this.surveyQuesList) {
        this.surveyQuesList[key].status = null
      }
    },
    // 查看定制课程
    view() {
      location.href = "/#/index/customCourse/" + this.courseId
    },
    // 复制分享文字内容
    copyText() {
      var clipboard = new Clipboard("#copyQRText")
      var clipboard = new Clipboard("#copyShareText")
      this.$notify({
        title: "成功",
        message: "成功复制到剪切板!",
        type: "success",
        position: "top-left"
      })
    },
    // 显示二维码分享框
    showQRcode() {
      this.qrcodeVisible = !this.qrcodeVisible
      if (this.$refs.qrcode.childNodes.length == 0) {
        let qrcode = new QRCode("qrcode", {
          width: 200,
          height: 200
        })
        qrcode.makeCode(window.location.href)
      }
    },
    // 生成随机问卷
    generateSurvey() {
      let surveyQuesList = {}
      let quesTypeList = [
        [1, 2, 3, 4],
        [5, 2, 3],
        [5, 4, 1]
      ]
      for (let key in this.questionList) {
        let quesType = quesTypeList[Math.round(Math.random() * 10) % 3]
        for (let index in quesType) {
          let questions = this.questionList[key][quesType[index]]
          let question = questions[Math.round(Math.random() * 10) % questions.length]
          surveyQuesList[question.id] = question
        }
      }
      this.surveyQuesList = surveyQuesList
    },
    // 检查当前课程题库数目是否符合要求,对题目进行处理
    isMeetRequirement() {
      let quesCount = {}
      let questionList = {}
      let isOk = false
      // 检查数目是否符合湖基本要求
      for (let key in this.questionList) {
        if (quesCount.hasOwnProperty(this.questionList[key].tag_id)) {
          quesCount[this.questionList[key].tag_id] += 1
        } else quesCount[this.questionList[key].tag_id] = 1
      }
      for (let key in quesCount) {
        if (quesCount[key] >= 5) isOk = true
      }
      // 数据格式再处理
      for (let key in this.questionList) {
        let tagId = this.questionList[key].tag_id
        let level = this.questionList[key].level
        if (quesCount[tagId] >= 5) {
          if (!questionList.hasOwnProperty(tagId)) questionList[tagId] = {}
          if (!questionList[tagId].hasOwnProperty(level)) questionList[tagId][level] = []
          this.questionList[key].status = null
          questionList[tagId][level].push(this.questionList[key])
        }
      }
      // 难度分区
      this.questionList = questionList
      return isOk
    },
    // 获取课程 Id 和课程名
    getCourseId() {
      this.courseId = window.location.href.match(/.*?\/autosurvey#?\/(\d+)?/)[1]
      if (!this.courseId) location.href = "/404"
      // 获取课程信息
      let that = this
      this.MyAxios.get("/api/course/" + this.courseId)
        .then(function(response) {
          that.courseName = response.data.data.name
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    // 检查是否填写过问卷
    isFilled() {
      let that = this
      this.MyAxios.get("/api/surveyRecord/check/" + this.courseId)
        .then(function(response) {
          if (response.data.data) {
            that.$notify({
              title: "提示",
              message: "你填写过本问卷,再次填写将覆盖之前记录!",
              type: "info",
              duration: "4000",
              position: "top-left"
            })
          }
        })
        .catch(function(error) {
          if (error.response.data.errcode == -4007) {
            that.$notify({
              title: "提示",
              dangerouslyUseHTMLString: true,
              message:
                "你当前没有登录,请 <a href='/admin/login?redirectUrl=" +
                window.location.href +
                "'>登录</a> 后再填写,否则可能无法保存!",
              type: "info",
              duration: "6000",
              position: "top-left"
            })
          } else alert(error.response.data.errmsg)
        })
    },
    // 获取课程题库数据
    getCourseQusetion() {
      let that = this
      this.MyAxios.get("/api/question/" + this.courseId)
        .then(function(response) {
          that.questionList = response.data.data
          // 检查题库题目数是否符合要求
          let isMeet = that.isMeetRequirement()
          // 自动组卷
          if (!isMeet) {
            that.$notify({
              title: "提示",
              message: "题库题数不符合最低要求,请课程教师添加.",
              type: "info",
              duration: "0",
              position: "top-left"
            })
          } else {
            that.isOpen = false
            // 生成问卷
            that.generateSurvey()
          }
        })
        .catch(function(error) {
          if (error.response.status == 404) location.href = "/404"
          else alert(error.response.data.errmsg)
        })
    },
    init() {
      // 获取课程 ID,不存在则跳转404
      this.getCourseId()
      // 检查是否填写过问卷
      this.isFilled()
      // 获取当前课程的所有数据并自动组卷
      this.getCourseQusetion()
    }
  },
  mounted: function() {
    // 获取问卷数据,检查是否填写过问卷
    this.init()
  }
}
</script>

<style scoped>
#qrcodeIcon {
  position: absolute;
  right: -40px;
  top: 3px;
  width: 32px;
  height: 32px;
  background-image: url("/storage/img/qrcode.png");
}
#qrcodeIcon:hover {
  background-image: url("/storage/img/qrcode-h.png");
}
#shareCard {
  width: 200px;
  position: absolute;
  right: -230px;
  top: 43px;
  padding: 10px;
}
#qrcode {
  width: 100%;
}
.bottom {
  margin-top: 10px;
  display: flex;
  justify-content: center;
}
.container {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  overflow-y: auto;
}
.submit {
  margin-top: 30px;
  width: 15rem;
  margin-left: auto;
  margin-right: auto;
}
.title {
  font-size: 40px;
  font-weight: 700;
  margin-top: 12%;
}
.desc {
  margin-top: 3%;
}
.questions {
  display: flex;
  flex-direction: column;
  padding-top: 10px;
}
.complete {
  padding-top: 30px;
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #616161;
}

@media screen and (min-width: 1025px) {
  .main {
    width: 50%;
    margin-top: 60px;
  }
  .header {
    width: 100%;
    position: relative;
    margin-bottom: 8px;
  }
  .header img {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
      0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
  }
  .header::before {
    position: absolute;
    content: "";
    z-index: 1;
    width: 100%;
    height: 99.1%;
    background-color: #0000001a;
    border-radius: 12px;
  }
  .header-content {
    position: absolute;
    width: 100%;
    top: 0;
    text-align: center;
    color: white;
    z-index: 2;
  }
  .body {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
      0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
    background-color: white;
    padding-bottom: 30px;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
  }
  .question:first-child {
    border-radius: 12px;
  }
  .footer {
    width: 100%;
    height: 150px;
    text-align: center;
    padding: 60px;
    box-sizing: border-box;
    color: #e0e0e0;
  }
}

@media screen and (max-width: 1024px) and (min-width: 841px) {
  #shareCard {
    width: 200px;
    position: absolute;
    right: -120px;
    top: 43px;
    padding: 10px;
  }
  .main {
    width: 70%;
    margin-top: 60px;
  }
  .header {
    width: 100%;
    position: relative;
    margin-bottom: 8px;
  }
  .header img {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
      0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
  }
  .header::before {
    position: absolute;
    content: "";
    z-index: 1;
    width: 100%;
    height: 99.1%;
    background-color: #0000001a;
    border-radius: 12px;
  }
  .header-content {
    position: absolute;
    width: 100%;
    top: 0;
    text-align: center;
    color: white;
    z-index: 2;
  }
  .body {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
      0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
    background-color: white;
    padding-bottom: 30px;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
  }
  .question:first-child {
    border-radius: 12px;
  }
  .footer {
    width: 100%;
    height: 120px;
    text-align: center;
    padding: 50px;
    box-sizing: border-box;
    color: #e0e0e0;
  }
}

@media screen and (max-width: 840px) and (min-width: 481px) {
  #shareCard {
    /* display: none; */
  }
  #qrcodeIcon {
    /* display: none; */
    position: absolute;
    right: -40px;
    top: 3px;
    width: 32px;
    height: 32px;
    background-image: url("/storage/img/qrcode.png");
  }
  .main {
    width: 80%;
    margin-top: 60px;
  }
  .header {
    width: 100%;
    position: relative;
    margin-bottom: 8px;
  }
  .header img {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
      0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
  }
  .header::before {
    position: absolute;
    content: "";
    z-index: 1;
    width: 100%;
    height: 99.1%;
    background-color: #0000001a;
    border-radius: 12px;
  }
  .header-content {
    position: absolute;
    width: 100%;
    top: 0;
    text-align: center;
    color: white;
    z-index: 2;
  }
  .body {
    width: 100%;
    border-radius: 12px;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
      0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
    background-color: white;
    padding-bottom: 30px;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
  }
  .question:first-child {
    border-radius: 12px;
  }
  .footer {
    width: 100%;
    height: 100px;
    text-align: center;
    padding: 40px;
    box-sizing: border-box;
    color: #e0e0e0;
  }
}

@media screen and (max-width: 480px) {
  #copyShareText {
    position: absolute;
    right: 10px;
    top: 10px;
    width: 32px;
    height: 32px;
    z-index: 3;
    background-image: url("/storage/img/share.png");
  }
  #copyShareText:hover {
    background-image: url("/storage/img/share-h.png");
  }
  #qrcodeIcon {
    display: none;
    position: absolute;
    right: -40px;
    top: 3px;
    width: 32px;
    height: 32px;
    background-image: url("/storage/img/qrcode.png");
  }
  .main {
    width: 100%;
  }
  .header {
    width: 100%;
    position: relative;
  }
  .header img {
    width: 100%;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
      0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
  }
  .header::before {
    position: absolute;
    content: "";
    z-index: 1;
    width: 100%;
    height: 99.1%;
    background-color: #0000001a;
  }
  .header-content {
    position: absolute;
    width: 100%;
    top: 0;
    text-align: center;
    color: white;
    z-index: 2;
  }
  .body {
    width: 100%;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
      0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
    background-color: white;
    padding-bottom: 30px;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
  }
  .footer {
    width: 100%;
    height: 40px;
    text-align: center;
    padding: 10px;
    box-sizing: border-box;
    color: #e0e0e0;
  }
}
</style>

