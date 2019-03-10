<template>
  <div class="container">
    <el-form :model="ruleForm"
             :rules="rules"
             :inline="true"
             label-position="right"
             ref="ruleForm"
             label-width="100px"
             class="demo-ruleForm">
      <el-form-item label="学号"
                    prop="sid">
        <el-input v-model.number="ruleForm.sid"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary"
                   @click="submitForm(ruleForm)">确认</el-button>
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
        sid: "" // 学号
      },
      rules: {
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
      let sid = data.sid
      let that = this
      this.MyAxios.patch("/api/bindSid/", {
        sid: sid
      })
        .then(function(response) {
          that.toIndex()
        })
        .catch(function(error) {
          if (error.response.data.errcode == -4007) alert("请先登录!")
          else alert(error.response.data.errmsg)
        })
    },
    toIndex() {
      location.href = "/#/index/course"
    }
  },
  mounted: function() {
    // 页面提示
    this.$notify.info({
      title: "提示",
      message: "湘潭大学的学生需要先绑定学号才能继续使用.",
      duration: 3000
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
