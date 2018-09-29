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
    <div class="team">
      <div class="card-container"
           v-for="(item, index) in teamData2"
           :key="index">
        <worlduc-teampageitem :data="item"></worlduc-teampageitem>
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
      keyword: "",
      teamData: null,
      teamData2: null
    }
  },
  methods: {
    init() {
      let that = this
      this.MyAxios.get("/api/team/")
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
        .then(function(response) {
          that.teamData = response.data.data.sort(function() {return .5 - Math.random()})
          that.teamData2 = that.teamData
        })
    },
    search() {
      if (this.keyword == "") return
      let re = new RegExp(this.keyword)
      this.teamData2 = this.teamData.filter(function(item) {
        return re.test(item.team_name)
      })
    },
    keywordCheck() {
      if (this.keyword == "") this.teamData2 = this.teamData
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

.page
  display flex
  flex-direction column

  .index-search-container
    margin 40px auto 20px auto
    width 50%

.team
  margin 20px auto
  display flex
  flex-wrap wrap
  width 80%
</style>