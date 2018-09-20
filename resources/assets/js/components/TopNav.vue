<template>
  <div class="nav-container">
    <el-menu :default-active="page"
             class="index-topnav"
             mode="horizontal"
             @select="handleSelect">
      <el-menu-item index="task">科研课题</el-menu-item>
      <el-menu-item index="team">研究团队</el-menu-item>
      <el-menu-item index="course">课程中心</el-menu-item>
      <el-menu-item index="me" id="userInfo">
        <img :src="userImg"
             class="userImg" />
        <a href="/admin/profile">{{userName}}</a>
      </el-menu-item>
    </el-menu>
  </div>
</template>

<script>
export default {
  props: {
    page: String
  },
  data() {
    return {
      MyAxios: axios.create({
        headers: { "Content-Type": "application/json" }
      }),
      userImg: "/storage/img/nologin.jpg",
      userName: "游客",
    }
  },
  methods: {
    // 处理 tab 切换
    handleSelect(key, keyPath) {
      this.$router.push("/index/" + key)
    },
    // init
    init() {
      // 个人信息
      let that = this
      this.MyAxios.get("/api/me")
        .catch(function(error) {
          if (error.response.data.errcode == -4007) {
            that.userName = "游客"
            that.userImg = "/storage/img/nologin.jpg"
          }
          console.log(error)
        })
        .then(function(response) {
          if (response.data.errcode === 0) {
            that.$store.commit("setUserInfo", response.data.data);
            that.userName = response.data.data.name
            that.userImg = response.data.data.avatar
          } else {
            console.log(response.data.errmsg)
          }
        })
    }
  },
  mounted: function() {
    this.init()
  }
}
</script>

<style lang="stylus" scoped>
.nav-container
  width 100%
  background-color white
  border-bottom solid 1px #e6e6e6

  @media screen and (min-width: 1161px)
    .index-topnav
      width 80%

  .index-topnav
    margin 0 auto
    padding 0
    border-bottom none
    position relative

    @media screen and (max-width: 405px)
      .el-menu-item
        padding 0 10px

    #userInfo
      position absolute
      right 0

      .userImg
        width 36px
        height 36px
        border-radius 18px
        margin-right 10px
        box-shadow 0 2px 10px rgba(0, 0, 0, 0.05)
</style>
