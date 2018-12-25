<template>
  <el-row class="aOption">
    <hr class="right-line">
    <el-row class="action">
      <font>选项:</font>
      <el-button plain size="mini" class="closeOption" @click="deleteOption">删除这个选项</el-button>
    </el-row>
    <el-row class="row-main">
      <font>{{option}}</font>
    </el-row>
    <el-row class="row-main">
      <font>增加 Tags:&nbsp;</font>
      <el-cascader v-model="addTag"
                   :options="waittingTags"
                   :placeholder="placeholder"
                   size="mini"
                   @change="handleAddTag"
                   filterable></el-cascader>
    </el-row>
    <el-row>  
      <el-tag :key="index"
              closable
              v-for="(tag, index) in question.addTags[option]"
              :disable-transitions="false"
              @close="addTagClose(index)">
        {{tag}}
      </el-tag>
    </el-row>
    <el-row class="row-main">
      <font>减去 Tags:&nbsp;</font>
      <el-cascader v-model="removeTag"
                   :placeholder="placeholder"
                   :options="waittingTags"
                   size="mini"
                   @change="handleRemoveTag"
                   filterable></el-cascader>
    </el-row>
    <el-row>
      <el-tag :key="index"
              closable
              v-for="(tag, index) in question.removeTags[option]"
              :disable-transitions="false"
              @close="removeTagClose(index)">
        {{tag}}
      </el-tag>
    </el-row>
  </el-row>
</template>

<script>
export default {
  props: {
    option: String
  },
  data() {
    return {
      placeholder: "请选择",
      addTag: [], // addTag 的选择
      removeTag: [] // removeTag 的选择
    };
  },
  methods: {
    // 增加一个 增tag
    handleAddTag(value) {
      this.$store.commit('addTagToOption', {
        tag: value[0],
        type: 'add',
        option: this.option
      })
      this.addTag = []
    },
    // 增加一个 减tag
    handleRemoveTag(value) {
      this.$store.commit('addTagToOption', {
        tag: value[0],
        type: 'remove',
        option: this.option
      })
      this.removeTag = []
    },
    // 增加一个选项
    addTagClose(index) {
      this.$store.commit('removeTagFromOption', {
        index: index,
        option: this.option,
        type: 'add'
      })
    },
    // 删除一个选项
    removeTagClose(index) {
      this.$store.commit('removeTagFromOption', {
        index: index,
        option: this.option,
        type: 'remove'
      })
    },
    deleteOption() {
      this.$store.commit('deleteOption', this.option)
    }
  },
  computed: {
    question: function() {
      return this.$store.state.questions[this.$store.state.index];
    },
    waittingTags: function() {
      let options = [];
      let len = this.$store.state.dynamicTags.length;
      if(len == 0) this.placeholder = "请先设置 tag"
      else this.placeholder = "请选择"
      for (let j = 0; j < len; j++) {
        options.push({
          value: this.$store.state.dynamicTags[j],
          label: this.$store.state.dynamicTags[j],
          // children: [
          //   {
          //     value: this.$store.state.dynamicTags[j] + "-easy",
          //     label: this.$store.state.dynamicTags[j] + "-easy"
          //   },
          //   {
          //     value: this.$store.state.dynamicTags[j] + "-normal",
          //     label: this.$store.state.dynamicTags[j] + "-normal"
          //   },
          //   {
          //     value: this.$store.state.dynamicTags[j] + "-hard",
          //     label: this.$store.state.dynamicTags[j] + "-hard"
          //   }
          // ]
        });
      }
      return options;
    }
  }
};
</script>

<style scoped>
.right-line {
  border-color: #b0bec5;
  border-style: dashed;
  margin-top: 15px;
  margin-bottom: 15px;
}
.row-main {
  margin: 5px 0 10px 0;
}
.el-tag {
  margin-right: 10px;
  margin-bottom: 10px;
}
.action {
  align-items: baseline;
}
.closeOption {
  padding: 7px;
  margin-left: 15px;
}
</style>


