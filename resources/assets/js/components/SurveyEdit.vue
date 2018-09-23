<template>
  <el-row :gutter="20">
    <el-col :span="17"
            class="left panel">
      <el-row>
        <el-form :rules="rules"
                 :model="ruleForm"
                 ref="ruleForm">
          <div v-if="pageType == 'create'">
            课程：<br />
            <el-form-item prop="course_id">
              <el-select v-model="ruleForm.course_id"
                         placeholder="请选择课程"
                         @change="changeDynamicTags">
                <el-option v-for="item in courses"
                           :key="item.value"
                           :label="item.label"
                           :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </div>
          问卷名：
          <el-form-item prop="title">
            <el-input placeholder="请输入问卷标题"
                      v-model="ruleForm.title">
            </el-input>
          </el-form-item>
          问卷简介：
          <el-form-item prop="desc">
            <el-input placeholder="请输入问卷介绍"
                      type="textarea"
                      v-model="ruleForm.desc">
            </el-input>
          </el-form-item>
        </el-form>
      </el-row>
      <hr/>
      <el-row>
        <worlduc-questionList :useDragHandle="true"
                              v-model="questions"
                              lockAxis="y">
          <worlduc-questionedit v-for="(item, index) in questions"
                                :question="item"
                                :showHandle="true"
                                :key="item.id"
                                :index="index"
                                class="list-item"></worlduc-questionedit>
        </worlduc-questionList>
      </el-row>
      <el-row :gutter="20"
              class="grid-add">
        <el-col :span="12">
          <div class="grid-addButton"
               @click="addQuestion('radio')">
            <i class="el-icon-circle-plus"> 添加单选问题</i>
          </div>
        </el-col>
        <el-col :span="12">
          <div class="grid-addButton"
               @click="addQuestion('checkBox')">
            <i class="el-icon-circle-plus"> 添加多选问题</i>
          </div>
        </el-col>
      </el-row>
      <el-row class="save">
        <el-button type="primary"
                   plain
                   @click="save">保存</el-button>
      </el-row>
    </el-col>
    <el-col :span="6"
            class="right panel">
      <worlduc-questionDetail></worlduc-questionDetail>
    </el-col>
  </el-row>
</template>

<script>
export default {
  data() {
    return {
      type: "",
      // 页面类型: create or edit
      pageType: "",
      // 问卷 ID
      id: "",
      // 可选的课程
      courses: [
        // {
        //   value: 2597,
        //   label: "黄金糕"
        // }
      ],
      // 表单的内容
      ruleForm: {
        course_id: "",
        title: "",
        desc: ""
      },
      // 表单的规则
      rules: {
        course_id: [
          { required: true, message: "请选择所属课程", trigger: "change" }
        ],
        title: [{ required: true, message: "请填写问卷名", trigger: "blur" }],
        desc: [{ required: true, message: "请填写问卷简介", trigger: "blur" }]
      }
      // questions: [
      //   {
      //     question: "--------- 请输入你的问题(多选) ---------",
      //     type: "checkBox",
      //     options: [],
      //     id: new Date().getTime(),
      //     addTags: {},
      //     removeTags: {}
      //   }
      // ],
    };
  },
  methods: {
    // 添加一个问题
    addQuestion(type) {
      if (type == "radio") {
        this.$store.commit("addQuestion", {
          question: "-------- 双击编辑你的问题(单选) --------",
          type: "radio",
          options: [],
          id: new Date().getTime(),
          addTags: {},
          removeTags: {}
        });
      } else if (type == "checkBox") {
        this.$store.commit("addQuestion", {
          question: "-------- 双击编辑你的问题(多选) --------",
          type: "checkBox",
          options: [],
          id: new Date().getTime(),
          addTags: {},
          removeTags: {}
        });
      }
    },
    // 保存
    save() {
      this.$refs["ruleForm"].validate(valid => {
        if (valid) {
          let MyAxios = axios.create({
            headers: { "Content-Type": "application/json" }
          });
          // 新建的保存
          if (this.pageType == "create") {
            var info = this.ruleForm.course_id.split("$");
            MyAxios.post("/api/survey", {
              title: this.ruleForm.title,
              desc: this.ruleForm.desc,
              course_id: info[0],
              course: info[1],
              questions: this.$store.state.questions
            })
              .then(function(response) {
                if (response.data.errcode == 0) 
                  location.href = "/admin/surveys";
              })
              .catch(function(error) {
                console.log(error);
                alert("发生了错误,请报告开发者.QQ: 1450872874");
              });
          } else if (this.pageType == "edit") {
            // 修改的保存
            MyAxios.put("/api/survey", {
              id: this.id,
              title: this.ruleForm.title,
              desc: this.ruleForm.desc,
              questions: this.$store.state.questions
            })
              .then(function(response) {
                if (response.data.errcode == 0) 
                  location.href = "/admin/surveys";
              })
              .catch(function(error) {
                console.log(error);
                alert("没有操作权限!");
              });
          }
        } else {
          if (this.courses.length == 0)
            this.$notify({
              title: "警告",
              message: "没有任何课程,无法创建对应的问卷.",
              type: "warning",
              duration: "3000",
              response: ""
            });
          console.log("error submit!!");
          return false;
        }
      });
    },
    // 修改可以选择的 tags
    changeDynamicTags(option) {
      let info = option.split("$");
      let course_id = info[0];
      var that = this;
      let MyAxios = axios.create();

      MyAxios.get("/api/tag/" + course_id).then(function(response) {
        if (response.data.errcode == 0) {
          that.dynamicTags = response.data.data;
          that.$store.commit("setTag", that.dynamicTags);
        }
      });
      // 清空所有问题的已选 addTag 和 removetag
      this.$store.commit("clearAllQuestionsTag");
    },
    // 页面数据初始化
    pageInit() {
      var that = this;
      let MyAxios = axios.create();
      // 获取当前页的类型
      this.pageType = (/.*?surveys\/(?:\d*\/)?(\w+)#?/).exec(window.location.href)[1];
      if (this.pageType == "create") {
        // 获取所有的课程
        MyAxios.get("/api/userCourse")
          .catch(function(error) {
            console.log(error);
          })
          .then(function(response) {
            let courses = response.data.data;
            let data = [];
            var index;
            for (index in courses) {
              data.push({
                label: courses[index].name,
                value: courses[index].id + "$" + courses[index].name
              });
            }
            that.courses = data;
          });
      } else if (this.pageType == "edit") {
        // 获取问卷的 ID
        this.id = window.location.href.match(/.*?surveys\/(\d)+/)[1];
        // 获取问卷的数据
        MyAxios.get("/api/survey/" + this.id)
          .catch(function(error) {
            console.log(error);
          })
          .then(function(response) {
            that.ruleForm.title = response.data.data.title;
            that.ruleForm.desc = response.data.data.desc;
            that.$store.state.questions = JSON.parse(
              response.data.data.questions
            );
            // 获取问卷可选择的 tags
            MyAxios.get("/api/tag/" + response.data.data.course_id)
              .catch(function(error) {
                console.log(error);
              })
              .then(function(response) {
                if (response.data.errcode == 0) {
                  that.dynamicTags = response.data.data;
                  that.$store.commit("setTag", that.dynamicTags);
                }
              });
          });
      }
    },
    // left and right init
    heightInit() {
      let total = document.querySelector("body").offsetHeight;
      document.querySelector(".left").style.maxHeight = total - 240 + "px";
      document.querySelector(".right").style.maxHeight = total - 240 + "px";
    }
  },
  computed: {
    questions: {
      // getter
      get: function() {
        return this.$store.state.questions;
      },
      // setter
      set: function(questions) {
        this.$store.commit("setQuestion", questions);
      }
    },
    question: function() {
      return this.$store.state.questions[this.$store.state.index];
    }
  },
  mounted: function() {
    this.pageInit();
    this.heightInit();
  }
};
</script>

<style scoped>
.el-row {
  font-size: 17px;
  font-weight: 400;
}
.el-input {
  margin-top: 10px;
}
.el-textarea {
  margin-top: 10px;
}
.el-select {
  margin-top: 10px;
}
hr {
  margin-top: 10px;
  margin-bottom: 0px;
}
.grid-add {
  margin-top: 25px;
}
.grid-addButton {
  border-radius: 4px;
  background-color: white;
  font-size: 14px;
  color: #c0c4cc;
  border: 1px solid #dcdfe6;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 2rem 0;
}
.grid-addButton:hover {
  color: #606266;
  box-shadow: #c0c4cc 0px 0px 1px;
}
.panel {
  margin-bottom: 22px;
  background-color: #fff;
  border: 1px solid transparent;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}
.list-item {
  border-bottom: 1px solid #efefef;
  padding: 15px 0 0 0;
}
.save {
  margin-top: 30px;
  display: flex;
  justify-content: center;
}
.save .el-button {
  width: 12rem;
}

.left {
  overflow-y: auto;
  padding: 15px !important;
  margin-right: 1%;
  margin-left: 1%;
}
.right {
  overflow-y: auto;
  padding: 0px !important;
  margin-left: 1%;
  margin-right: 1%;
}
</style>
