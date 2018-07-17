<template>
  <div class="grid-option-edit">
    <div v-if="isShow !== null">
      <el-row>
        <font>问题:</font>
      </el-row>
      <el-row class="row-main">
        <font>{{question.question}}</font>
      </el-row>
      <el-row>
        <font>类型:</font>
      </el-row>
      <el-row class="row-main">
        <el-select v-model="question.type"
                   placeholder="请选择类型"
                   size="mini">
          <el-option key="radio"
                     label="单选"
                     value="radio">
          </el-option>
          <el-option key="checkBox"
                     label="多选"
                     value="checkBox">
          </el-option>
        </el-select>
      </el-row>
      <worlduc-option v-for="item in question.options"
                      :key="item"
                      :option="item"></worlduc-option>
    </div>
    <div v-else>
      <ul>
        <li>添加问题,点击右侧&nbsp;<i class="el-icon-edit"></i>&nbsp;图标开始编辑问题细节</li>
        <li>左侧: 添加问题选项, 修改问题标题</li>
        <li>右侧: 删减问题选项, 设置选项的增删 Tag</li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {

    };
  },
  computed: {
    isShow: function() {
      return this.$store.state.index
    },
    question: function() {
      return this.$store.state.questions[this.isShow]
    }
  }
};
</script>

<style scoped>
.grid-option-edit {
  padding: 15px;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}
.grid-option-edit .el-row {
  font-size: 14px;
}
.grid-option-edit .el-row .el-select {
  margin-top: 0px;
}
.row-main {
  margin: 5px 0 10px 0;
}
ul {
  padding-left: 20px;
  font-size: 14px;
}
</style>


