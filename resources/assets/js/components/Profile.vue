<template>
  <div class="profile-container">
    <div>
      <el-button type="primary"
                 disabled
                 round>身份: {{role}}</el-button>
      <el-button type="primary"
                 round
                 @click="toWorlduc">我的大学城</el-button>
      <el-button type="info"
                 round
                 @click="mailToAdmin">反馈问题</el-button>
    </div>
  </div>
  <!-- <div class="profile-container">
    <div class="profile-panel">
      <div class="pannel-header">
        <font>角色</font>
      </div>
      <div class="pannel-body">
        <el-button type="info"
                   round
                   disabled
                   class="btn-pannel-body">教师</el-button>
      </div>
    </div>
    <div class="profile-panel">
      <div class="pannel-header">
        <font>大学城</font>
      </div>
      <div class="pannel-body">
        <el-button type="info"
                   round
                   plain
                   class="btn-pannel-body">我的大学城</el-button>
      </div>
    </div>
    <div class="profile-panel">
      <div class="pannel-header">
        <font>绑定信息</font>
      </div>
      <div class="pannel-body">
        <el-button type="info"
                   round
                   plain
                   class="btn-pannel-body">绑定 QQ</el-button>
        <el-button type="info"
                   round
                   plain
                   class="btn-pannel-body">绑定微信</el-button>
        <el-button type="success"
                   round
                   class="btn-pannel-body">QQ 已绑定</el-button>
        <el-button type="success"
                   round
                   class="btn-pannel-body">微信已绑定</el-button>
      </div>
    </div>
    <div class="profile-panel">
      <div class="pannel-header">
        <font>用户数据</font>
      </div>
      <div class="pannel-body">
        <el-table :data="tableData"
                  style="width: 100%">
          <el-table-column prop="type"
                           align="left"
                           label="类别"
                           width="141">
          </el-table-column>
          <el-table-column prop="num"
                           align="left"
                           label="数目"
                           width="141">
          </el-table-column>
        </el-table>
      </div>
    </div>
  </div> -->
</template>

<script>
export default {
  data() {
    return {
      role: "",
      userId: ""
      // tableData: [
      //   {
      //     type: "课程",
      //     num: "4",
      //   },
      //   {
      //     type: "问卷",
      //     num: "4",
      //   },
      //   {
      //     type: "填写用户",
      //     num: "19",
      //   },
      //   {
      //     type: "用户数",
      //     num: "120",
      //   }
      // ]
    }
  },
  methods: {
    toWorlduc() {
      location.href =
        "http://worlduc.com/SpaceShow/Index.aspx?uid=" + this.userId
    },
    mailToAdmin() {
      location.href = "mailto:sky.arony@qq.com"
    }
  },
  mounted: function() {
    let that = this
    let MyAxios = axios.create()
    MyAxios.get("/api/me")
      .then(function(response) {
        let roleId = response.data.data.role_id
        if (roleId == 1) that.role = "超级管理员"
        else if (roleId == 2) that.role = "管理员"
        if (roleId == 3) that.role = "教师"
        if (roleId == 4) that.role = "学生"
        that.userId = response.data.data.id
      })
      .catch(function(error) {
        alert(error.response.data.errmsg)
      })
  }
}
</script>

<style scoped>
.profile-container {
  width: 100%;
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
}
.profile-panel {
  width: 282px;
  height: 477px;
  border-radius: 8px;
  margin-bottom: 20px;
  position: relative;
  overflow: hidden;
  background-color: #fafafa;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2),
    0 1px 5px 0 rgba(0, 0, 0, 0.12);
}
.pannel-header {
  position: relative;
  height: 3rem;
  background-color: #03a9f4;
  font-size: 20px;
  font-weight: 400;
  color: #eeeeee;
  display: flex;
  justify-content: center;
  align-items: center;
}
.btn-pannel-body {
  margin-top: 20px;
}
</style>


