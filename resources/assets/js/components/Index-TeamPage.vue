<template>
  <div class="team">
    <div class="card-container"
          v-for="(item, index) in teamData"
          :key="index">
      <worlduc-teampageitem :data="item"></worlduc-teampageitem>
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
      teamData: null
    }
  },
  methods: {
    init() {
      let that = this
      this.MyAxios.get("/api/team/")
        .catch(function(error) {
          alert("数据获取发生了错误,请联系管理员 QQ:1450872874")
        })
        .then(function(response) {
          that.teamData = response.data.data
        })
    }
  },
  mounted: function() {
    this.init()
  },
  activated: function() {
    this.$emit("changePage", "team")
  }
}
</script>

<style lang="stylus" scoped>
@media screen and (min-width: 1440px)
  .card-container
    width 25%

@media screen and (max-width: 1440px) and (min-width: 1200px)
  .card-container
    width 33.333%

@media screen and (max-width: 1200px) and (min-width: 992px)
  .card-container
    width 50%

@media screen and (max-width: 992px) and (min-width: 768px)
  .card-container
    width 50%

@media screen and (max-width: 768px)
  .card-container
    width 100%

.team
  margin 20px auto
  display flex
  flex-wrap wrap
  width 80%
</style>