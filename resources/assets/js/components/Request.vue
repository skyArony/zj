<template>
  <div class="container">
    <div class="content">
      <h1>{{requestData.title}}</h1>
      <div class="action">
        <el-tag type="success"
                v-if="requestData.status == '通过'"
                size="medium"
                class="tag">已通过</el-tag>
        <el-tag type="warning"
                v-else-if="requestData.status == '未通过'"
                size="medium"
                class="tag">未通过</el-tag>
        <el-tag type="info"
                v-else-if="requestData.status == '待检阅'"
                size="medium"
                class="tag">待检阅</el-tag>
        <el-button size="mini"
                   type="primary"
                   round
                   @click="openDialog"
                   plain>点评</el-button>
        <el-dialog title="点评"
                   :visible.sync="dialogVisible"
                   width="50%">
          <el-input type="textarea"
                    :rows="3"
                    :autosize="{ minRows: 3, maxRows: 5}"
                    placeholder="请输入点评内容"
                    v-model="comment">
          </el-input>
          <span slot="footer"
                class="dialog-footer">
            <el-button type="primary"
                       plain
                       @click="review(true)">通 过</el-button>
            <el-button type="danger"
                       plain
                       @click="review(false)">驳 回</el-button>
          </span>
        </el-dialog>
      </div>
      <div class="detail"
           v-html="requestData.detail">
      </div>
      <div class="file">
        <i v-for="(item, index) in requestData.file"
           :key="index"
           class="el-icon-document">
          &nbsp;
          <a :href="'storage/' + item.download_link">{{item.original_name}}</a>
        </i>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      MyAxios: axios.create({
        headers: { "Content-Type": "application/json" }
      }),
      requestData: "",
      dialogVisible: false,
      comment: "",
      id: ""
    }
  },
  methods: {
    init() {
      let that = this
      this.MyAxios.get("/api/request/" + this.id)
        .then(function(response) {
          that.requestData = response.data.data
          that.requestData.file = JSON.parse(that.requestData.file)
          that.comment = that.requestData.comment
        })
        .catch(function(error) {
          if (error.response.status == 404) location.href = "/404"
          else alert(error.response.data.errmsg)
        })
    },
    openDialog() {
      this.dialogVisible = true
    },
    review(status) {
      this.dialogVisible = false
      let that = this
      if (status) {
        this.MyAxios.patch("/api/request/" + this.id, {
          status: "通过",
          comment: that.comment
        })
          .then(function(response) {
            that.requestData = response.data.data
            that.requestData.file = JSON.parse(that.requestData.file)
            that.comment = that.requestData.comment
          })
          .catch(function(error) {
            if (error.response.status == 404) location.href = "/404"
            else alert(error.response.data.errmsg)
          })
      } else {
        this.MyAxios.patch("/api/request/" + this.id, {
          status: "未通过",
          comment: that.comment
        })
          .then(function(response) {
            that.requestData = response.data.data
            that.requestData.file = JSON.parse(that.requestData.file)
            that.comment = that.requestData.comment
          })
          .catch(function(error) {
            if (error.response.status == 404) location.href = "/404"
            else alert(error.response.data.errmsg)
          })
      }
    }
  },
  mounted: function() {
    // 获取问卷数据,检查是否填写过问卷
    this.id = window.location.href.match(/.*\/requests\/(\d+)#?/)[1]
    this.init()
  }
}
</script>


<style lang="stylus" scoped>
.container
  width 100%

  .content
    padding 0px 5px
    display flex
    flex-direction column

    .detail
      margin 20px 0
      color #222
      line-height 1.5rem

    .action
      margin-top 10px

      .tag
        margin-right 10px

    .file
      font-size 13px
      margin-bottom 30px
      display flex
      flex-direction column

      i
        margin-bottom 15px

        a
          text-decoration none
</style>
