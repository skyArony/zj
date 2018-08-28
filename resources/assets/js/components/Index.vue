<template>
  <div>
    <worlduc-topnav @handleSelect='changePage'></worlduc-topnav>
    <div id="page-body">
      <worlduc-taskpage v-if="pageIndex == 1"
                        :data="taskData"></worlduc-taskpage>
      <worlduc-teampage v-else-if="pageIndex == 2"
                        :data="teamData"></worlduc-teampage>
      <worlduc-coursepage v-else-if="pageIndex == 3"
                          :data="courseData"></worlduc-coursepage>
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
      pageIndex: "1",
      taskData: null,
      teamData: null,
      courseData: null
    }
  },
  methods: {
    changePage(key, keyPath) {
      let that = this
      this.pageIndex = key[0]
      if (this.pageIndex == '1' && this.taskData == null) {
        this.MyAxios.get("/api/task/")
          .catch(function(error) {
            alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
          })
          .then(function(response) {
            that.taskData = response.data.data
          })
      } else if (this.pageIndex == '2' && this.teamData == null) {
        this.MyAxios.get("/api/team/")
          .catch(function(error) {
            alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
          })
          .then(function(response) {
            that.teamData = response.data.data
          })
      } else if (this.pageIndex == '3' && this.courseData == null) {
        this.MyAxios.get("/api/course/")
          .catch(function(error) {
            alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
          })
          .then(function(response) {
            that.courseData = response.data.data
          })
      }
    }
  },
  mounted: function() {
    this.changePage(['1'], null)
  }
}
</script>

<style lang="stylus" scoped>
#page-body
  width 100%
</style>
