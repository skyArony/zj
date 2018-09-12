<template>
  <div>
    <worlduc-topnav :page="page"
                    class="topnav"></worlduc-topnav>
    <!-- <div class="index-search-container">
      <el-input class="index-search"
                placeholder="搜索"
                prefix-icon="el-icon-search">
      </el-input>
    </div> -->
    <div class="page-container">
      <keep-alive>
        <router-view @changePage="changePage" :teams="teams"></router-view>
      </keep-alive>
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
      page: "", // 导航栏激活游标的位置
      teams: []
    }
  },
  methods: {
    changePage(page) {
      this.page = page
    },
    getTeams() {
      let that = this
      this.MyAxios.get("/api/userId/team/")
        .catch(function(error) {
          alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
        })
        .then(function(response) {
          that.teams = response.data.data
        })
    }
  },
  mounted: function() {
    this.getTeams()
  }
}
</script>

<style scoped>
.page-container {
  width: 100%;
  display: flex;
  flex-direction: column;
}
</style>