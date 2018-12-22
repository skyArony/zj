<template>
  <div class="container">
    <div class="content">
      <h1>{{requestData.title}}</h1>
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
      requestData: ""
    }
  },
  methods: {
    init(id) {
      let that = this
      this.MyAxios.get("/api/request/" + id)
        .then(function(response) {
          that.requestData = response.data.data
          that.requestData.file = JSON.parse(that.requestData.file)
        })
        .catch(function(error) {
          if (error.response.status == 404) location.href = "/404"
          else alert(error.response.data.errmsg)
        })
    },
  },
  mounted: function() {
      // 获取问卷数据,检查是否填写过问卷
      let id = window.location.href.match(/.*\/requests\/(\d+)#?/)[1]
      this.init(id)
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
