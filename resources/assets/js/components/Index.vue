<template>
  <div class="index">
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
        <router-view @changePage="changePage"></router-view>
      </keep-alive>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      page: "", // 导航栏激活游标的位置
    }
  },
  methods: {
    changePage(page) {
      this.page = page
    }
  },
  mounted: function() {
  }
}
</script>

<style scoped>
.index {
  height: 100%;
  display: flex;
  flex-direction: column;
}
.page-container {
  width: 100%;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  display: flex;
}
</style>