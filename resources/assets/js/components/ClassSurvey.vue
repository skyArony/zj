<template>
  <div class="container">
    <el-dialog :title="dialogTilte"
               :visible.sync="qrcodeVisible"
               width="50%">
      <div id="qrcode"
           ref="qrcode">1. 选择课程生成课堂问卷二维码<br/>2. 填写时无需登录,通过学号鉴别身份</div>
    </el-dialog>
    <div class="main">
      <div class="header">
        <img src="/storage/img/header.jpg" />
        <div class="header-content">
          <div class="title">{{className}}</div>
          <div class="desc">选择课程然后生成课堂问卷二维码</div>
        </div>
      </div>
      <div class="body">
        <div class="content">
          <el-checkbox class="checkBox box"
                       v-model="needSid">填写学号</el-checkbox>
          <el-select v-model="courseId"
                     class="select"
                     @change="selectCourse"
                     placeholder="请选择课程">
            <el-option v-for="item in courseList"
                       :key="item.id"
                       :label="item.name"
                       :value="item.id">
            </el-option>
          </el-select>
          <el-checkbox class="checkBox"
                       v-model="needSid"
                       disabled
                       checked>填写学号</el-checkbox>
        </div>
        <el-button type="primary"
                   plain
                   @click="submit"
                   :disabled="isOpen"
                   class="submit">确定</el-button>
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
      classId: "", // 班级 ID
      courseList: [], // 所有课程
      className: "", // 班级名
      courseId: "", // 选择的课程
      isOpen: true, // 是否可以确定
      surveyUrl: "", // 课堂问卷路径 url
      needSid: 1, // 是否需要填写 sid
      qrcodeVisible: false, // 是否显示二维码框
      show: "hidden", // dialog 偷偷显示一次,不然显示二维码时会有 bug
      dialogTilte: "使用提示"
    }
  },
  methods: {
    // 初始化
    init() {
      this.classId = window.location.href.match(/.*\/classsurvey\/(\d+)/)[1]
      if (!this.classId) location.href = "/404"
      this.checkClass()
      this.getCourse()
      this.qrcodeVisible = true
    },
    // 检查是否有当前班级
    checkClass() {
      let that = this
      this.MyAxios.get("/api/class/" + this.classId)
        .then(function(response) {
          that.className = response.data.data.className
        })
        .catch(function(error) {
          if (error.response.data.errcode == -4007) alert("请先登录!")
          else if (error.response.status == 404) location.href = "/404"
          else alert(error.response.data.errmsg)
        })
    },
    // 获取当前登陆用户的所有课程
    getCourse() {
      let that = this
      this.MyAxios.get("/api/user/course")
        .then(function(response) {
          that.courseList = response.data.data
        })
        .catch(function(error) {
          if (error.response.data.errcode == -4007) alert("请先登录!")
          else alert(error.response.data.errmsg)
        })
    },
    // 监听选择课程
    selectCourse(data) {
      if (data) this.isOpen = false
      else this.isOpen = true
    },
    // 确认选择,生成路径 url
    submit() {
      this.qrcodeVisible = true
      this.dialogTilte = "扫面二维码进入课堂问卷"
      let domain = window.location.href.match(/^(.*?)\/classsurvey\/.*?/)[1]
      this.surveyUrl =
        domain +
        "/autosurvey/" +
        this.courseId +
        "?classId=" +
        this.classId +
        "&needSid=1"
      if (this.$refs.qrcode.childNodes.length == 3) {
        this.$refs.qrcode.innerHTML = ""
        let qrcode = new QRCode("qrcode", {
          width: 350,
          height: 350
        })
        qrcode.makeCode(this.surveyUrl)
      }
    }
  },
  mounted: function() {
    // 初始化
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
  font-size: 20px;
  display: flex;
  justify-content: center;
}
.body {
  display: flex;
  flex-direction: column;
}
.content {
  width: 80%;
  display: flex;
  justify-content: space-around;
  align-items: baseline;
  margin: 50px auto 0px auto;
}
.select {
  width: 75%;
}
.checkBox {
  margin-left: 20px;
}
.box {
  visibility: hidden;
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

