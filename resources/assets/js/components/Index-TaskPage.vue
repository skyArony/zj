<template>
  <div class="page-container">
    <div class="index-search-container">
      <el-input class="index-search"
                placeholder="搜索"
                prefix-icon="el-icon-search">
      </el-input>
    </div>
    <div class="index-body-container">
      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
              <div class="time">2018/08/24</div>
            </div>
          </div>
        </el-card>
      </div>
      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
              <div class="time">2018/08/24</div>
            </div>
          </div>
        </el-card>
      </div>
      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
              <div class="time">2018/08/24</div>
            </div>
          </div>
        </el-card>
      </div>
      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
              <div class="time">2018/08/24</div>
            </div>
          </div>
        </el-card>
      </div>
      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
              <div class="time">2018/08/24</div>
            </div>
          </div>
        </el-card>
      </div>
      <div class="card">
        <el-card shadow="hover"
                 :body-style="{ padding: '0px' }">
          <div class="card-info">
            <div class="card-info-title">好吃的汉堡-好吃的汉堡-好吃的汉堡</div>
            <div class="card-info-desc">好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍好吃汉堡的介绍</div>
            <div class="card-info-bottom">
              <div class="teacher">
                <img class="teacher-img"
                     src="/storage/img/nologin.jpg" />
                <div class="teacher-name">湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟湘潭大学-邹娟</div>
              </div>
              <div class="time">2018/08/24</div>
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
      currentDate: new Date()
    };
  },
  methods: {

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
  text-align: center;
  justify-content: center;
}
.index-search input {
  border-radius: 20px;
}

.index-body-container {
  margin: 0 auto;
  width: 80%;
  display: flex;
  flex-wrap: wrap;
}
</style>
