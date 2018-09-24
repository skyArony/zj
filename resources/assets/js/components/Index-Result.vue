<template>
  <div class="taskDetail">
    <div class="task-left pannel">
      <h1>{{resultData.title}}</h1>
      <div class="task-info">
        <div class="task-info-item publish-date">{{resultData.created_at}}</div>
        <div class="task-info-item team-number">课题:
          <span @click="toTask(resultData.task_id)" style="cursor: pointer">{{resultData.task}}</span>
        </div>
        <div class="task-info-item regist-end-time">研究团队:
          <span>{{resultData.team}}</span>
        </div>
      </div>
      <div class="task-detail"
           v-html="resultData.detail">
      </div>
      <div class="task-file">
        <i v-for="(item, index) in resultData.file"
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
      resultData: ""
    }
  },
  methods: {
    toTask(taksId) {
      this.$router.push({ path: `/index/task/${taksId}` })
    },
    init() {
      let resultId = this.$route.params.resultId
      if (resultId) {
        let that = this
        this.MyAxios.get("/api/result/" + resultId)
          .catch(function(error) {
            alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
          })
          .then(function(response) {
            that.resultData = response.data.data
          })
      } else {
        location.href = "/404"
      }
    }
  },
  // 从其他路由过来,在此进行数据的获取
  activated: function() {
    this.$emit("changePage", "task")
    this.init()
  }
}
</script>


<style lang="stylus" scoped>
@media screen and (min-width: 830px)
  .taskDetail
    width 80%

  .task-left
    margin-right 25px

@media screen and (max-width: 830px) and (min-width: 425px)
  .taskDetail
    width 80%
    flex-direction column

  .task-left
    margin-right 0

  h1
    font-size 1.5rem

@media screen and (max-width: 425px)
  .taskDetail
    width 100%
    flex-direction column

  .task-left
    margin-right 0

  h1
    font-size 1.5rem

.pannel
  background-color #fff
  border 1px solid transparent
  border-radius 4px
  box-shadow 0 2px 10px rgba(0, 0, 0, 0.05)

.taskDetail
  margin 20px auto
  display flex

  .task-left
    flex 1 0
    display flex
    flex-direction column
    padding 0 20px
    margin-bottom 20px
    box-sizing border-box

    .task-info
      color #9b9b9b
      font-size 12px
      font-weight 400
      display flex
      align-items center

      .task-info-item
        margin-right 20px

        span
          color #409dfd

    .task-detail
      margin 20px 0
      color #222
      line-height 1.5rem

    .task-file
      font-size 13px
      margin-bottom 30px
      display flex
      flex-direction column

      i
        margin-bottom 15px

        a
          text-decoration none
</style>