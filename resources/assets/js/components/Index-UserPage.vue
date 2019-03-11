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
              <svg class="iconIn"
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
              <svg class="iconIn"
                   :class="[userInfo.QQ && !isEdit ? 'icon-active' : '']"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-qq"></use>
              </svg>
            </el-popover>
          </div>
        </div>
      </div>
      <div class="detail"
           v-if="role == 4">
        <el-tabs v-model="activeName"
                 stretch
                 @tab-click="handleClick">
          <el-tab-pane name="mytask">
            <span slot="label">
              <svg class="iconIn icon-active"
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
                               label="课题状态"
                               :filters="[{ text: '已过期', value: 'past' }, { text: '未过期', value: 'working' }]"
                               :filter-method="taskStatusFilter"
                               :filter-multiple=false
                               filter-placement="bottom-end">
                <template slot-scope="scope">
                  <el-tag :type="scope.row.time === '已过期' ? 'info' : 'success'"
                          disable-transitions>{{scope.row.time === '已过期' ? '' : '剩'}}{{scope.row.time}}</el-tag>
                </template>
              </el-table-column>
              <el-table-column prop="isSubmit"
                               label="提交状态"
                               :filters="[{ text: '已提交', value: 'submit' }, { text: '未提交', value: 'nosubmit' }]"
                               :filter-method="taskSubmitFilter"
                               :filter-multiple=false
                               filter-placement="bottom-end">
                <template slot-scope="scope">
                  <el-tag :type="scope.row.isSubmit === true ? 'success' : 'info'"
                          plain>{{scope.row.isSubmit === true ? '已提交' : '未提交'}}</el-tag>
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
                               @click="leaveTask(scope.row.taskId, scope.row.teamId, scope.$index)">退出</el-button>
                  </div>
                </template>
              </el-table-column>
            </el-table>
          </el-tab-pane>
          <el-tab-pane name="myresult">
            <span slot="label">
              <svg class="iconIn icon-active"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-success"></use>
              </svg>
              &nbsp;科研成果</span>
            <el-table :data="resData"
                      style="width: 100%">
              <el-table-column prop="title"
                               label="成果"
                               min-width="100px">
              </el-table-column>
              <el-table-column prop="task"
                               label="课题"
                               min-width="180px">
              </el-table-column>
              <el-table-column prop="team"
                               label="团队"
                               sortable>
              </el-table-column>
              <el-table-column prop="created_at"
                               label="提交时间"
                               sortable
                               width="170px">
              </el-table-column>
              <el-table-column prop="action"
                               label="操作"
                               width="75px">
                <template slot-scope="scope">
                  <el-button size="mini"
                             type="primary"
                             @click="toResult(scope.row.id)">查看</el-button>
                </template>
              </el-table-column>
            </el-table>
          </el-tab-pane>
          <el-tab-pane name="myansrec">
            <span slot="label">
              <svg class="iconIn icon-active"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-course"></use>
              </svg>
              &nbsp;我的课程</span>
            <el-table :data="surveyRecordList"
                      style="width: 100%">
              <el-table-column prop="course"
                               label="课程"
                               sortable>
              </el-table-column>
              <el-table-column prop="score"
                               label="得分"
                               min-width="50px">
              </el-table-column>
              <el-table-column prop="updated_at"
                               label="填写时间"
                               sortable
                               width="170px">
              </el-table-column>
              <el-table-column prop="action"
                               label="操作"
                               width="140px">
                <template slot-scope="scope">
                  <div style="display:flex">
                    <el-button size="mini"
                               type="primary"
                               @click="toCustomCourse(scope.row.course_id)">查看</el-button>
                    <el-button size="mini"
                               type="danger"
                               @click="deleteSurRec(scope.row.id, scope.$index)">删除</el-button>
                  </div>
                </template>
              </el-table-column>
            </el-table>
          </el-tab-pane>
          <el-tab-pane name="myteam">
            <span slot="label">
              <svg class="iconIn icon-active"
                   slot="reference"
                   aria-hidden="true">
                <use xlink:href="#icon-team"></use>
              </svg>
              &nbsp;我的团队</span>
            <el-table :data="teamData"
                      style="width: 100%">
              <el-table-column prop="avatar"
                               label="头像"
                               width="80px">
                <template slot-scope="scope">
                  <img :src="'/storage/' + scope.row.avatar" />
                </template>
              </el-table-column>
              <el-table-column prop="team"
                               label="队名"
                               min-width="50px">
              </el-table-column>
              <el-table-column prop="leader"
                               label="队长"
                               width="80px">
              </el-table-column>
              <el-table-column prop="memberNum"
                               label="成员数"
                               width="75px">
              </el-table-column>
              <el-table-column prop="desc"
                               label="队简介"
                               min-width="140px">
              </el-table-column>
              <el-table-column prop="action"
                               label="操作"
                               width="75px"
                               :filters="[{ text: '我创建的', value: 'myCreate' }, { text: '我参与的', value: 'myPartic' }]"
                               :filter-method="teamActionFilter"
                               :filter-multiple=false
                               filter-placement="bottom-end">
                <template slot-scope="scope">
                  <el-button v-if="scope.row.isLeader"
                             size="mini"
                             type="danger"
                             @click="dissolveTeam(scope.row.id, scope.$index)">解散</el-button>
                  <el-button v-else
                             size="mini"
                             type="danger"
                             @click="leaveTeam(scope.row.id, scope.$index)">退出</el-button>
                </template>
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
      surveyRecordList: [],
      teamData: [],
      isEdit: false,
      role: ""
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
        }).catch(function(error) {
          alert(error.response.data.errmsg)
        })
      } else if (type == "qq") {
        // ajax 修改 qq
        this.MyAxios.post("/api/user/bind/qq", {
          qq: this.userInfo.QQ
        })
          .catch(function(error) {
            alert(error.response.data.errmsg)
          })
          .then(function() {
            location.href = "/socialite/bind/qq"
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
          that.taskData = response.data.data
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    toTask(taskId) {
      // window.open("/#/index/task/" + taskId)
      location.href = "/#/index/task/" + taskId
    },
    toResult(resultId) {
      // window.open("/#/index/task/" + taskId)
      location.href = "/#/index/result/" + resultId
    },
    toCustomCourse(courseId) {
      // window.open("/#/index/customCourse/" + customCourseId)
      location.href = "/#/index/customCourse/" + courseId
    },
    // 退出课题
    leaveTask(taskId, teamId, index) {
      let that = this
      this.$confirm("确定要退出次课题吗?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      }).then(() => {
        this.MyAxios.post("/api/task/leave", {
          taskId: taskId,
          teamId: teamId
        })
          .then(function(response) {
            that.taskData.splice(index, 1)
            that.$message({
              type: "success",
              message: "退出课题成功!"
            })
          })
          .catch(function(error) {
            that.$message({
              type: "info",
              message: "退出课题失败了!" + error.response.data.errmsg
            })
          })
      })
    },
    // 删除问卷填写记录
    deleteSurRec(id, index) {
      let that = this
      this.$confirm("确定要删除这个定制课程吗?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      }).then(() => {
        this.MyAxios.delete("/api/surveyRecord/" + id)
          .then(function(response) {
            that.surveyRecordList.splice(index, 1)
            that.$message({
              type: "success",
              message: "删除课程成功!"
            })
          })
          .catch(function(error) {
            that.$message({
              type: "info",
              message: "删除课程失败了!" + error.response.data.errmsg
            })
          })
      })
    },
    // 解散团队
    dissolveTeam(teamId, index) {
      let that = this
      this.$confirm("作为队长,确定要解散这个团队吗?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      }).then(() => {
        this.MyAxios.delete("/api/team/" + teamId)
          .then(function(response) {
            that.teamData.splice(index, 1)
            that.$message({
              type: "success",
              message: "解散团队成功!"
            })
          })
          .catch(function(error) {
            that.$message({
              type: "info",
              message: "解散团队失败了!" + error.response.data.errmsg
            })
          })
      })
    },
    // 退出团队
    leaveTeam(teamId, index) {
      let that = this
      this.$confirm("确定要退出这团队吗?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      }).then(() => {
        this.MyAxios.delete("/api/user/team/" + teamId)
          .then(function(response) {
            that.teamData.splice(index, 1)
            that.$message({
              type: "success",
              message: "退出团队成功!"
            })
          })
          .catch(function(error) {
            that.$message({
              type: "info",
              message: "退出团队失败了!" + error.response.data.errmsg
            })
          })
      })
    },
    initResults() {
      let that = this
      this.MyAxios.get("/api/user/results")
        .then(function(response) {
          that.resData = response.data.data
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    initAnsRec() {
      let that = this
      this.MyAxios.get("/api/surveyRecord")
        .then(function(response) {
          that.surveyRecordList = response.data.data
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    initTeam() {
      let that = this
      this.MyAxios.get("/api/user/teams")
        .then(function(response) {
          that.teamData = response.data.data
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    handleClick(tab, event) {
      if (tab.name == "myresult" && this.resData.length == 0) {
        this.initResults()
      } else if (tab.name == "myansrec" && this.surveyRecordList.length == 0) {
        this.initAnsRec()
      } else if (tab.name == "myteam" && this.teamData.length == 0) {
        this.initTeam()
      }
    },
    teamActionFilter(value, row) {
      if (value == "myCreate") return row.isLeader === true
      else if (value == "myPartic") return row.isLeader === false
    },
    taskStatusFilter(value, row) {
      if (value == "past") return row.time == "已过期"
      else if (value == "working") return row.time != "已过期"
    },
    taskSubmitFilter(value, row) {
      if (value == "submit") return row.isSubmit == true
      else if (value == "nosubmit") return row.isSubmit == false
    },
    roleDeal() {
      let token = document.cookie.match(/token=(.*?); /)[1]
      let yyyy = token.split(".")[1]
      let arr = JSON.parse(window.atob(yyyy))
      this.role = arr.role
    }
  },
  computed: {
    userInfo: function() {
      return this.$store.state.userInfo
    }
  },
  mounted: function() {
    this.initTask()
    this.roleDeal()
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

          .iconIn
            font-size 22px
            margin-right 5px
            cursor pointer
            color #bdbdbd

          .icon-active
            color #48aefb

    .detail
      margin-top 30px

      img
        width 50px
        height 50px
        object-fit base-conver
</style>

<style>
.el-tabs__item {
  color: #969696;
  font-size: 16px;
}
</style>
