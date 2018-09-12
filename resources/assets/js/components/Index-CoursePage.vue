<template>
  <div class="course">
    <div class="card-container"
         v-for="(item, index) in courseData"
         :key="index">
      <worlduc-coursepageitem :data="item"></worlduc-coursepageitem>
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
      courseData: null,
    }
  },
  methods: {
    init() {
      let that = this
      this.MyAxios.get("/api/course/")
        .catch(function(error) {
          alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
        })
        .then(function(response) {
          that.courseData = response.data.data
        })
    },
  },
  mounted: function() {
    this.init()
  },
  activated: function() {
    this.$emit("changePage", "course")
  }
}
</script>

<style lang="stylus" scoped>
@media screen and (min-width: 1280px)
  .card-container
    width 25%

@media screen and (max-width: 1280px) and (min-width: 992px)
  .card-container
    width 33.333%

@media screen and (max-width: 992px) and (min-width: 650px)
  .card-container
    width 50%

@media screen and (max-width: 650px)
  .card-container
    width 100%

.course
  margin 20px auto
  display flex
  flex-wrap wrap
  width 80%
</style>
