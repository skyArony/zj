<template>
  <div class="page">
    <div class="page-content">
      <div class="user">
        <img :src="userInfo.avatar"
             class="avatar" />
        <div class="userInfo">
          <div class="topInfo">
            <div class="name">{{userInfo.name}}</div>
            <div class="id">{{userInfo.id}}</div>
          </div>
          <div class="bottomInfo">
            <el-popover placement="bottom"
                        trigger="click"
                        @after-leave="reset">
              <div class="popover-edit">
                <el-input v-if="isEdit"
                          v-model="userInfo.phone"
                          placeholder="请输入内容"
                          size="mini"></el-input>
                <div v-else>
                  <span v-if="userInfo.phone">{{userInfo.phone}}</span>
                  <span v-else>未绑定</span>
                </div>
                <el-button v-if="isEdit"
                           type="text"
                           size="mini"
                           @click="sureChange('tel')">&nbsp;&nbsp;&nbsp;确定</el-button>
                <el-button v-else-if="userInfo.phone"
                           type="text"
                           size="mini"
                           @click="edit">&nbsp;&nbsp;&nbsp;重新绑定</el-button>
                <el-button v-else
                           type="text"
                           size="mini"
                           @click="edit">绑定</el-button>
              </div>
              <svg class="icon"
                   :class="[userInfo.phone && !isEdit ? 'icon-active' : '']"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-phone"></use>
              </svg>
            </el-popover>
            <el-popover placement="bottom"
                        trigger="click"
                        @after-leave="reset">
              <div class="popover-edit">
                <el-input v-if="isEdit"
                          v-model="userInfo.QQ"
                          placeholder="请输入内容"
                          size="mini"></el-input>
                <div v-else>
                  <span v-if="userInfo.QQ">{{userInfo.QQ}}</span>
                  <span v-else>未绑定</span>
                </div>
                <el-button v-if="isEdit"
                           type="text"
                           size="mini"
                           @click="sureChange('qq')">&nbsp;&nbsp;&nbsp;确定</el-button>
                <el-button v-else-if="userInfo.QQ"
                           type="text"
                           size="mini"
                           @click="edit">&nbsp;&nbsp;&nbsp;重新绑定</el-button>
                <el-button v-else
                           type="text"
                           size="mini"
                           @click="edit">绑定</el-button>
              </div>
              <svg class="icon"
                   :class="[userInfo.QQ && !isEdit ? 'icon-active' : '']"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-qq"></use>
              </svg>
            </el-popover>
          </div>
        </div>
      </div>
      <div class="detail">
        <el-tabs v-model="activeName"
                 stretch
                 @tab-click="handleClick">
          <el-tab-pane name="mytask">
            <span slot="label">
              <svg class="icon icon-active"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-task"></use>
              </svg>
              &nbsp;我的课题</span>
            <el-table :data="taskData"
                      style="width: 100%">
              <el-table-column prop="title"
                               label="课题"
                               min-width="180px">
              </el-table-column>
              <el-table-column prop="teacher"
                               label="指导老师">
              </el-table-column>
              <el-table-column prop="team"
                               label="团队">
              </el-table-column>
              <el-table-column prop="time"
                               label="课题状态">
                <template slot-scope="scope">
                  <el-tag :type="scope.row.time === '已过期' ? 'info' : 'success'"
                          disable-transitions>{{scope.row.time === '已过期' ? '' : '剩'}}{{scope.row.time}}</el-tag>
                </template>
              </el-table-column>
              <el-table-column prop="isSubmit"
                               label="提交状态">
                <template slot-scope="scope">
                  <el-tag :type="scope.row.isSubmit === 'true' ? 'success' : 'info'"
                          plain>{{scope.row.isSubmit === 'true' ? '已提交' : '未提交'}}</el-tag>
                </template>
              </el-table-column>
              <el-table-column prop="isLeader"
                               label="操作"
                               width="140px">
                <template slot-scope="scope">
                  <div style="display:flex">
                    <el-button size="mini"
                               type="primary"
                               @click="toTask(scope.row.taskId)">查看</el-button>
                    <el-button v-if="scope.row.isLeader"
                               size="mini"
                               type="danger"
                               @click="leave(scope.row.taskId, scope.row.teamId, scope.$index)">退出</el-button>
                  </div>
                </template>
              </el-table-column>
            </el-table>
          </el-tab-pane>
          <el-tab-pane name="myresult">
            <span slot="label">
              <svg class="icon icon-active"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-success"></use>
              </svg>
              &nbsp;科研成果</span>
            <el-table :data="resData"
                      style="width: 100%">
              <el-table-column prop="taskName"
                               label="课题">
              </el-table-column>
              <el-table-column prop="taskTeacher"
                               label="成果">
              </el-table-column>
              <el-table-column prop="taskTeam"
                               label="团队">
              </el-table-column>
              <el-table-column prop="taskSubmitStatus"
                               label="提交时间">
              </el-table-column>
              <el-table-column prop="taskAction"
                               label="操作">
              </el-table-column>
            </el-table>
          </el-tab-pane>
          <el-tab-pane name="mycourse">
            <span slot="label">
              <svg class="icon icon-active"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-course"></use>
              </svg>
              &nbsp;我的课程</span>
            <el-table :data="courseData"
                      style="width: 100%">
              <el-table-column prop="taskName"
                               label="问卷">
              </el-table-column>
              <el-table-column prop="taskTeacher"
                               label="课程">
              </el-table-column>
              <el-table-column prop="taskTeam"
                               label="填写时间">
              </el-table-column>
              <el-table-column prop="taskAction"
                               label="操作">
              </el-table-column>
            </el-table>
          </el-tab-pane>
          <el-tab-pane name="myteam">
            <span slot="label">
              <svg class="icon icon-active"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-team"></use>
              </svg>
              &nbsp;我的团队</span>
            <el-table :data="teamData"
                      style="width: 100%">
              <el-table-column prop="taskTeam"
                               label="头像">
              </el-table-column>
              <el-table-column prop="taskName"
                               label="队名">
              </el-table-column>
              <el-table-column prop="taskTeacher"
                               label="队简介">
              </el-table-column>
              <el-table-column prop="taskTeam"
                               label="成员数">
              </el-table-column>
              <el-table-column prop="taskAction"
                               label="队长">
              </el-table-column>
              <el-table-column prop="taskAction"
                               label="操作">
              </el-table-column>
            </el-table>
          </el-tab-pane>
        </el-tabs>
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
      activeName: "mytask",
      taskData: [],
      resData: [],
      courseData: [],
      teamData: [],
      isEdit: false
    }
  },
  methods: {
    edit() {
      this.isEdit = true
    },
    sureChange(type) {
      let that = this
      if (type == "tel") {
        // ajax 修改tel
        this.MyAxios.post("/api/user/bind/tel", {
          phone: this.userInfo.phone
        })
          .then(function(response) {
            if (response.data.errcode != 0) console.log(response.data.errmsg)
          })
          .catch(function(error) {
            console.log(error)
          })
      } else if (type == "qq") {
        // ajax 修改 qq
        this.MyAxios.post("/api/user/bind/qq", {
          qq: this.userInfo.QQ
        })
          .then(function(response) {
            if (response.data.errcode != 0) console.log(response.data.errmsg)
          })
          .catch(function(error) {
            console.log(error)
          })
      }
      this.isEdit = false
      this.$store.commit("setUserInfo", this.userInfo)
    },
    reset() {
      this.isEdit = false
    },
    initTask() {
      let that = this
      this.MyAxios.get("/api/user/tasks")
        .then(function(response) {
          if (response.data.errcode == 0) that.taskData = response.data.data
          else console.log(response.data.errmsg)
        })
        .catch(function(error) {
          console.log(error)
        })
    },
    toTask(taskId) {
      window.open("/#/index/task/" + taskId)
    },
    leave(taskId, teamId, index) {
      let that = this
      this.$confirm("确定要退出次课题吗?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.MyAxios.post("/api/task/leave", {
            taskId: taskId,
            teamId: teamId
          })
            .catch(function(error) {
              alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
            })
            .then(function(response) {
              if (response.data.errcode == 0) {
                that.taskData.splice(index, 1)
                that.$message({
                  type: "success",
                  message: "退出成功!"
                })
              } else {
                that.$message({
                  type: "info",
                  message: "删除失败了!"
                })
              }
            })
        })
        .catch(() => {
          // this.$message({
          //   type: 'info',
          //   message: '已取消删除'
          // });
        })
    },
    handleClick(tab, event) {
      console.log(tab, event)
    }
  },
  computed: {
    userInfo: function() {
      return this.$store.state.userInfo
    }
  },
  mounted: function() {
    this.initTask()
  },
  activated: function() {
    this.$emit("changePage", "me")
  }
}
</script>


<style lang="stylus" scoped>
.popover-edit
  display flex
  align-items baseline
  justify-content space-around

.page
  width 100%
  height 100%
  background-color white
  flex-grow 1

  .page-content
    display flex
    flex-direction column
    width 65%
    margin 30px auto

    .user
      display flex

      .avatar
        width 80px
        height 80px
        border-radius 40px
        border 1px solid #ddd
        object-fit cover
        margin-right 20px

      .userInfo
        padding 8px 0

        .topInfo
          display flex
          align-items baseline

          .name
            font-size 21px
            font-weight 700
            color #212121

          .id
            margin-left 5px
            font-size 13px
            color #757575

        .bottomInfo
          margin-top 10px
          display flex

          .icon
            font-size 22px
            margin-right 5px
            cursor pointer
            color #bdbdbd

          .icon-active
            color #48aefb

    .detail
      margin-top 30px
</style>

<style>
.el-tabs__item {
  color: #969696;
  font-size: 16px;
}
</style>
