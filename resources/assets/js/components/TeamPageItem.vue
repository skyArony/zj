<template>
  <div class="card">
    <el-card shadow="hover"
             :body-style="{ padding: '0px' }">
      <div class="card-top">
        <img :src="'/storage/' + data.avatar"
             class="card-image" />
        <div class="card-info">
          <div class="card-info-title">{{data.team_name}}</div>
          <div class="card-info-desc">{{data.team_desc}}</div>
          <div class="card-info-bottom"
               @click="cardBottomVisible(data.id)">
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
            <div class="member"
                 v-for="(item, index) in members"
                 :key="index">
              <el-popover placement="top"
                          width="200"
                          trigger="click">
                <div class="leader-info">
                  <div class="info-item">
                    <svg class="iconIn"
                         slot="reference"
                         aria-hidden="true">
                      <use xlink:href="#icon-user"></use>
                    </svg>
                    {{item.name}}&nbsp;
                    <el-tag v-if="item.isLeader"
                            size="mini"
                            type="info">队长</el-tag>
                  </div>
                  <div class="info-item">
                    <svg class="iconIn"
                         slot="reference"
                         aria-hidden="true">
                      <use xlink:href="#icon-phone"></use>
                    </svg>
                    {{item.phone}}
                  </div>
                  <div class="info-item">
                    <svg class="iconIn"
                         slot="reference"
                         aria-hidden="true">
                      <use xlink:href="#icon-qq"></use>
                    </svg>
                    {{item.QQ}}
                  </div>
                </div>
                <img slot="reference"
                     class="member-img"
                     :class="{'member-leader' : item.isLeader}"
                     :src="item.avatar" />
              </el-popover>

            </div>
          </div>
        </div>
      </el-collapse-transition>
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
      MyAxios: axios.create({
        headers: { "Content-Type": "application/json" }
      }),
      members: [
        {
          avatar:
            "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACIAAAAiCAYAAAA6RwvCAAABDWlDQ1BJQ0MgUHJvZmlsZQAAKJFjYGCSSCwoyGESYGDIzSspCnJ3UoiIjFJgf8TAwSDDIMjAyWCSmFxc4BgQ4MMABDAaFXy7xsAIoi/rgszClMcLuFJSi5OB9B8gTkkuKCphYGBMALKVy0sKQOwWIFskKRvMngFiFwEdCGSvAbHTIewDYDUQ9hWwmpAgZyD7BZDNlwRh/wCx08FsJg4QG2ov2A2OQHenKgB9T6LjCYGS1IoSEO2cX1BZlJmeUaIAsckzL1lPR8HIwNCCgQEU3hDVnwPB4cgodgYhhgAIscq9wJgIYmBg2YkQCwP6b40+A4MsM0JMTYmBQaiegWFjQXJpURnUGEbGswwMhPgAgfZLpC0QFk8AAAAJcEhZcwAAFiUAABYlAUlSJPAAAABOSURBVFgJ7dKxEQAQFAVB9N8zRrgVCE72sj/r5r5vfPDWBze8EzrEn0gkEQXcNZKIAu4aSUQBd40kooC7RhJRwF0jiSjgrpFEFHDXiCIH9m4EQPWRytQAAAAASUVORK5CYII=",
          isLeader: true
        }
      ],
      cardBottom: false
    }
  },
  methods: {
    cardBottomVisible(teamId) {
      let that = this
      // 显示
      this.cardBottom = !this.cardBottom
      // 数据获取
      if (this.members.length == 1 && !this.members[0].id) {
        this.MyAxios.get("/api/team/member/" + teamId)
          .then(function(response) {
            that.members = response.data.data
          })
          .catch(function(error) {
            alert(error.response.data.errmsg)
          })
      }
    }
  }
}
</script>

<style lang="stylus" scoped>
.iconIn
  font-size 18px
  margin-right 5px
  color #48aefb

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
        flex-grow 1

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

    & + .info-item
      margin-top 4px
</style>

