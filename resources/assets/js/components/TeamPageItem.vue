<template>
  <div class="card">
    <el-card shadow="hover"
             :body-style="{ padding: '0px' }">
      <div class="card-top">
        <img src="/storage/img/nologin.jpg"
             class="card-image" />
        <div class="card-info">
          <div class="card-info-title">猫猫队</div>
          <div class="card-info-desc">猫猫超级可爱猫猫超级可爱猫猫超级可爱猫猫超级可爱猫猫超级可爱猫猫超级可爱</div>
          <div class="card-info-bottom"
               @click="cardBottomVisible">
            <i v-if="cardBottom"
               class="el-icon-arrow-up"></i>
            <i v-else
               class="el-icon-arrow-down"></i>
          </div>
        </div>
      </div>
      <el-collapse-transition>
        <div v-show="cardBottom"
             class="card-bottom">
          <div class="card-bootom-content">
            <div class="member">
              <el-popover ref="leader"
                          placement="top"
                          width="200"
                          trigger="click">
                <div class="leader-info">
                  <div class="info-item">
                    <img width="19px"
                         height="19px"
                         src="/storage/img/user.png">杨帆&nbsp;
                    <el-tag size="mini"
                            type="info">队长</el-tag>
                  </div>
                  <div class="info-item">
                    <img width="19px"
                         height="19px"
                         src="/storage/img/phone.png">18890336732</div>
                  <div class="info-item">
                    <img width="19px"
                         height="19px"
                         src="/storage/img/QQ.png">1450872874</div>
                </div>
              </el-popover>
              <img v-popover="ll"
                   class="member-img member-leader"
                   src="/storage/img/nologin.jpg" />
            </div>
            <div class="member">
              <el-popover ref="leader"
                          placement="top"
                          width="200"
                          trigger="click">
                <div class="leader-info">
                  <div class="info-item">
                    <img width="19px"
                         height="19px"
                         src="/storage/img/user.png">杨帆&nbsp;
                    <el-tag size="mini"
                            type="info">队长</el-tag>
                  </div>
                  <div class="info-item">
                    <img width="19px"
                         height="19px"
                         src="/storage/img/phone.png">18890336732</div>
                  <div class="info-item">
                    <img width="19px"
                         height="19px"
                         src="/storage/img/QQ.png">1450872874</div>
                </div>
              </el-popover>
              <img v-popover="ll"
                   class="member-img"
                   src="/storage/img/nologin.jpg" />
            </div>
          </div>
        </div>
      </el-collapse-transition>
    </el-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cardBottom: false,
      ll: "leader"
    }
  },
  methods: {
    cardBottomVisible() {
      this.cardBottom = !this.cardBottom
    }
  }
}
</script>

<style lang="stylus" scoped>
.card
  padding 10px
  box-sizing border-box

  .el-card
    .card-top
      display flex
      box-shadow 0px 1px 3px 0px rgba(0, 0, 0, 0.2)

      .card-image
        width 117px
        height 117px
        object-fit cover

      .card-info
        padding 14px 14px 5px 14px

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
          justify-content center
          margin-top 10px

          i
            color #9e9e9e

          &:hover i
            color #212121

    .card-bootom-content
      width 100%
      display flex
      flex-wrap wrap
      padding 10px 10px 0 10px
      box-sizing border-box

      .member-img
        display flex
        width 34px
        height 34px
        border-radius 18px
        border solid 2px #fff
        margin-right 10px
        margin-bottom 10px

      .member-leader
        border solid 2px #409dfd

.leader-info
  display flex
  flex-direction column

  .info-item
    display flex
    align-items center

    img
      margin-right 10px

    & + .info-item
      margin-top 4px
</style>

