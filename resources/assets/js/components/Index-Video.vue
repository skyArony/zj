<template>
  <div class="video-outer">
    <div class="video-body">
      <div class="video-left panel">
        <div id="swf">
          <embed src="/js/ckplayer/ckplayer.swf"
                 :flashvars="videoUrl"
                 bgcolor='#FFF'
                 quality="high"
                 width="100%"
                 height="648px"
                 align="middle"
                 allowScriptAccess="always"
                 allowFullscreen="true"
                 type="application/x-shockwave-flash" />
        </div>
        <div class="video-info">
          <div class="video-title-tags">
            <h2>{{selectedTitle}}</h2>
            <p>{{selectedSummary}}</p>
            <div class="video-tags">
              <el-tag v-for="(item,index) in selectedTags"
                      :key='index'>{{item}}</el-tag>
            </div>
          </div>
          <div class="video-target">
            <ul v-if="selectedTarget">
              <li v-for="(item, index) in selectedTarget"
                  :key="index">{{item}}</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="video-right">
        <div class="video-course-info panel">
          <div id="copyShareText"
               :data-clipboard-text="shareText"
               @click="copyText"></div>
          <img :src="courseImg" />
          <div class="course-text">
            <div class="course-title">{{courseTitle}}</div>
            <div class="course-teacher">{{courseTeacher}}</div>
          </div>
        </div>
        <div class="video-course-tree panel">
          <el-tree :data="courseTreeData"
                   default-expand-all
                   @node-click="handleNodeClick"></el-tree>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Clipboard from "clipboard/dist/clipboard"

export default {
  data() {
    return {
      courseId: "",
      customCourseId: "",
      courseTreeData: [], // 课程树
      courseTitle: "", // 课程名
      courseImg: "", // 课程图片
      courseTeacher: "", // 课程教师
      selectedTitle: "", // 选择的节的标题
      selectedTags: [], // 选择的节的 tas
      selectedTarget: [], // 选择的节的课程目标
      selectedSummary: "", // 节描述
      videoUrl: "", // 视频路径
      userName: "", // 用户名
      userImg: "", // 用户头像
      shareText: "填写问卷『』,定制化『』课程大纲."
    }
  },
  methods: {
    copyText() {
      var clipboard = new Clipboard("#copyShareText")
      this.$notify({
        title: "成功",
        message: "成功复制分享链接到剪切板!",
        type: "success",
        position: "top-left"
      })
    },
    handleNodeClick(data) {
      if (!data.children) {
        this.selectedTitle = data.label
        this.selectedTags = data.tags
        this.selectedTarget = data.claims
        this.selectedSummary = data.summary
        this.videoUrl =
          "video=http://119.90.41.31/video/mooc_" + data.id + ".flv"
        this.$nextTick(_ => {
          let temp = document.getElementById("swf").innerHTML
          document.getElementById("swf").innerHTML = temp
        })
      }
    },
    pageInit() {
      // 获取 id
      let courseMatch = window.location.href.match(/^.*\/course\/(\d+)$/)
      let customCourseMatch = window.location.href.match(
        /^.*\/customCourse\/(\d+)$/
      )
      if (courseMatch) this.courseId = courseMatch[1]
      if (customCourseMatch) this.customCourseId = customCourseMatch[1]
      // 1. 请求课程树数据
      var that = this
      let MyAxios = axios.create()
      if (this.courseId !== "") {
        MyAxios.get("/api/courseTree" + "/" + this.courseId)
          .then(function(response) {
            that.courseTreeData = that.courseTreeDataDeal(response.data.data)
          })
          .catch(function(error) {
            if (error.response.status == 404) location.href = "/404"
            else alert(error.response.data.errmsg)
          })
        // 2. 课程信息
        MyAxios.get("/api/course" + "/" + this.courseId)
          .then(function(response) {
            that.shareText =
              "快来查看我的「" +
              response.data.data.name +
              "」定制化课程吧.\n" +
              window.location.href
            that.courseTitle = response.data.data.name
            that.courseImg = response.data.data.pic
            that.courseTeacher = response.data.data.teacher
          })
          .catch(function(error) {
            if (error.response.status == 404) location.href = "/404"
            else alert(error.response.data.errmsg)
          })
      } else if (this.customCourseId !== "") {
        MyAxios.get("/api/customCourse" + "/" + this.customCourseId)
          .then(function(response) {
            that.courseTreeData = that.customCourseTreeDataDeal(
              response.data.data.courseTree
            )
            that.courseTitle = response.data.data.courseName
            that.courseImg = response.data.data.courseImg
            that.courseTeacher = response.data.data.courseTeacher
          })
          .catch(function(error) {
            if (error.response.status == 404) location.href = "/404"
            else alert(error.response.data.errmsg)
          })
      }
    },
    customCourseTreeDataDeal(sourceData) {
      let res = []
      for (let key in sourceData) {
        if (sourceData[key].status) {
          let children = []
          for (let key2 in sourceData[key]) {
            if (key2 != "chapter_name" && key2 != "status") {
              if (sourceData[key][key2].status) {
                let obj2 = {
                  id: key2,
                  label: sourceData[key][key2].period_title,
                  tags: sourceData[key][key2].tags,
                  claims: sourceData[key][key2].claims,
                  summary: sourceData[key][key2].period_summary
                }
                children.push(obj2)
              }
            }
          }
          res.push({
            id: key,
            label: sourceData[key].chapter_name,
            children: children
          })
        }
      }
      return res
    },
    courseTreeDataDeal(sourceData) {
      let res = []
      for (let key in sourceData) {
        let children = []
        for (let key2 in sourceData[key]) {
          if (key2 != "chapter_name" && key2 != "status") {
            let obj2 = {
              id: key2,
              label: sourceData[key][key2].period_title,
              tags: sourceData[key][key2].tags,
              claims: sourceData[key][key2].claims,
              summary: sourceData[key][key2].period_summary
            }
            children.push(obj2)
          }
        }
        res.push({
          id: key,
          label: sourceData[key].chapter_name,
          children: children
        })
      }
      return res
    }
  },
  activated: function() {
    this.pageInit()
    this.$emit("changePage", "course")
  }
}
</script>

<style scoped>
#copyShareText {
  position: absolute;
  right: -40px;
  top: 0px;
  width: 32px;
  height: 32px;
  z-index: 3;
  background-image: url("/storage/img/share.png");
}
.bottom {
  margin-top: 10px;
  display: flex;
  justify-content: center;
}
.panel {
  background-color: #fff;
  border: 1px solid transparent;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  margin-bottom: 20px;
}
.video-outer {
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
}
.video-nav {
  width: 100%;
  position: absolute;
  top: 0px;
  height: 50px;
  background-color: white;
  -webkit-box-shadow: rgba(0, 0, 0, 0.1) 0 1px 2px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
  padding: 0px 10.7% 0px 10.7%;
  display: flex;
  align-items: center;
  box-sizing: border-box;
}
.video-nav a {
  color: #212121;
  font-size: 14px;
  text-decoration: none;
}
.video-nav a:hover {
  color: #212121;
  font-size: 14px;
  text-decoration: none;
}
.video-nav a:active {
  color: #212121;
  font-size: 14px;
  text-decoration: none;
}
.video-body {
  padding: 25px 10.7% 40px 10.7%;
  box-sizing: border-box;
  display: flex;
  background-color: #f6f9fa;
}
.video-left {
  width: 75%;
  display: flex;
  flex-direction: column;
}
.video-info {
  padding: 15px;
}
.video-title-tags {
  display: flex;
  flex-direction: column;
}
.video-title-tags h2 {
  margin: 0;
  color: #222;
}
.video-title-tags p {
  margin-bottom: 0px;
  color: #757575;
}
.el-tag {
  margin: 10px 10px 0 0;
}
.video-target {
  color: #505050;
}
.video-target ul {
  padding-left: 20px;
}
.video-target li {
  height: 2rem;
}
.video-right {
  width: 25%;
  height: 100%;
  margin-left: 30px;
  box-sizing: border-box;
}
.video-course-info img {
  width: 70px;
  height: 70px;
  border-radius: 35px;
  margin-right: 20px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}
.video-course-info {
  position: relative;
  display: flex;
  align-items: center;
  padding: 15px;
}
.video-course-tree {
  padding: 15px;
}
.course-title {
  font-size: 20px;
  font-weight: 400;
  color: #212121;
}
.course-teacher {
  font-size: 14px;
  margin-top: 10px;
  color: #757575;
}
embed {
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}
.userImg {
  width: 36px;
  height: 36px;
  border-radius: 18px;
  margin-right: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}
</style>

<style>
.el-tree-node__label {
  width: 18rem;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.el-menu--horizontal {
  padding: 0 10.7%;
}
</style>
