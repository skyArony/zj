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
      <el-row class="tips">
        <hr />
        <ul>
          <li v-if="!isOKForQuesNum">尚有知识点题数不足</li>
          <li v-if="!isOkForLevelNum">尚有知识点星级不足</li>
          <li v-if="!isOkForLevelNum || !isOKForQuesNum">请检查下方存在红色数字的对应知识点</li>
        </ul>
      </el-row>
      <el-row>
        <hr />
        <div class="input-title">知识点 Tag :
          <el-tooltip content="每个知识点至少需要 4 道题,且难度总计为 20星级"
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
            <div class="tag-info">
              <font :class="[item.totalQues >= 4 ? 'num-ok' : 'num-no']">{{item.totalQues}}</font> 题<br />
              <font :class="[item.totalLevels >= 20 ? 'num-ok' : 'num-no']">{{item.totalLevels}}</font> 星</div>
          </div>
          <!-- <hr /> -->
        </div>
      </el-row>
    </div>
    <div class="right el-col-17 panel panel-bordered">
      <div class="action">
        <el-button type="primary"
                   plain
                   @click="dialogVisible = true">新建</el-button>
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
                         align="center">
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
                         @click="toTask(scope.row.taskId)">查看 / 编辑
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
               title="新建问题"
               :visible.sync="dialogVisible"
               width="50%">
      <span class="question-title">{{editingQuestion.title}}</span>
      <el-input class="option-input"
                size="mini"
                placeholder="添加选项, 按 Enter 确认"
                v-model="newOption"
                @keyup.enter.native="claimsInputConfirm">
      </el-input>
      <el-checkbox-group v-if="editingQuestion.type == 'multi'"
                      class="options"
                      v-model="editingQuestion.answer">
        <el-checkbox v-for="(item,index) in editingQuestion.options"
                  :key="index"
                  :label="item.value">{{item.label}}</el-checkbox>
      </el-checkbox-group>
      <el-radio-group v-else-if="editingQuestion.type == 'radio'"
                      class="options"
                      v-model="editingQuestion.answer">
        <el-radio v-for="(item,index) in editingQuestion.options"
                  :key="index"
                  :label="item.value">{{item.label}}</el-radio>
      </el-radio-group>
      <ul class="options">
        <div v-for="(claim, index)  in claims"
             class="claim"
             :key="index">
          <span @click="removeClaim(index)">&nbsp;&nbsp;✕&nbsp;&nbsp;</span>
          <label>{{ claim }}</label>
        </div>
      </ul>
      <span slot="footer"
            class="dialog-footer">
        <div class="dialog-footer-left">
          <el-select v-model="editingQuestion.tagId"
                     placeholder="请选择知识点"
                     size="mini"
                     class="selectTag">
            <el-option v-for="item in tagsData"
                       :key="item.value"
                       :label="item.label"
                       :value="item.value">
            </el-option>
          </el-select>
          <el-radio-group v-model="editingQuestion.type"
                          size="mini"
                          @change="changeType">
            <el-radio-button label="radio">单选</el-radio-button>
            <el-radio-button label="multi">多选</el-radio-button>
          </el-radio-group>
          <el-rate class="question-level"
                   v-model="editingQuestion.level"></el-rate>
        </div>
        <div>
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button type="primary"
                     @click="dialogVisible = false">确 定</el-button>
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
      isOKForQuesNum: true,  // 题目数是否达到要求
      isOkForLevelNum: true,  // 题目难度是否达到要求
      editingQuestion: {
        title: "-------- 双击编辑你的问题 --------",
        options: [
          {
            value: "a",
            label: "选项 A"
          },
          {
            value: "b",
            label: "选项 B"
          },
          {
            value: "c",
            label: "选项 C"
          },
        ],
        type: "radio",
        tag: "",
        tagId: "",
        level: 0,
        answer: []
      },            // 当前新建或编辑的问题
      search: "",  // 表格搜索框
      dialogVisible: false,   // 新建和编辑的 dialog 显示控制
      newOption: "" // 要新添加的选项
    }
  },
  computed: {
    // 对 tagData 进行格式化1️以

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
      this.isOKForQuesNum = true
      this.isOkForLevelNum = true
      // 获取课程的题目信息,一些通用计算处理
      var that = this
      await this.MyAxios.get("/api/tag/detail/" + this.courseId)
        .then(function(response) {
          that.tagsData = response.data.data
          for (var index in that.tagsData) {
            that.tagsData[index].totalQues = 0
            that.tagsData[index].totalLevels = 0
            that.tagsData[index].value = index
          }
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
      this.MyAxios.get("/api/question/" + this.courseId).then(function(
        response
      ) {
        for (var index in response.data.data) {
          that.tagsData[response.data.data[index].tag_id].totalQues += 1
          that.tagsData[
            response.data.data[index].tag_id
          ].totalLevels += parseInt(response.data.data[index].level)
          that.totalLevels += parseInt(response.data.data[index].level)
          that.questionsData.push({
            level: response.data.data[index].level,
            type: response.data.data[index].type,
            title: response.data.data[index].title,
            tag: that.tagsData[response.data.data[index].tag_id].label,
            tagId: response.data.data[index].tag_id,
            id: response.data.data[index].id
          })
        }
        // 检查各个 tag 的题目数和难度星级数是否达到要求
        for(var index in that.tagsData) {
          if (that.tagsData[index].totalQues < 4) that.isOKForQuesNum = false
          if (that.tagsData[index].totalLevels < 20) that.isOkForLevelNum = false
        }
      })
      .catch(function(error) {
        alert(error.response.data.errmsg)
      })
    },
    // 新建一个问题

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
            that.tagsData[tagId].totalQues -= 1
            that.tagsData[tagId].totalLevels -= level
            that.totalLevels -= level
            if (that.tagsData[tagId].totalQues < 4) thta.isOKForQuesNum = false
            if (that.tagsData[tagId].totalLevels < 20) thta.isOkForLevelNum = false
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
    // 修改问题的类型
    changeType(type) {
      if (type == "multi") this.editingQuestion.answer = []
    },
    // 以下为表格过滤
    filterType(value, row) {
      return row.type === value
    },
    filterLevel(value, row) {
      return row.level === value
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

    .tag-info
      font-weight 400
      text-align right

      .num-ok
        color #409dfd

      .num-no
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

  .option-input
    margin-bottom 10px

  .options
    display flex
    flex-direction column

    .el-radio
      height 23px
      display flex
      align-items center

    .el-checkbox
      height 23px

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
</style>