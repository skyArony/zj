<template>
  <div class="page-container">
    <div class="index-search-container">
      <el-input class="index-search"
                placeholder="搜索"
                prefix-icon="el-icon-search">
      </el-input>
    </div>
    <div class="index-body-container">
      <div class="team-card">
        <worlduc-teampageitem></worlduc-teampageitem>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
    };
  },
  methods: {
  }
}
</script>

<style lang="stylus" scoped>
@media screen and (min-width: 1200px)
  .team-card
    width 33.333%

@media screen and (max-width: 1200px) and (min-width: 992px)
  .team-card
    width 50%

@media screen and (max-width: 992px) and (min-width: 768px)
  .team-card
    width 50%

@media screen and (max-width: 768px)
  .team-card
    width 100%

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
.el-card__body {
  display: flex;
  flex-direction: column;
}
</style>
