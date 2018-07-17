<template>
  <div class="outer-flex">
    <div class="editQuestion">
      <div class="question-title">
        <span v-handle
              class="handle">
          <i class="el-icon-rank"></i>
        </span>
        <el-input v-if="questionInputVisible"
                  placeholder="请输入问题"
                  size="small"
                  v-model="theQuestion.question"
                  ref="saveTagInput"
                  @keyup.enter.native="handleQuestionConfirm"
                  @blur="handleQuestionConfirm">
        </el-input>
        <font v-else
              @dblclick="editQuestionInput">{{theQuestion.question}}</font>
      </div>
      <div class="option"
           v-if="theQuestion.type == 'radio'">
        <el-input class="addOption"
                  size="small"
                  v-model="addOption"
                  placeholder="添加选项"
                  @keyup.enter.native="handleOptionConfirm"
                  @blur="handleOptionConfirm">
          <i slot="prefix"
             class="el-input__icon el-icon-circle-plus"></i>
        </el-input>
        <el-radio-group v-model="select">
          <el-radio v-for="item in theQuestion.options"
                    :key="item"
                    :label="item">{{item}}</el-radio>
        </el-radio-group>
      </div>
      <div class="option"
           v-else-if="theQuestion.type == 'checkBox'">
        <el-input class="addOption"
                  size="small"
                  v-model="addOption"
                  placeholder="添加选项"
                  @keyup.enter.native="handleOptionConfirm"
                  @blur="handleOptionConfirm">
          <i slot="prefix"
             class="el-input__icon el-icon-circle-plus"></i>
        </el-input>
        <el-checkbox-group v-model="selects">
          <el-checkbox v-for="item in theQuestion.options"
                       :key="item"
                       :label="item"></el-checkbox>
        </el-checkbox-group>
      </div>
    </div>
    <i class="el-icon-edit action-button edit-button"
       @click="editQuestionDetail"></i>
    <i class="el-icon-close action-button"
       @click="deleteQuestion"></i>
  </div>
</template>

<script>
import { ElementMixin, HandleDirective } from "vue-slicksort";

export default {
  mixins: [ElementMixin],
  directives: { handle: HandleDirective },
  props: {
    question: Object,
  },
  data() {
    return {
      // 数值
      theQuestion: this.question,
      select: "",
      addOption: "",
      addOption: "",
      select: "",
      selects: [],
      // 控制
      questionInputVisible: false,
    };
  },
  methods: {
    // 编辑问题
    editQuestionInput() {
      this.questionInputVisible = true;
      this.$nextTick(_ => {
        this.$refs.saveTagInput.$refs.input.focus();
      });
    },
    // 确认问题输入
    handleQuestionConfirm() {
      if (this.theQuestion.question != "") this.questionInputVisible = false;
      // 修改 vuex 中的值
      this.$store.commit("editQuestion", {
        id: this.theQuestion.id,
        question: this.theQuestion.question
      });
    },
    // 确认选项输入
    handleOptionConfirm() {
      if (this.addOption != "" && this.theQuestion.options.indexOf(this.addOption) == -1) {
        this.theQuestion.options.push(this.addOption);
        this.addOption = "";
        // 修改 vuex 中的值
        this.$store.commit("editQuestion", {
          id: this.theQuestion.id,
          options: this.theQuestion.options
        });
      }
    },
    // 删除一个问题
    deleteQuestion() {
      this.$store.commit("deleteQuestion", this.theQuestion);
    },
    // 编辑一个问题的选项
    editQuestionDetail() {
      this.$store.commit("editQuestionDetail", this.theQuestion)
    }
  }
};
</script>

<style scoped>
.question-title {
  display: flex;
  align-items: baseline;
  margin-bottom: 10px;
}
.question-title span {
  margin-right: 10px;
}
.option {
  display: flex;
  align-items: baseline;
}
.addOption {
  margin-bottom: 20px;
  width: 10rem;
}
.el-radio, .el-checkbox {
  margin-bottom: 20px;
  margin-left: 30px;
}
.handle {
  display: block;
  width: 18px;
  height: 18px;
  background-size: contain;
  background-repeat: no-repeat;
  opacity: 0.25;
  margin-right: 20px;
  cursor: move;
  color: black;
}
.editQuestion {
  width: 100%;
}
.outer-flex {
  display: flex;
  justify-content: space-between;
}
.action-button {
  margin-right: 10px;
  display: flex;
  align-items: center;
  font-size: 28px;
  position: relative;
  color: #c0c4cc;
}
.action-button:hover {
  color: #606266;
}
.action-button.edit-button {
  margin-left: 20px;
  font-size: 23px;
}
</style>


