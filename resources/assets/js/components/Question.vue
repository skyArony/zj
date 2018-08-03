<template>
  <div class="question">
    <font>{{question.question}}</font>
    <div class="option">
      <el-radio-group v-if="question.type == 'radio'"
                      v-model="radio"
                      @change="emitData">
        <el-radio v-for="item in question.options"
                  :key="item"
                  :label="item">{{item}}</el-radio>
      </el-radio-group>
      <el-checkbox-group v-else-if="question.type == 'checkBox'"
                         v-model="checkList"
                         @change="emitData">
        <el-checkbox v-for="item in question.options"
                     :key="item"
                     :label="item"></el-checkbox>
      </el-checkbox-group>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    question: Object
  },
  data() {
    return {
      radio: "",
      checkList: [],
    };
  },
  methods: {
    emitData (data) {
      let addTags = []
      let removeTags = []
      if (typeof(data) === 'object') {
        for(let index in data) { 
          if (this.question.addTags[data[index]] !== undefined)
            addTags = addTags.concat(this.question.addTags[data[index]])
          if(this.question.removeTags[data[index]] !== undefined)
            removeTags = removeTags.concat(this.question.removeTags[data[index]])
        }
      } else if (typeof(data) === 'string'){
        addTags = this.question.addTags[data] ? this.question.addTags[data] : []
        removeTags = this.question.removeTags[data] ? this.question.removeTags[data] : []
      }
      this.$emit("setAnswer", {
        id: this.question.id,
        addTags: addTags,
        removeTags: removeTags
      })
    },
  }
};
</script>

<style scoped>
.el-checkbox {
  margin-left: 0px;
  margin-right: 30px;
  margin-bottom: 5px;
}
.question {
  background-color: #fff;
  width: 100%;
  padding: 20px 20px 10px 20px;
  box-sizing: border-box;
}
.question:hover {
  background-color: #fafafa;
}
.question font {
  color: #212121;
  font-weight: 700;
  font-size: 18px;
}
.option {
  padding: 15px 10px 10px 10px;;
}
</style>


