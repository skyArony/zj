<template>
  <div>
    <worlduc-topnav :page="page"></worlduc-topnav>
    <!-- <div class="index-search-container">
      <el-input class="index-search"
                placeholder="搜索"
                prefix-icon="el-icon-search">
      </el-input>
    </div> -->
    <div id="page-body">
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
      page: ""
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

<style lang="stylus" scoped>
#page-body
  width 100%
</style>

<style>
.page-container {
  width: 100%;
  display: flex;
  flex-direction: column;
}
.index-search-container {
  width: 100%;
  display: flex;
}
.index-search {
  width: 60%;
  margin: 30px auto;
  margin-bottom: 15px;
  text-align: center;
  justify-content: center;
}
.index-search input {
  border-radius: 20px;
}

.index-body-container {
  margin: 20px auto;
  width: 80%;
  display: flex;
  flex-wrap: wrap;
}
.el-card__body {
  display: flex;
  flex-direction: column;
}
</style>