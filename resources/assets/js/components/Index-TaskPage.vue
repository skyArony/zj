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
    <div class="task">
      <div class="card"
           v-for="(item, index) in taskData2"
           :key="index"
           @click="toTask(item.id)">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <div class="card-info">
            <div class="card-info-title">{{item.title}}</div>
            <div class="card-info-desc">{{item.desc}}</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     :src="item.creater.avatar" />
                <div class="teacher-name">{{item.creater.name}}</div>
              </div>
              <div class="time">{{item.created_at.substr(0, 10)}}</div>
            </div>
          </div>
        </el-card>
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
      keyword: '',
      taskData: null,
      taskData2: null
    }
  },
  methods: {
    toTask(taksId) {
      this.$router.push({ path: `/index/task/${taksId}` })
    },
    init() {
      let that = this
      this.MyAxios.get("/api/task/")
        .catch(function(error) {
          alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
        })
        .then(function(response) {
          that.taskData = response.data.data.sort(function() {return .5 - Math.random()})
          that.taskData2 = that.taskData
        })
    },
    search() {
      if (this.keyword == '') return
      let re = new RegExp(this.keyword)
      this.taskData2 = this.taskData.filter(function(item) {
        return re.test(item.title)
      })
    },
    keywordCheck() {
      if (this.keyword == "") this.taskData2 = this.taskData
    }
  },
  mounted: function() {
    this.init()
  },
  activated: function() {
    this.$emit("changePage", "task")
  }
}
</script>

<style lang="stylus" scoped>
@media screen and (min-width: 1200px)
  .card
    width 33.333%

@media screen and (max-width: 1200px) and (min-width: 992px)
  .card
    width 50%

@media screen and (max-width: 992px) and (min-width: 768px)
  .card
    width 50%

@media screen and (max-width: 768px)
  .card
    width 100%

.page
  display flex
  flex-direction column

  .index-search-container
    margin 40px auto 20px auto
    width 50%

.task
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

      .card-info
        padding 14px

        .card-info-title
          width 100%
          overflow hidden
          text-overflow ellipsis
          white-space nowrap

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
          min-height 40px

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

          .time
            font-size 13px
            color #999
            flex-shrink 0
</style>