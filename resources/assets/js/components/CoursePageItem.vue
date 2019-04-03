<template>
  <div class="card"
       @click="toCourse(data.id)">
    <el-card shadow="hover"
             :body-style="{ padding: '0px' }">
      <img :src="data.pic"
           class="card-image" />
      <div class="card-info">
        <div class="card-info-title">{{data.name}}</div>
        <div class="card-info-desc">{{data.intro}}</div>
        <div class="card-info-bottom">
          <div class="teacher">
            <img class="teacher-img"
                 :src="data.teacher.avatar" />
            <div class="teacher-name">{{data.teacher.name}}</div>
          </div>
          <el-button v-if="role == 4"
                     type="primary"
                     class="button"
                     size="mini"
                     @click.stop="toAutoSurvey(data.id)"
                     plain>定制课程</el-button>
          <!-- <el-popover placement="bottom"
                      trigger="hover">
            <el-table :data="data.surveys"
                      max-height="300">
              <el-table-column prop="title"
                               label="可选问卷"
                               header-align="center"
                               width="280">
                <template slot-scope="scope">
                  <div class="surveyTitle" @click="toSurvey(scope.row.id)">{{scope.row.title}}</div>
                </template>
              </el-table-column> -->
          <!-- <el-table-column fixed="right"
                               label="操作">
                <template slot-scope="scope">
                  <el-button @click.native.prevent="toSurvey(scope.row.id)"
                             type="text"
                             size="small">
                    填写
                  </el-button>
                </template>
              </el-table-column> -->
          <!-- </el-table>
            <el-button slot="reference"
                       type="primary"
                       class="button"
                       size="mini"
                       @click.stop=";"
                       plain>定制课程</el-button>
          </el-popover> -->
        </div>
      </div>
    </el-card>
  </div>
</template>

<script>
export default {
  props: {
    data: Object
  },
  data() {
    return {
      role: ""
    }
  },
  methods: {
    toCourse(courseId) {
      this.$router.push({ path: `/index/video/course/${courseId}` })
    },
    toAutoSurvey(courseId) {
      location.href = "/autosurvey/" + courseId
    },
    roleDeal() {
      let yyy = document.cookie.match(/token=(\w+)\.(\w+)\.(\w+)/)[2]
      let arr = JSON.parse(window.atob(yyy))
      this.role = arr.role
    }
  },
  mounted: function() {
    this.roleDeal()
  }
}
</script>

<style lang="stylus" scoped>
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

.surveyTitle
  overflow hidden
  text-overflow ellipsis
  white-space nowrap
  margin 0

  &:hover
    color #409dfd
    cursor pointer
</style>
