<template>
  <div class="container">
    <el-form :model="ruleForm"
             :rules="rules"
             label-position="right"
             ref="ruleForm"
             label-width="100px"
             class="demo-ruleForm">
      <el-form-item label="姓名"
                    prop="name">
        <el-input v-model="ruleForm.name"></el-input>
      </el-form-item>
      <el-form-item label="学号"
                    prop="sid">
        <el-input v-model.number="ruleForm.sid"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary"
                   @click="submitForm(ruleForm)">加入班级</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      MyAxios: axios.create({
        headers: { "Content-Type": "application/json" }
      }),
      ruleForm: {
        sid: "", // 学号
        name: "" // 姓名
      },
      rules: {
        name: [{ required: true, message: "姓名必填", trigger: "blur" }],
        sid: [
          {
            required: true,
            message: "学号必填",
            trigger: "blur"
          },
          {
            type: "number",
            message: "学号格式不正确(应该全部为数字)",
            trigger: "blur"
          }
        ]
      } // 表单规则
    }
  },
  methods: {
    submitForm(data) {
      let classId = window.location.href.match(/.*\/joinclass\/(\d+)/)[1]
      let sid = data.sid
      let name = data.name
      let that = this
      this.MyAxios.post("/api/joinClass/" + classId, {
        sid: sid,
        name: name,
      })
        .then(function(response) {
          alert("加入班级成功!")
          that.toIndex()
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    toIndex() {
      location.href = "/#/index/task"
    }
  },
  mounted: function() {
    // 页面提示
    this.$notify.info({
      title: "提示",
      message: "输入学号和姓名加入班级.",
      duration: 0
    })
  }
}
</script>


<style lang="stylus" scoped>
.container
  width 70%
  margin auto
  height 100%
  display flex
  justify-content center
  align-items center
</style>
