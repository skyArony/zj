<template>
  <div>
    <worlduc-topnav @handleSelect='changePage'></worlduc-topnav>
    <div id="page-body">
      <worlduc-taskpage v-if="pageIndex == 1"></worlduc-taskpage>
      <worlduc-teampage v-else-if="pageIndex == 2"></worlduc-teampage>
      <worlduc-coursepage v-else-if="pageIndex == 3"></worlduc-coursepage>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      pageIndex: 1
    }
  },
  methods: {
    changePage(key, keyPath) {
      this.pageIndex = key[0]
    }
  }
}
</script>

<style lang="stylus" scoped>
#page-body
  width 100%
</style>
