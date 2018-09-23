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
          <worlduc-question v-for="item in questions"
                            :key="item.id"
                            :question="item"
                            @setAnswer="setAnswerData"></worlduc-question>
          <el-button type="primary"
                     plain
                     @click="submit"
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
                       @click="again">我想再填一次</el-button>
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
import Clipboard from "clipboard/dist/clipboard";

export default {
  data() {
    return {
      title: "",
      desc: "",
      questions: [], // 问卷上的问题
      answer: {},
      id: "", // 问卷 id
      isComplete: false, // 是否填写完问卷
      customCourseId: "", // 填写完成的定制化课程 ID
      shareText: "填写问卷『』,定制化『』课程大纲.",
      qrcodeVisible: false // 是否显示分享框
    };
  },
  methods: {
    copyText() {
      var clipboard = new Clipboard("#copyQRText");
      var clipboard = new Clipboard("#copyShareText");
      this.$notify({
          title: '成功',
          message: '成功复制到剪切板!',
          type: 'success',
          position: "top-left"
      });
    },
    showQRcode(data) {
      this.qrcodeVisible = !this.qrcodeVisible;
      if (this.$refs.qrcode.childNodes.length == 0) {
        let qrcode = new QRCode("qrcode", {
          width: 200,
          height: 200
        });
        qrcode.makeCode(window.location.href);
      }
    },
    setAnswerData(data) {
      this.answer[data.id] = data;
    },
    getSurvey() {
      var that = this;
      let MyAxios = axios.create();
      // 获取当前问卷的ID
      this.id = window.location.href.match(/.*\/survey\/(\d+)/)[1];
      // 获取问卷的数据
      MyAxios.get("/api/survey/" + this.id)
        .catch(function(error) {
          console.log(error);
          location.href = "/404";
        })
        .then(function(response) {
          if (response.data.errcode === 0) {
            that.shareText = "填写问卷「" + response.data.data.title + "」, 定制化「" + response.data.data.course + "」课程大纲.\n" + window.location.href
            that.title = response.data.data.title;
            that.desc = response.data.data.desc;
            that.questions = JSON.parse(response.data.data.questions);
          }
        });
      // 检查是否填写过当前问卷
      MyAxios.get("/api/answerRecord/" + this.id)
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
            });
          }
        })
        .then(function(response) {
          if (response.data.data) {
            that.$notify({
              title: "提示",
              message: "你填写过本问卷,再次填写将覆盖之前记录!",
              type: "info",
              duration: "4000",
              position: "top-left"
            });
          }
        });
    },
    submit() {
      let addTags = [];
      let removeTags = [];
      for (let key in this.answer) {
        addTags = addTags.concat(this.answer[key]["addTags"]);
        removeTags = removeTags.concat(this.answer[key]["removeTags"]);
      }
      addTags = Array.from(new Set(addTags));
      removeTags = Array.from(new Set(removeTags));
      // 交集
      let intersection = addTags.filter(v => removeTags.includes(v));
      // 差集-结果
      let res = addTags
        .concat(intersection)
        .filter(v => !addTags.includes(v) || !intersection.includes(v));

      // 发送结果到后台
      let that = this;
      let MyAxios = axios.create({
        headers: { "Content-Type": "application/json" }
      });
      MyAxios.post("/api/answerRecord/" + this.id, {
        tags: res
      })
        .then(function(response) {
          if (response.data.errcode == 0) {
            // 显示结果或跳转;
            that.customCourseId = response.data.data.id;
            that.isComplete = true;
          } else {
            alert("发生了错误,请报告开发者.QQ: 1450872874");
            console.log(response.data.errmsg);
          }
        })
        .catch(function(error) {
          console.log(error);
          alert("发生了错误,请报告开发者.QQ: 1450872874");
        });
    },
    again() {
      this.isComplete = false;
    },
    view() {
      location.href = "/#/index/customCourse/" + this.customCourseId;
    }
  },
  mounted: function() {
    // 获取问卷数据,检查是否填写过问卷
    this.getSurvey();
  }
};
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
  margin-top: 20%;
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
    display: none;
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

