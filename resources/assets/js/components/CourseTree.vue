<!-- dialog 中的东西太多导致第一次渲染速度比较慢 -->
<template>
  <div class="custom-tree-container">
    <div class="block">
      <!-- 章节编辑 -->
      <el-dialog title="编辑章节 tag 和课程目标"
                 :visible.sync="unityDialogVisible"
                 width="70%">
        <div class="tagsContainer">
          <el-tag :key="index"
                  closable
                  v-for="(tag, index) in selectedTags"
                  :disable-transitions="false"
                  @close="tagClose(index)">
            {{tag}}
          </el-tag>
          <el-cascader expand-trigger="hover"
                       v-model="selectedOptions"
                       class="input-new-tag"
                       :options="waittingTags"
                       :placeholder="placeholder"
                       size="small"
                       @change="handleInputConfirm"
                       filterable></el-cascader>
        </div>
        <hr />
        <el-input class="claimInput"
                  placeholder="请输入课程目标，一次一条，无需序号，Enter 确认"
                  v-model="claimsText"
                  @keyup.enter.native="claimsInputConfirm">
        </el-input>
        <ul class="claim-list"
            ref="claim_list">
          <div v-for="(claim, index)  in claims"
               class="claim"
               :key="index">
            <span @click="removeClaim(index)">&nbsp;&nbsp;✕&nbsp;&nbsp;</span>
            <label>{{ claim }}</label>
          </div>
        </ul>
        <span slot="footer"
              class="dialog-footer">
          <el-button type="text"
                     disabled>编辑章节会覆盖其下所有课时的属性，请注意。</el-button>
          <el-button @click="unityDialogVisible = false">取 消</el-button>
          <el-button type="primary"
                     @click="ensureCourseTree(true)">确 定</el-button>
        </span>
      </el-dialog>
      <!-- 课时编辑 -->
      <el-dialog title="编辑课时 tag 和课程目标"
                 :visible.sync="dialogVisible"
                 width="70%">
        <div class="tagsContainer">
          <el-tag :key="index"
                  closable
                  v-for="(tag, index) in selectedTags"
                  @close="tagClose(index)">
            {{tag}}
          </el-tag>
          <el-cascader expand-trigger="hover"
                       v-model="selectedOptions"
                       class="input-new-tag"
                       :options="waittingTags"
                       size="small"
                       @change="handleInputConfirm"
                       filterable></el-cascader>
        </div>
        <hr />
        <el-input class="claimInput"
                  placeholder="请输入课程目标，一次一条，无需序号，Enter 确认"
                  v-model="claimsText"
                  @keyup.enter.native="claimsInputConfirm">
        </el-input>
        <ul class="claim-list"
            ref="claim_list">
          <div v-for="(claim, index)  in claims"
               class="claim"
               :key="index">
            <span @click="removeClaim(index)">&nbsp;&nbsp;✕&nbsp;&nbsp;</span>
            <label>{{ claim }}</label>
          </div>
        </ul>
        <span slot="footer"
              class="dialog-footer">
          <el-button @click="dialogVisible = false">取 消</el-button>
          <el-button type="primary"
                     @click="ensureCourseTree(false)">确 定</el-button>
        </span>
      </el-dialog>
      <el-tree :data="treeData"
               node-key="mytree"
               default-expand-all
               :expand-on-click-node="false">
        <span class="custom-tree-node"
              slot-scope="{ node, data }">
          <span v-if="data.children">{{ node.label }} </span>
          <span v-else>
            {{ node.label }}
          </span>
          <el-button v-if="data.children"
                     type="text"
                     @click="dialogDataSet(true, data.id)">
            统一编辑
          </el-button>
          <el-button v-else
                     type="text"
                     @click="dialogDataSet(false, data.id)">
            编辑
          </el-button>
        </span>
      </el-tree>
    </div>
  </div>
</template>


<script>
import { mapState } from "vuex"

export default {
  data() {
    return {
      courseId: "",
      /* dialog */
      inputVisible: false, // 是否显示输入tag的表单，false 时显示文字，true 时显示表单
      claims: [], // 教学要求
      claimsText: "", // 新输入的 claimsText
      dialogVisible: false, // 课时的编辑
      unityDialogVisible: false, // 章节的编辑
      dialogId: "", // dialog Id
      placeholder: "请选择",
      /* coursetree */
      treeData: [],
      courseTree: {},
      /* tag */
      selectedTags: [], // dialog 中已选择的 tag
      selectedOptions: [] // cascader 中已选择的内容
    }
  },
  watch: {
    // 在页面上方删除课程的 tags 时,这个函数会执行,把已选择的该 tag 删除
    dynamicTags: function(val) {
      for (let key in this.courseTree) {
        for (let key2 in this.courseTree[key]) {
          if (this.courseTree[key][key2].tags) {
            let tempTags = []
            for (let index in this.courseTree[key][key2].tags) {
              let tag = this.courseTree[key][key2].tags[index].split("-")
              tempTags.push(tag[0])
            }
            let pos = tempTags.indexOf(this.$store.state.removeTag)
            if (pos != -1) {
              this.courseTree[key][key2].tags.splice(pos, 1)
              let MyAxios = axios.create({
                headers: { "Content-Type": "application/json" }
              })
              MyAxios.put("/api/courseTree/" + this.courseId, {
                data: this.courseTree
              }).catch(function(error) {
                if (error.response.data.errcode == -4009) alert("没有操作权限!")
                else alert(error.response.data.errmsg)
                location.reload()
              })
            }
          }
        }
      }
    }
  },
  methods: {
    /* 组件 */
    // 警告提示
    warning(msg) {
      this.$notify({
        title: "警告",
        message: msg,
        type: "warning",
        duration: "2000",
        response: ""
      })
    },
    /* tag 选择输入相关 */
    // 增加一个 tag
    handleInputConfirm(value) {
      this.selectedTags.push(value[1])
      let index = this.$store.state.dynamicTags.indexOf(value[0])
      this.waittingTags[index].disabled = true
      this.selectedOptions = []
    },
    // 删除一个 tag
    tagClose(index) {
      let tag = this.selectedTags[index].split("-")
      this.selectedTags.splice(index, 1)
      let pos = this.$store.state.dynamicTags.indexOf(tag[0])
      this.waittingTags[pos].disabled = false
    },

    /* treedata */
    // 获取 treedata
    getTreeData() {
      var that = this
      const { search } = window.location
      let searchParams = new URLSearchParams(search)
      let courseId = searchParams.get("courseId")
      let MyAxios = axios.create()

      MyAxios.get("/api/courseTree" + "/" + this.courseId).then(function(
        response
      ) {
        if (response.data.errcode == 0) {
          that.courseTree = response.data.data
          let child = []
          that.treeData = []
          for (let i in response.data.data) {
            child = []
            for (let j in response.data.data[i]) {
              let obj2 = {
                id: j,
                label: response.data.data[i][j].period_title
              }
              child.push(obj2)
            }
            let obj = {
              id: i,
              label: response.data.data[i].chapter_name,
              children: child
            }
            child.pop() // 去掉一个不必要的干扰元素
            that.treeData.push(obj)
          }
        }
      })
    },
    // 显示章节和课时的 tag 和 claim
    dialogDataSet(isChapter, id) {
      this.dialogId = id
      if (isChapter) {
        this.unityDialogVisible = true
        let chapter = this.courseTree[id]
        let tags = []
        let claims = []
        for (let i in chapter) {
          if (chapter[i].tags) tags = tags.concat(chapter[i].tags)
          if (chapter[i].claims) claims = claims.concat(chapter[i].claims)
        }
        // 去重
        tags = Array.from(new Set(tags))
        claims = Array.from(new Set(claims))
        // 修正 waittingtags
        let tagTemp = []
        for (let item of tags) {
          let tag = item.split("-")
          tagTemp.push(tag[0])
        }
        for (let item of this.waittingTags) {
          if (tagTemp.indexOf(item.value) != -1) {
            let index = this.$store.state.dynamicTags.indexOf(item.value)
            this.waittingTags[index].disabled = true
          } else {
            let index = this.$store.state.dynamicTags.indexOf(item.value)
            this.waittingTags[index].disabled = false
          }
        }
        this.claims = claims
        this.selectedTags = tags
      } else {
        this.dialogVisible = true
        let courseTree = this.courseTree
        let tags = []
        let claims = []
        for (let i in courseTree) {
          if (courseTree[i][id]) {
            if (courseTree[i][id].tags)
              tags = tags.concat(courseTree[i][id].tags)
            if (courseTree[i][id].claims)
              claims = claims.concat(courseTree[i][id].claims)
            break
          }
        }
        tags = Array.from(new Set(tags))
        claims = Array.from(new Set(claims))
        // 修正 waittingtags
        let tagTemp = []
        for (let item of tags) {
          let tag = item.split("-")
          tagTemp.push(tag[0])
        }
        for (let item of this.waittingTags) {
          if (tagTemp.indexOf(item.value) != -1) {
            let index = this.$store.state.dynamicTags.indexOf(item.value)
            this.waittingTags[index].disabled = true
          } else {
            let index = this.$store.state.dynamicTags.indexOf(item.value)
            this.waittingTags[index].disabled = false
          }
        }
        this.claims = claims
        this.selectedTags = tags
      }
    },
    // 删除一个 claim
    removeClaim(claimIndex) {
      this.claims.splice(claimIndex, 1)
    },
    // 添加一个 claim
    claimsInputConfirm() {
      if (this.claimsText) {
        this.claims.splice(0, 0, this.claimsText)
        this.claimsText = ""
      }
    },
    // 保存 tag 和 claim 的修改
    ensureCourseTree(isChapter) {
      var id = this.dialogId
      if (isChapter) {
        this.unityDialogVisible = false
        for (let i in this.courseTree[id]) {
          if (i != "chapter_name") {
            this.courseTree[id][i].tags = this.selectedTags
            this.courseTree[id][i].claims = this.claims
          }
        }
      } else {
        this.dialogVisible = false
        for (let i in this.courseTree) {
          if (this.courseTree[i][id] && i != "chapter_name") {
            this.courseTree[i][id].tags = this.selectedTags
            this.courseTree[i][id].claims = this.claims
            break
          }
        }
      }
      let MyAxios = axios.create({
        headers: { "Content-Type": "application/json" }
      })
      MyAxios.put("/api/courseTree/" + this.courseId, {
        data: this.courseTree
      }).catch(function(error) {
        if (error.response.data.errcode == -4009) alert("没有操作权限!")
        else alert(error.response.data.errmsg)
        location.reload()
      })
    }
  },
  computed: {
    dynamicTags: function() {
      return this.$store.state.dynamicTags
    },
    waittingTags: function() {
      let options = []
      let len = this.$store.state.dynamicTags.length
      if (len == 0) this.placeholder = "请先设置 tag"
      else this.placeholder = "请选择"
      for (let j = 0; j < len; j++) {
        options.push({
          value: this.$store.state.dynamicTags[j],
          label: this.$store.state.dynamicTags[j],
          children: [
            {
              value: this.$store.state.dynamicTags[j] + "-easy",
              label: this.$store.state.dynamicTags[j] + "-easy"
            },
            {
              value: this.$store.state.dynamicTags[j] + "-normal",
              label: this.$store.state.dynamicTags[j] + "-normal"
            },
            {
              value: this.$store.state.dynamicTags[j] + "-hard",
              label: this.$store.state.dynamicTags[j] + "-hard"
            }
          ]
        })
      }
      return options
    }
  },
  mounted() {
    this.courseId = document.querySelector("#courseId").value
    this.treeData = this.getTreeData()
  }
}
</script>

<style>
/* tree */
.custom-tree-container {
  font-size: 20px;
  font-weight: 400;
}
.custom-tree-node {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding-right: 8px;
}
.el-tree-node__children {
  font-size: 18px;
  font-weight: 350;
}
.el-tree-node__content {
  height: 38px;
}

.el-tag {
  margin-right: 10px;
  margin-bottom: 8px;
}

/* tag 输入 */
.button-new-tag {
  height: 32px;
  line-height: 30px;
  padding-top: 0;
  padding-bottom: 0;
}
.input-new-tag {
  width: 150px;
  vertical-align: bottom;
}

/* claim list */
.claim-list {
  height: 136px;
  font-size: 17px;
  padding-left: 0px;
  overflow-y: auto;
  color: #303133;
}
.claim {
  height: 34px;
  padding-top: 4px;
}
.claim:hover {
  background: #f5f7fa;
}
.claim span {
  color: #c0c4cc;
}
.claim span:hover {
  color: #303133;
}
.claimInput {
  margin-bottom: 10px;
}
/* dialog tags */
.tagsContainer {
  display: flex;
  flex-wrap: wrap;
}
</style>