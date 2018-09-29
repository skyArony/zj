<template>
  <div class="page">
    <div class="index-search-container">
      <el-input v-model="keyword"
                @blur="keywordCheck"
                class="index-search"
                type="search"
                placeholder="搜索"
                prefix-icon="el-icon-search">
        <el-button slot="append"
                   icon="el-icon-search"
                   @click="search"></el-button>
      </el-input>
    </div>
    <div class="course">
      <div class="card-container"
           v-for="(item, index) in courseData2"
           :key="index">
        <worlduc-coursepageitem :data="item"></worlduc-coursepageitem>
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
      courseData: null,
      courseData2: null,
      keyword: ""
    }
  },
  methods: {
    init() {
      let that = this
      this.MyAxios.get("/api/course/")
        .then(function(response) {
          that.courseData = response.data.data.sort(function() {
            return 0.5 - Math.random()
          })
          that.courseData2 = that.courseData
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    search() {
      if (this.keyword == "") return
      let re = new RegExp(this.keyword)
      this.courseData2 = this.courseData.filter(function(item) {
        return re.test(item.name)
      })
    },
    keywordCheck() {
      if (this.keyword == "") this.courseData2 = this.courseData
    }
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

.page
  display flex
  flex-direction column

  .index-search-container
    margin 40px auto 20px auto
    width 50%

  .course
    margin 20px auto
    display flex
    flex-wrap wrap
    width 80%
</style>
