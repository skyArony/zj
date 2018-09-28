<template>
  <div class="outer">
    <div class="header">
      <div class="courseInfo panel">
        <div class="courseImg">
          <img :src="courseImg" />
          <h5>{{courseTeacher}}</h5>
        </div>
        <div class="courseDetail">
          <div class="targetHeader">
            <h3 style="margin:0px 20px 0 0;">
              <a :href="courseVideo"
                 target="_blank">{{courseName}}</a>
            </h3>
            <el-button type="primary"
                       plain
                       round
                       size="mini"
                       @click="download">导出个性化课程为 PDF</el-button>
          </div>
          <div>
            <h4 style="margin:15px 0 5px 0">课程介绍:</h4>
            <p>{{courseDesc}}</p>
          </div>
        </div>
      </div>
      <div class="yourTag panel">
        <h3 style="margin:0px;">问卷: {{surveyName}}</h3>
        <h4 style="margin:15px 0 10px 0">为你标记的 Tag:</h4>
        <div v-if="isHasTag">
          <el-tag v-for="(item, index) in answerRecordTags"
                  size="small"
                  :key="index">{{item}}</el-tag>
        </div>
        <p v-else>没有标记的 Tag</p>
      </div>
    </div>
    <div class="body panel">
      <div class="courseTree">
        <div class="targetHeader"
             style="margin-bottom:15px">
          <h3 style="margin:0 15px 0 0;">课程目录</h3>
          <el-button type="success"
                     plain
                     round
                     size="mini"
                     @click="viewCourseVideo">查看课程视频</el-button>
        </div>
        <el-tree :data="courseTreeData"
                 node-key="mytree"
                 default-expand-all
                 :expand-on-click-node="false">
        </el-tree>
      </div>
      <div class="courseTarget">
        <hr />
        <div class="targetContent">
          <div class="targetHeader">
            <h3 style="margin:0px 20px 15px 0;">课程目标</h3>
            <el-radio-group v-model="targetShowType"
                            size="mini">
              <el-radio-button label="节视图"></el-radio-button>
              <el-radio-button label="章视图"></el-radio-button>
            </el-radio-group>
          </div>
          <div v-if="targetShowType == '节视图'">
            <div v-for="item in courseTargetData"
                 :key="item.id">
              <h4>{{item.label}}</h4>
              <div style="margin-left:2rem;"
                   v-for="item2 in item.children"
                   :key="item2.id">
                <h5>{{item2.label}}</h5>
                <ul>
                  <li v-for="(item3, index) in item2.children"
                      :key="index">{{item3}}</li>
                </ul>
              </div>
            </div>
          </div>
          <div v-else>
            <div v-for="item in courseTargetData2"
                 :key="item.id">
              <h4>{{item.label}}</h4>
              <ul>
                <li v-for="(item2, index) in item.children"
                    :key="index">{{item2}}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // 控制
      targetShowType: "节视图", // 是否显示为章视图
      // 数据
      id: "", // 本业数据的 ID
      courseName: "",
      courseDesc: "",
      courseImg: "",
      courseTeacher: "",
      courseVideo: "",
      surveyName: "",
      answerRecordTags: [],
      isHasTag: false,
      courseTreeData: [],
      courseTargetData: [],
      courseTargetData2: []
    }
  },
  methods: {
    // 导出下载
    download() {
      window.open("/pdf/" + this.id)
    },
    getData() {
      var that = this
      let MyAxios = axios.create()
      // 获取当前问卷的ID
      this.id = window.location.href.match(/.*\/(\d+)/)[1]
      // 获取所有的课程
      MyAxios.get("/api/customCourse" + "/" + this.id)
        .catch(function(error) {
          console.log(error)
          location.href = "/404"
        })
        .then(function(response) {
          if (response.data.errcode === 0) {
            that.courseVideo =
              "/#/index/video/course/" + response.data.data.courseId
            that.courseName = response.data.data.courseName
            that.courseDesc = response.data.data.courseDesc
            that.courseImg = response.data.data.courseImg
            that.courseTeacher = response.data.data.courseTeacher
            that.surveyName = response.data.data.surveyName
            that.answerRecordTags = response.data.data.answerRecordTags
            that.courseTreeData = that.treeData(
              response.data.data.courseTreeTags
            )
            that.courseTargetData = that.targetData(
              response.data.data.courseTreeTags,
              true
            )
            that.courseTargetData2 = that.targetData(
              response.data.data.courseTreeTags,
              false
            )
            if (that.answerRecordTags.length > 0) that.isHasTag = true
          } else {
            console.log(response.data.errmsg)
            location.href = "/404"
          }
        })
    },
    treeData(sourceData) {
      let res = []
      for (let key in sourceData) {
        if (sourceData[key].status) {
          let children = []
          for (let key2 in sourceData[key]) {
            if (key2 != "chapter_name" && key2 != "status") {
              if (sourceData[key][key2].status) {
                let obj2 = {
                  id: key2,
                  label: sourceData[key][key2].period_title
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
    targetData(sourceData, isChapter) {
      let res = []
      if (isChapter) {
        for (let key in sourceData) {
          if (sourceData[key].status) {
            let children = []
            for (let key2 in sourceData[key]) {
              if (key2 != "chapter_name" && key2 != "status") {
                if (sourceData[key][key2].status) {
                  let obj2 = {
                    id: key2,
                    label: sourceData[key][key2].period_title,
                    children: sourceData[key][key2].claims
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
      } else {
        for (let key in sourceData) {
          if (sourceData[key].status) {
            let children = []
            for (let key2 in sourceData[key]) {
              if (key2 != "chapter_name" && key2 != "status") {
                if (sourceData[key][key2].status) {
                  children = children.concat(sourceData[key][key2].claims)
                }
              }
            }
            children = Array.from(new Set(children))
            res.push({
              id: key,
              label: sourceData[key].chapter_name,
              children: children
            })
          }
        }
      }
      return res
    },
    viewCourseVideo() {
      location.href = "/#/index/video/customCourse/" + this.id
    }
  },
  mounted: function() {
    this.getData()
  },
  activated: function() {
    this.$emit("changePage", "course")
  }
}
</script>

<style scoped>
.h1,
.h2,
.h3,
.h4,
.h5,
.h6,
h1,
h2,
h3,
h4,
h5,
h6 {
  text-shadow: rgba(0, 0, 0, 0.15) 0 0 1px;
}
.h1,
.h2,
.h3,
.h4,
.h5,
.h6,
h1,
h2,
h3,
h4,
h5,
h6 {
  font-family: inherit;
  font-weight: 500;
  line-height: 1.1;
  color: inherit;
}

.h1,
.h2,
.h3,
h1,
h2,
h3 {
  margin-top: 20px;
  margin-bottom: 10px;
}

.h4,
.h5,
.h6,
h4,
h5,
h6 {
  margin-top: 10px;
  margin-bottom: 10px;
}

.h1,
h1 {
  font-size: 36px;
}

.h2,
h2 {
  font-size: 30px;
}

.h3,
h3 {
  font-size: 24px;
}

.h4,
h4 {
  font-size: 18px;
}

.h5,
h5 {
  font-size: 14px;
}

.h6,
h6 {
  font-size: 12px;
}

p {
  margin: 0 0 10px;
  font-weight: 300;
}

li {
  font-weight: 300;
}

a {
  color: #337ab7;
  text-decoration: none;
}

a:focus,
a:hover {
  color: #23527c;
  text-decoration: underline;
}

a:focus {
  outline: -webkit-focus-ring-color auto 5px;
  outline-offset: -2px;
}

dl,
ol,
ul {
  margin-top: 0;
}

ol,
ul {
  margin-bottom: 10px;
}

.panel {
  margin-bottom: 22px;
  background-color: #fff;
  border: 1px solid transparent;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}
.outer {
  width: 80%;
  margin: 20px auto;
  margin-bottom: 30px;
  font-family: Open Sans, sans-serif;
  font-size: 14px;
  line-height: 1.57142857;
  color: #76838f;
}
.header {
  margin-top: 22px;
  display: flex;
}
.courseInfo {
  width: 55%;
  display: flex;
  margin-right: 20px;
  padding: 20px;
}
.courseImg {
  display: flex;
  flex-direction: column;
  text-align: center;
  justify-content: space-between;
  margin-right: 20px;
  max-width: 8rem;
  word-wrap: break-word;
}
.courseDetail p {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  -webkit-line-clamp: 4;
  overflow: hidden;
}
.courseImg img {
  width: 8rem;
  height: 8rem;
  border-radius: 4rem;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.16), 0 0 2px 0 rgba(0, 0, 0, 0.12);
}
.yourTag {
  width: 45%;
  padding: 20px;
}
.el-tag {
  margin: 5px 5px 0 0;
}
.body {
  display: flex;
}
.courseTree {
  width: 57%;
  padding: 20px;
}
.courseTarget {
  display: flex;
  width: 51%;
  padding: 20px;
}
.courseTarget hr {
  width: 1px;
  height: 100%;
  margin: 0px 25px 0 0;
  background-color: #e0e0e0;
}
.targetHeader {
  display: flex;
}
.el-tree {
  color: #76838f;
  text-shadow: rgba(0, 0, 0, 0.15) 0 0 1px;
}
hr {
  border-top: 1px solid #eee;
  box-sizing: content-box;
  border: 0;
}
</style>

<style>
/* tree */
.el-tree-node__label {
  font-size: 20px;
  font-weight: 400;
}
.el-tree-node__content {
  height: 36px;
}
</style>