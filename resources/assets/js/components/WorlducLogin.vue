<template>
  <div class="container"
       v-loading.fullscreen.lock="fullscreenLoading">
    <form target="nm_iframe"
          ref="form"
          method="POST"
          action="http://worlduc.com/SpaceManage/Space/UserLove.aspx">
      <input type="hidden"
             name="AppreciateMen"
             :value="AppreciateMen" />
      <input type="hidden"
             name="Favourite"
             value="" />
      <input type="hidden"
             name="FavMusics"
             value="" />
      <input type="hidden"
             name="FavMovies"
             value="" />
      <input type="hidden"
             name="FavCartoons"
             value="" />
      <input type="hidden"
             name="FavGames"
             value="" />
      <input type="hidden"
             name="FavSports"
             value="" />
      <input type="hidden"
             name="FavBooks"
             value="" />
      <input type="hidden"
             name="FavAdages"
             value="" />
      <input type="hidden"
             name="Presetation"
             value="" />
      <input type="hidden"
             name="Type"
             value="Edit" />
      <el-button type="primary"
                 @click="login">直接登陆</el-button>
      <el-button type="primary"
                 @click="toLogin">账密登陆</el-button>
    </form>
    <iframe id="id_iframe"
            name="nm_iframe"
            style="display:none;"></iframe>
  </div>
</template>

<script>
export default {
  data() {
    return {
      MyAxios: axios.create({
        headers: { "Content-Type": "application/json" }
      }),
      AppreciateMen: "",
      uid: "",
      fullscreenLoading: false
    }
  },
  methods: {
    login() {
      if (this.AppreciateMen == "") {
        alert("首次登陆,请点击「账密登陆」哦")
        return
      }
      this.$refs.form.submit()
      this.fullscreenLoading = true
      let that = this
      setTimeout(() => {
        this.MyAxios.get("/loginKeyCheck?uid=" + this.uid)
          .then(function(response) {
            that.fullscreenLoading = false
            location.href = "/admin/"
          })
          .catch(function(error) {
            that.fullscreenLoading = false
            that.$notify({
              title: "警告",
              message: "登陆失败,请确认已经登陆大学城",
              type: "error"
            })
          })
      }, 2000)
    },
    toLogin() {
      location.href = "/admin/login"
    }
  },
  mounted: function() {
    // 页面提示
    this.$notify.info({
      title: "提示",
      message:
        "若已经登陆大学城,可以点击「直接登陆」,否则请「先登录大学城」或者点击「账密登陆」",
      duration: 0
    })
    // uid 参数获取,登陆 key 获取
    this.uid = window.location.href.match(/.*?uid=(\d+)/)[1]
    let that = this
    this.MyAxios.get("/api/loginKey?uid=" + this.uid)
      .then(function(response) {
        that.AppreciateMen = response.data.data
      })
      .catch(function(error) {
        that.$notify({
          title: "警告",
          message: "你是第一次登陆系统,请点击「账密登陆」",
          type: "warning"
        })
      })
  }
}
</script>


<style lang="stylus" scoped>
.container
  width 100%
  height 100%
  display flex
  justify-content center
  align-items center
</style>
