<template>
  <div class="taskDetail">
    <div class="task-left pannel">
      <h1>{{taskData.title}}</h1>
      <div class="task-info">
        <div class="task-info-item publish-date">{{taskData.created_at}}</div>
        <div class="task-info-item team-number">报名队数:
          <span>{{taskData.registTeams}}</span>
        </div>
        <div class="task-info-item regist-end-time">距报名截止:
          <span>{{taskData.regist_end_at}}</span>
        </div>
        <div class="task-info-item regist-end-time">距申请截止:
          <span>{{taskData.request_end_at}}</span>
        </div>
        <div class="task-info-item submit-end-time">距课题截止:
          <span>{{taskData.submit_end_at}}</span>
        </div>
        <el-popover v-if="role == 4"
                    placement="bottom"
                    trigger="hover">
          <el-table :data="teamData"
                    max-height="300">
            <el-table-column prop="title"
                             label="可选团队">
              <template slot-scope="scope">
                <div class="surveyTitle">{{scope.row.team_name}}</div>
              </template>
            </el-table-column>
            <el-table-column label="操作"
                             width="55">
              <template slot-scope="scope">
                <el-button v-if="scope.row.isSign"
                           type="text"
                           size="small"
                           disabled>
                  已报名
                </el-button>
                <el-button v-else
                           @click.native.prevent="sign(scope.row.id, taskData.id, scope.$index)"
                           type="text"
                           size="small">
                  报名
                </el-button>
              </template>
            </el-table-column>
          </el-table>
          <el-button slot="reference"
                     type="primary"
                     class="button"
                     size="mini"
                     @click.stop=";"
                     plain>报名</el-button>
        </el-popover>
        <el-tooltip content="报名 → 提交课题申请计划书 → 教师通过申请,给予提交资格 → 提交成果" placement="top">
          <i class="el-icon-question"></i>
        </el-tooltip>
      </div>
      <div class="task-detail"
           v-html="taskData.detail">
      </div>
      <div class="task-file">
        <i v-for="(item, index) in taskData.file"
           :key="index"
           class="el-icon-document">
          &nbsp;
          <a :href="'storage/' + item.download_link">{{item.original_name}}</a>
        </i>
      </div>
    </div>
    <div class="task-right pannel">
      <div class="teacher-info">
        <img class="teacher-img"
             :src="taskData.creater_avatar" />
        <div class="teacher-name">{{taskData.creater_name}}</div>
      </div>
      <div class="more-tasks-title">
        <h3>更多课题</h3>
      </div>
      <div class="task-item-container">
        <div class="task-item"
             v-for="item in moreTask"
             :key="item.id"
             @click="toTask(item.id)">{{item.title}}</div>
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
      taskData: "",
      moreTask: "",
      teamData: [],
      role: ""
    }
  },
  methods: {
    toTask(taksId) {
      this.$router.push({ path: `/index/task/${taksId}` })
    },
    async init(taskId) {
      // 可报名的团队-初始化
      let that = this
      await this.MyAxios.get("/api/user/team/")
        .then(function(response) {
          let teams = response.data.data
          for (let index in teams) that.$set(teams[index], "isSign", false)
          that.teamData = teams
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
      // 获取 task 详细数据
      this.MyAxios.get("/api/task/" + taskId)
        .then(function(response) {
          that.taskData = response.data.data
          that.taskData.file = JSON.parse(that.taskData.file)
          let teams = that.teamData
          for (let index in teams) {
            if (that.taskData.signTeams.includes(teams[index].id))
              that.$set(teams[index], "isSign", true)
            else that.$set(teams[index], "isSign", false)
          }
          that.teamData = teams
          that.MyAxios.get("/api/task/more/" + that.taskData.creater_id)
            .then(function(response) {
              that.moreTask = response.data.data
            })
            .catch(function(error) {
              alert(error.response.data.errmsg)
            })
        })
        .catch(function(error) {
          if (error.response.status == 404) location.href = "/404"
          else alert(error.response.data.errmsg)
        })
    },
    sign(teamId, taskId, index) {
      var that = this
      this.MyAxios.post("/api/task/sign", {
        taskId: taskId,
        teamId: teamId
      })
        .then(function(response) {
          alert("报名成功,请在「申请截止」时间之前,前往后台提交开题申请!")
          that.teamData[index].isSign = true
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    roleDeal() {
      let yyy = document.cookie.match(/token=(\w+)\.(\w+)\.(\w+)/)[2]
      let arr = JSON.parse(window.atob(yyy))
      console.log(arr)
      this.role = arr.role
    }
  },
  // 同级页面的切换,在此进行数据的获取
  beforeRouteUpdate(to, from, next) {
    this.init(to.params.taskId)
    next()
  },
  // 从其他路由过来,在此进行数据的获取
  activated: function() {
    this.$emit("changePage", "task")
    this.taskData = ""
    this.init(this.$route.params.taskId)
    this.roleDeal()
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

.el-icon-question
  font-size 20px
  margin-left 20px

.pannel
  background-color #fff
  border 1px solid transparent
  border-radius 4px
  box-shadow 0 2px 10px rgba(0, 0, 0, 0.05)

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