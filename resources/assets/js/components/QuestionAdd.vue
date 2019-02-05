<template>
  <div class="container el-row">
    <div class="left el-col-6 panel panel-bordered">
      <el-row>
        <div class="input-title">课程 :</div>
        <el-select v-model="courseId"
                   placeholder="请选择"
                   @change="selectCourse">
          <el-option v-for="item in allUserCourse"
                     :key="item.value"
                     :label="item.label"
                     :value="item.value">
          </el-option>
        </el-select>
      </el-row>
      <el-row>
        <hr />
        <div class="input-title">题库信息 :</div>
        <div class="questions-info">
          <div class="questions-info-item">
            <div class="top-num">{{questionsData.length}}</div>
            <div class="bottom-tip">总题数</div>
          </div>
          <div class="questions-info-item">
            <div class="top-num">{{totalLevels}}</div>
            <div class="bottom-tip">总难度星数</div>
          </div>
        </div>
      </el-row>
      <el-row>
        <hr />
        <div class="input-title">知识点 Tag :
          <el-tooltip content="每个知识点每个星级难度至少需要一个题，否则无法组卷成功，红色字体表示该难度尚需一个题"
                      placement="top">
            <i class="el-icon-question"></i>
          </el-tooltip>
        </div>
        <div class="tags">
          <div v-for="(item, index) in tagsData"
               :key="index"
               class="tag-item">
            <div class="tag-content">
              <el-tag>{{item.label}}</el-tag>
            </div>
            <font :class="[tip(item) != 'OK' ? 'num-no' : 'num-ok']">{{tip(item)}}</font>
            <!-- <div class="tag-info"> -->
            <!-- <font :class="[item.totalLevels >= 20 ? 'num-ok' : 'num-no']">{{item.totalLevels}}</font> 星 -->
            <!-- </div> -->
          </div>
          <!-- <hr /> -->
        </div>
      </el-row>
    </div>
    <div class="right el-col-17 panel panel-bordered">
      <div class="action">
        <el-button type="primary"
                   plain
                   @click="addQues">新建</el-button>
        <!-- <el-button type="danger"
                   plain>批量删除</el-button> -->
      </div>
      <el-table :data="questionsData.filter(data => !search || data.title.includes(search))"
                style="width: 100%">
        <!-- <el-table-column type="selection"
                         width="40">
        </el-table-column> -->
        <el-table-column prop="title"
                         label="题干"
                         :show-overflow-tooltip=true
                         min-width="400px">
        </el-table-column>
        <el-table-column prop="type"
                         label="类型"
                         align="center"
                         :filters="[{ text: '单选', value: 'radio' }, { text: '多选', value: 'multi' }]"
                         :filter-method="filterType"
                         :filter-multiple=false
                         filter-placement="bottom-end">
          <template slot-scope="scope">
            <el-tag :type="scope.row.type === 'radio' ? 'primary' : 'success'"
                    disable-transitions>{{scope.row.type === 'radio' ? '单选' : '多选'}}</el-tag>
          </template>
        </el-table-column>
        <el-table-column prop="tag"
                         label="知识点"
                         align="center"
                         :filters="filtersTagsData"
                         :filter-method="filterTag"
                         filter-placement="bottom-end">
        </el-table-column>
        <el-table-column prop="level"
                         align="center"
                         label="难度星数"
                         :filters="[{ text: '1', value: '1' }, { text: '2', value: '2' }, { text: '3', value: '3' }, { text: '4', value: '4' }, { text: '5', value: '5' }]"
                         :filter-method="filterLevel"
                         filter-placement="bottom-end">
          <template slot-scope="scope">
            {{scope.row.level}}
          </template>
        </el-table-column>
        <el-table-column prop="isLeader"
                         label="操作"
                         align="center"
                         width="180px">
          <template slot="header"
                    slot-scope="scope">
            <el-input v-model="search"
                      size="mini"
                      placeholder="输入关键字搜索" />
          </template>
          <template slot-scope="scope">
            <div style="display:flex">
              <el-button size="mini"
                         type="primary"
                         @click="updateQues(scope.row, scope.$index)">查看 / 编辑
              </el-button>
              <el-button size="mini"
                         type="danger"
                         @click="deleteQues(scope.row.id, scope.row.tagId, scope.row.level, scope.$index)">删除</el-button>
            </div>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <el-dialog class="detail"
               :title="dialogType == 'add' ? '新建问题' : '修改问题'"
               :visible.sync="dialogVisible"
               width="60%">
      <el-input v-if="questionInputVisible"
                placeholder="请输入问题"
                size="small"
                v-model="edittingQuestion.title"
                ref="questionInput"
                class="question-title"
                @keyup.enter.native="handleQuestionTitleConfirm"
                @blur="handleQuestionTitleConfirm">
      </el-input>
      <span v-else
            @dblclick="editQuestionTitleInput"
            class="question-title">{{edittingQuestion.title}}</span>
      <!-- <span >{{edittingQuestion.title}}</span> -->
      <div class="addNewOption">
        <el-input class="option-input"
                  size="mini"
                  placeholder="添加选项, 按 Enter 确认"
                  v-model="newOption"
                  @keyup.enter.native="newOptionInputConfirm">
        </el-input>
        <el-tooltip content="确定前请先选择正确答案, 直接在选项上选择即可"
                    placement="top">
          <i class="el-icon-question"></i>
        </el-tooltip>
      </div>
      <el-checkbox-group v-if="edittingQuestion.type == 'multi'"
                         class="options"
                         v-model="edittingQuestion.answer">
        <div class="option-item"
             v-for="(value, key) in edittingQuestion.options"
             :key="key">
          <el-checkbox :label="key">
            {{value}}</el-checkbox>
          <i class="el-icon-close option-item-close"
             @click="removeOption(key)"></i>
        </div>
      </el-checkbox-group>
      <el-radio-group v-else-if="edittingQuestion.type == 'radio'"
                      v-model="edittingQuestion.answer"
                      class="options">
        <div class="option-item"
             v-for="(value, key) in edittingQuestion.options"
             :key="key">
          <el-radio :label="key">
            {{value}}</el-radio>
          <i class="el-icon-close option-item-close"
             @click="removeOption(key)"></i>
        </div>
      </el-radio-group>
      <span slot="footer"
            class="dialog-footer">
        <div class="dialog-footer-left">
          <el-select v-model="edittingQuestion.tagId"
                     placeholder="请选择知识点"
                     size="mini"
                     class="selectTag">
            <el-option v-for="item in tagsData"
                       :key="item.value"
                       :label="item.label"
                       :value="item.value">
            </el-option>
          </el-select>
          <el-radio-group v-model="edittingQuestion.type"
                          size="mini"
                          @change="changeType">
            <el-radio-button label="radio">单选</el-radio-button>
            <el-radio-button label="multi">多选</el-radio-button>
          </el-radio-group>
          <el-rate class="question-level"
                   v-model="edittingQuestion.level"></el-rate>
        </div>
        <div>
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button :type="dialogType == 'add' ? 'primary' : 'warning'"
                     @click="ensureQues">{{dialogType == 'add' ? '确定' : '修改'}}</el-button>
        </div>
      </span>
    </el-dialog>
  </div>
</template>


<script>
export default {
  data() {
    return {
      MyAxios: axios.create({
        headers: { "Content-Type": "application/json" }
      }),
      courseId: "", // 用户当前选择的课程 ID
      allUserCourse: [], // 用户所有的课程信息
      questionsData: [], // 该课程下的所有问题数据
      totalLevels: 0, // 该课程下的所有问题难度星数
      tagsData: {}, // 该课程下的所有 tag 的 id 和 value 对应数据
      questionInputVisible: false, // 编辑框的题目标题当前是否正在编辑
      search: "", // 表格搜索框
      dialogVisible: false, // 新建和编辑的 dialog 显示控制
      newOption: "", // 要新添加的选项
      dialogType: "add", // 当前 dialog 的状态
      edittingRowIndex: "", // 当前编辑的行的索引
      edittingQuesLevel: "", // 当前编辑的问题的星级难度
      edittingQuesTag: "",  // 当前编辑的问题的知识点 tag的 ID
      edittingQuestion: {
        title: "-------- 双击编辑你的问题 --------",
        options: {},
        type: "radio",
        tagId: "",
        level: 0,
        answer: []
      } // 当前编辑的问题
    }
  },
  computed: {
    filtersTagsData: function() {
      let res = []
      for(let index in this.tagsData) {
        res.push({
          "text": this.tagsData[index].label,
          "value": this.tagsData[index].value
        })
      }
      return res
    }
  },
  methods: {
    // 初始化:获取用户的课程信息
    init() {
      var that = this
      this.MyAxios.get("/api/user/course")
        .then(function(response) {
          for (var index in response.data.data) {
            that.allUserCourse.push({
              value: response.data.data[index].id,
              label: response.data.data[index].name
            })
          }
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    // 每次选择完课程后执行
    async selectCourse() {
      // 数据初始化
      this.totalLevels = 0
      this.questionsData = []
      this.tagsData = {}
      // 获取课程的题目信息,一些通用计算处理
      var that = this
      await this.MyAxios.get("/api/tag/detail/" + this.courseId)
        .then(function(response) {
          that.tagsData = response.data.data
          for (var index in that.tagsData) {
            that.tagsData[index].value = index
            that.tagsData[index].requirement = [0, 0, 0 ,0 ,0]
            that.tagsData[index].status = false // 状态,用于生成 tip时的状态标识,防止出现闪一下的情况
          }
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
      this.MyAxios.get("/api/question/" + this.courseId)
        .then(function(response) {
          for (var index in response.data.data) {
            that.totalLevels += parseInt(response.data.data[index].level)
            that.tagsData[response.data.data[index].tag_id].requirement[parseInt(response.data.data[index].level) - 1] += 1
            that.questionsData.push({
              level: parseInt(response.data.data[index].level),
              type: response.data.data[index].type,
              title: response.data.data[index].title,
              tag: that.tagsData[response.data.data[index].tag_id].label,
              tagId: response.data.data[index].tag_id + "",
              id: response.data.data[index].id,
              options: JSON.parse(response.data.data[index].option),
              answer: JSON.parse(response.data.data[index].answer)
            })
            that.tagsData[response.data.data[index].tag_id].status = true
          }
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    // 点击新建问题
    addQues() {
      if (this.dialogType == "update") {
        this.edittingQuestion = {
          title: "-------- 双击编辑你的问题 --------",
          options: {},
          type: "radio",
          tagId: "",
          level: 0,
          answer: []
        }
      }
      this.dialogType = "add"
      this.dialogVisible = true
    },
    // 确定新建/修改一个问题
    ensureQues() {
      let ques = this.edittingQuestion
      let that = this
      if (
        ques.title != "" &&
        ques.options != {} &&
        (ques.type == "radio" || ques.type == "multi") &&
        ques.tagId != "" &&
        ques.level != "" &&
        (ques.answer != "" && ques.answer != [])
      ) {
        let reuqestData = {
          title: ques.title,
          type: ques.type,
          level: ques.level,
          tag_id: ques.tagId,
          option: ques.options,
          answer: ques.answer
        }
        if (this.dialogType == "add") {
          this.MyAxios.post("/api/question/", reuqestData)
            .then(function(response) {
              that.questionsData.push({
                level: parseInt(response.data.data.level),
                type: response.data.data.type,
                title: response.data.data.title,
                tag: that.tagsData[response.data.data.tag_id].label,
                tagId: response.data.data.tag_id,
                id: response.data.data.id,
                options: JSON.parse(response.data.data.option),
                answer: JSON.parse(response.data.data.answer)
              })
              that.totalLevels += parseInt(response.data.data.level)
              that.tagsData[response.data.data.tag_id].requirement[parseInt(response.data.data.level) - 1] += 1
              that.dialogVisible = false
              that.edittingQuestion = {
                title: "-------- 双击编辑你的问题 --------",
                options: {},
                type: "radio",
                tagId: "",
                level: 0,
                answer: []
              }
            })
            .catch(function(error) {
              alert(error.response.data.errmsg)
            })
        } else {
          this.MyAxios.put("/api/question/" + ques.id, reuqestData)
            .then(function(response) {
              that.questionsData[that.edittingRowIndex] = {
                level: parseInt(response.data.data.level),
                type: response.data.data.type,
                title: response.data.data.title,
                tag: that.tagsData[response.data.data.tag_id].label,
                tagId: response.data.data.tag_id,
                id: response.data.data.id,
                options: JSON.parse(response.data.data.option),
                answer: JSON.parse(response.data.data.answer)
              }

              that.totalLevels -= that.edittingQuesLevel
              that.totalLevels += parseInt(response.data.data.level)

              that.tagsData[response.data.data.tag_id].requirement[that.edittingQuesLevel - 1] -= 1
              that.tagsData[response.data.data.tag_id].requirement[parseInt(response.data.data.level) - 1] += 1

              that.dialogVisible = false
            })
            .catch(function(error) {
              alert(error.response.data.errmsg)
            })
        }
      } else {
        this.$notify({
          title: "警告",
          message:
            "缺失参数！请确认：<strong><br/>题干<br/>知识点<br/>难度星级<br/>至少一个选项<br/>正确答案(直接在选项上选择)</strong>",
          type: "warning",
          dangerouslyUseHTMLString: true,
          duration: 10000
        })
      }
    },
    // 删除一个问题
    deleteQues(questionId, tagId, level, index) {
      let that = this
      this.$confirm("确定要删除这个问题吗?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      }).then(() => {
        this.MyAxios.delete("/api/question/" + questionId)
          .then(function(response) {
            that.questionsData.splice(index, 1)
            that.totalLevels -= level
            that.tagsData[tagId].requirement[level - 1] -= 1
            that.$message({
              type: "success",
              message: "删除成功!"
            })
          })
          .catch(function(error) {
            that.$message({
              type: "info",
              message: "删除失败了!" + error.response.data.errmsg
            })
          })
      })
    },
    // 点击更新问题
    updateQues(ques, $index) {
      this.edittingQuesLevel = ques.level
      this.edittingQuesTag = ques.tagId
      this.dialogVisible = true
      this.dialogType = "update"
      this.edittingQuestion = JSON.parse(JSON.stringify(ques)) // 深拷贝
      this.edittingRowIndex = $index
    },
    // 修改问题的类型
    changeType(type) {
      if (type == "multi") this.edittingQuestion.answer = []
    },
    // 添加一个新的选项
    newOptionInputConfirm() {
      if (this.newOption) {
        this.edittingQuestion.options[
          Math.random()
            .toString(36)
            .substr(2)
        ] = this.newOption
        this.newOption = ""
      }
    },
    // 删除一个新的选项
    removeOption(key) {
      this.$delete(this.edittingQuestion.options, key)
      if (this.edittingQuestion.type == "multi") this.edittingQuestion.answer = []
      else if (this.edittingQuestion.type == "radio") this.edittingQuestion.answer = ""
    },
    // 失焦或确定后修改题目标题
    handleQuestionTitleConfirm() {
      if (this.edittingQuestion.title != "") this.questionInputVisible = false
    },
    // 开始编辑题目标题
    editQuestionTitleInput() {
      this.questionInputVisible = true
      this.$nextTick(_ => {
        this.$refs.questionInput.focus()
      })
    },
    // 侧栏题目数要求提示
    tip(item) {
      if (!item.status) return ''
      let count = 0
      let tip = ''
      for(let index in item.requirement) {
        if (item.requirement[index] != 0) count++
        else {
          tip += (parseInt(index) + 1) + ", "
        }
      }
      tip = tip.substr(0, tip.length - 2)
      if (count == 5) return "OK"
      else return tip  
    },
    // 以下为表格过滤
    filterType(value, row) {
      return row.type == value
    },
    filterLevel(value, row) {
      return row.level == value
    },
    filterTag(value, row) {
      return row.tagId == value
    }
  },
  mounted: function() {
    this.init()
  }
}
</script>


<style lang="stylus" scoped>
.container
  width 100%

  .left
    padding 15px
    background-color white
    margin-right 1%
    margin-left 1%

  .right
    background-color white
    margin-right 1%
    margin-left 1%
    padding 15px
    background-color white
    font-weight 400

.tags
  display flex
  flex-direction column

  .tag-item
    display flex
    justify-content space-between
    align-items center
    padding-bottom 5.5px
    padding-top 5.5px
    border-bottom dashed 1px #ddd

    .tag-content
      width 60%
      display flex
      align-items center

      .el-tag
        max-width 100%
        font-weight 400
        overflow hidden
        text-overflow ellipsis
        white-space nowrap

    .num-ok
      font-weight 400
      color #409dfd

    .num-no
      font-weight 400
      color #ff5722

.questions-info
  display flex

  .questions-info-item
    display flex
    width 50%
    flex-direction column
    text-align center

    .top-num
      color #409dfd
      font-size 26px
      font-weight 400

    .bottom-tip
      font-weight 400

.input-title
  font-size 17px
  font-weight 400
  color #76838f
  margin-bottom 10px
  display flex
  align-items center
  justify-content space-between

.tips li
  font-weight 400

.detail
  font-weight 400

  .question-title
    font-size 16px
    font-weight 400
    margin-bottom 20px
    height 32px

  .addNewOption
    display flex
    align-items baseline

    .option-input
      margin-bottom 10px
      margin-right 10px

  .options
    height 183px
    overflow auto

    .option-item
      width 100%
      display flex
      align-items center
      justify-content space-between

      .option-item-close
        width 5%
        font-size 20px

        &:hover
          color #f44336

      .el-radio, .el-checkbox
        width 95%
        height 25px
        display flex

      label
        margin-left 0
        margin-top 10px

  .dialog-footer
    display flex
    align-items flex-end
    justify-content space-between

    .dialog-footer-left
      display flex

      .selectTag
        margin-right 20px

      .question-level
        position relative
        top 4px
        left 20px
</style>

<style>
th,
.el-table-filter {
  font-weight: bold;
}
.el-dialog__body {
  display: flex;
  flex-direction: column;
  padding: 10px 20px 0 20px;
}
.el-scrollbar,
.el-select {
  font-weight: 400;
}
.options .el-radio__label,
.options .el-checkbox__label {
  width: 95%;
  height: 100%;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  display: flex;
  align-items: center;
}
.options .el-checkbox__input,
.options .el-radio__input {
  display: flex;
  align-items: center;
}
</style>