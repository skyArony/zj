<template>
  <div class="course">
    <div class="card"
          v-for="(item, index) in courseData"
          :key="index">
      <el-card shadow="hover"
                :body-style="{ padding: '0px' }">
        <img :src="item.pic"
              class="card-image" />
        <div class="card-info">
          <div class="card-info-title">{{item.name}}</div>
          <div class="card-info-desc">{{item.intro}}</div>
          <div class="card-info-bottom">
            <div class="teacher">
              <img class="teacher-img"
                    :src="item.teacher.avatar" />
              <div class="teacher-name">{{item.teacher.name}}</div>
            </div>
          </div>
        </div>
      </el-card>
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
      courseData: null
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
    }
  },
  mounted: function() {
    this.init()
  },
  activated: function () {
    this.$emit('changePage', 'course')
  }
}
</script>

<style lang="stylus" scoped>
@media screen and (min-width: 1280px)
  .card
    width 25%

@media screen and (max-width: 1280px) and (min-width: 992px)
  .card
    width 33.333%

@media screen and (max-width: 992px) and (min-width: 650px)
  .card
    width 50%

@media screen and (max-width: 650px)
  .card
    width 100%

.course
  margin 20px auto
  display flex
  flex-wrap wrap
  width 80%

  .card
    padding 10px
    box-sizing border-box

    .el-card
      .card-image
        width 100%
        height 163px
        object-fit cover

      .card-info
        padding 14px

        .card-info-title
          width 100%
          overflow hidden
          text-overflow ellipsis
          white-space nowrap

        .card-info-desc2
          width 100%
          display -webkit-box
          overflow hidden
          text-overflow ellipsis
          word-break break-all
          -webkit-box-orient vertical
          -webkit-line-clamp 10
          font-size 14px
          color #757575
          margin-top 10px

        .card-info-desc
          width 100%
          display -webkit-box
          overflow hidden
          text-overflow ellipsis
          word-break break-all
          -webkit-box-orient vertical
          -webkit-line-clamp 2
          font-size 14px
          color #757575
          margin-top 10px

        .card-info-bottom
          display flex
          justify-content space-between
          align-items center
          margin-top 10px

          .teacher
            display flex
            align-items center
            flex-grow 1
            overflow hidden

            .teacher-img
              width 30px
              height 30px
              border-radius 15px
              object-fit cover

            .teacher-name
              font-size 13px
              margin-left 5px
              overflow hidden
              text-overflow ellipsis
              white-space nowrap
</style>
