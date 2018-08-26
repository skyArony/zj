<template>
  <div class="nav-container">
    <el-menu :default-active="activeIndex"
             class="index-topnav"
             mode="horizontal"
             @select="handleSelect">
      <el-menu-item index="1">科研课题</el-menu-item>
      <el-menu-item index="2">研究团队</el-menu-item>
      <el-menu-item index="3">课程中心</el-menu-item>
      <el-menu-item index="4"
                    id="userInfo">
        <img :src="userImg"
             class="userImg" />
        <a href="/admin/profile">{{userName}}</a>
      </el-menu-item>
    </el-menu>
  </div>
</template>

<script>
export default {
  data() {
    return {
      userImg: "/storage/img/nologin.jpg",
      userName: "游客",
      activeIndex: '1',
    };
  },
  methods: {
    handleSelect(key, keyPath) {
      this.$emit('handleSelect', key, keyPath)
    }
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
        padding: 0 10px;

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
