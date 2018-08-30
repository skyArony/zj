<template>
  <div class="taskDetail">
    <div class="task-left pannel">
      <h1>{{taskData.title}}</h1>
      <div class="task-info">
        <div class="task-info-item publish-date">{{taskData.created_at}}</div>
        <div class="task-info-item team-number">报名队数: <span>{{taskData.registTeams}}</span></div>
        <div class="task-info-item regist-end-time">距报名截止: <span>2小时20分</span></div>
        <div class="task-info-item submit-end-time">距课题截止: <span>10天12小时</span></div>
      </div>
      <div class="task-detail" v-html="taskData.detail">
      </div>
      <div class="task-file">
        <i v-for="(item, index) in taskData.file" 
           :key="index" 
           class="el-icon-document">
           &nbsp;<a :href="'storage/' + item.download_link">{{item.original_name}}</a>
        </i>
      </div>
    </div>
    <div class="task-right pannel">
      <div class="teacher-info">
        <img class="teacher-img" :src="taskData.creater_avatar" />
        <div class="teacher-name">{{taskData.creater_name}}</div>
      </div>
      <div class="more-tasks-title">
        <h3>更多课题</h3>
      </div>
      <div class="task-item-container">
        <div class="task-item">第一个课题</div>
        <div class="task-item">第一个课题第一个课题</div>
        <div class="task-item">第一个课题第一个课题第一个课题</div>
        <div class="task-item">第一个课题第一个课题第一个课题第一个课题</div>
        <div class="task-item">第一个课题第一个课题第一个课题第一个课题第一个课题</div>
        <div class="task-item">第一个课题第一个课题第一个课题第一个课题第一个课题第一个课题</div>
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
      taskData: '',
    }
  },
  methods: {
    init(taskId) {
      let that = this
      this.MyAxios.get("/api/task/" + taskId)
        .catch(function(error) {
          alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
        })
        .then(function(response) {
          that.taskData = response.data.data
        })
    }
  },
  mounted: function() {
    let taskId = this.$route.params.taskId
    this.init(taskId)
    
  },
  activated: function() {
    this.$emit("changePage", "task")
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
  background-color: #fff;
  border: 1px solid transparent;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0,0,0,.05);

.taskDetail
  margin 20px auto
  display flex

  .task-left
    flex 3 0
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

  .task-right
    flex 1 0
    display flex
    flex-direction column
    padding 20px
    margin-bottom 20px
    box-sizing border-box
    overflow hidden

    .teacher-info
      display flex

      .teacher-img
        width 64px
        height 64px
        border-radius 32px
        object-fit cover

      .teacher-name
        margin-left 20px
        margin-top 10px

    .more-tasks-title
      border-bottom 1px solid #e5e9ef

      h3  
        margin-bottom 10px

    .task-item-container
      display flex
      flex-direction column
      padding 16px 0
      width 100%

      .task-item
        width 100%
        margin-bottom 5px
        font-size 14px
        color #757575
        overflow hidden
        text-overflow ellipsis
        white-space nowrap
      
      .task-item:hover
        color #409dfd
        cursor pointer
</style>