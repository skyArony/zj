<!-- dialog 中的东西太多导致第一次渲染速度比较慢 -->
<template>
  <div class="custom-tree-container">
    <div class="block">
      <el-tree :data="treeData"
               node-key="mytree"
               default-expand-all
               :expand-on-click-node="false">
        <span class="custom-tree-node"
              slot-scope="{ node, data }">
          <span>{{ node.label }} </span>
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
          <!-- 章节编辑 -->
          <el-dialog title="编辑章节 tag 和课程目标"
                     :visible.sync="unityDialogVisible"
                     width="70%">
            <el-tag :key="index"
                    closable
                    v-for="(tag, index) in selectedTags"
                    :disable-transitions="false"
                    @close="tagClose(index)">
              {{tag}}
            </el-tag>
            <el-autocomplete v-if="inputVisible"
                             class="input-new-tag"
                             :fetch-suggestions="querySearch"
                             v-model="inputValue"
                             ref="saveTagInput"
                             size="small"
                             @select="handleInputConfirm"
                             @keyup.enter.native="handleInputConfirm"
                             @blur="handleInputConfirm">
            </el-autocomplete>
            <el-button v-else
                       class="button-new-tag"
                       size="small"
                       @click="showInput"
                       ref="myBtn">+ New Tag</el-button>
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
                         @click="unityDialogVisible = false">确 定</el-button>
            </span>
          </el-dialog>
          <!-- 课时编辑 -->
          <el-dialog title="编辑课时 tag 和课程目标"
                     :visible.sync="dialogVisible"
                     width="70%">
            <el-tag :key="index"
                    closable
                    v-for="(tag, index) in selectedTags"
                    :disable-transitions="false"
                    @close="tagClose(index)">
              {{tag}}
            </el-tag>
            <el-autocomplete v-if="inputVisible"
                             class="input-new-tag"
                             :fetch-suggestions="querySearch"
                             v-model="inputValue"
                             ref="saveTagInput"
                             size="small"
                             @select="handleInputConfirm"
                             @keyup.enter.native="handleInputConfirm"
                             @blur="handleInputConfirm">
            </el-autocomplete>
            <el-button v-else
                       class="button-new-tag"
                       size="small"
                       @click="showInput"
                       ref="myBtn">+ New Tag</el-button>
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
                         @click="dialogVisible = false">确 定</el-button>
            </span>
          </el-dialog>
        </span>
      </el-tree>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      courseId: "",
      /* dialog */
      inputVisible: false, // 是否显示输入tag的表单，false 时显示文字，true 时显示表单
      inputValue: "", // 表单中输入的内容
      tags: [], // 可选的 tag
      selectedTags: [], // dialog 中被选择的 tag
      claims: [], // 教学要求
      claimsText: "", // 新输入的 claimsText
      dialogVisible: false, // 课时的编辑
      unityDialogVisible: false, // 章节的编辑
      /* coursetree */
      treeData: [],
      courseTree: "",
      /* tag */
      dynamicTags: "" // 本门课的可选 tag
    };
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
      });
    },

    /* tag 选择输入相关 */

    // 显示输入框并获取焦点，refs 相当于便捷选择器
    showInput() {
      this.inputVisible = true;
      this.$nextTick(_ => {
        this.$refs.saveTagInput.$refs.input.focus();
      });
    },

    // 增加一个 tag
    handleInputConfirm() {
      let inputValue = this.inputValue;
      if (inputValue) {
        if (this.tags.indexOf(inputValue) == -1) {
          this.selectedTags.push(inputValue);
          this.inputVisible = false;
          this.inputValue = "";
        } else this.warning("不存在的Tag，请先在上面添加");
      } else {
        this.inputVisible = false;
      }
    },

    // 删除一个 tag
    async handleClose(tag) {
      let response = await this.removeTag(tag);
      if (response.data.errcode == 0) {
        this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
      } else {
        this.error(response.data.errcode + ":" + response.data.errmsg);
      }
    },

    querySearch(queryString, cb) {
      var tags = this.tags;
      var results = queryString
        ? tags.filter(this.createFilter(queryString))
        : tags;
      // 调用 callback 返回建议列表的数据
      cb(results);
    },
    createFilter(queryString) {
      return tags => {
        return (
          tags.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0
        );
      };
    },
    getAllTags() {
      return [
        { value: "三全鲜食（北新泾店）", address: "长宁区新渔路144号" },
        {
          value: "Hot honey 首尔炸鸡（仙霞路）",
          address: "上海市长宁区淞虹路661号"
        },
        {
          value: "新旺角茶餐厅",
          address: "上海市普陀区真北路988号创邑金沙谷6号楼113"
        },
        { value: "泷千家(天山西路店)", address: "天山西路438号" },
        {
          value: "胖仙女纸杯蛋糕（上海凌空店）",
          address: "上海市长宁区金钟路968号1幢18号楼一层商铺18-101"
        },
        { value: "贡茶", address: "上海市长宁区金钟路633号" },
        {
          value: "豪大大香鸡排超级奶爸",
          address: "上海市嘉定区曹安公路曹安路1685号"
        },
        {
          value: "茶芝兰（奶茶，手抓饼）",
          address: "上海市普陀区同普路1435号"
        },
        { value: "十二泷町", address: "上海市北翟路1444弄81号B幢-107" },
        { value: "星移浓缩咖啡", address: "上海市嘉定区新郁路817号" },
        { value: "阿姨奶茶/豪大大", address: "嘉定区曹安路1611号" },
        { value: "新麦甜四季甜品炸鸡", address: "嘉定区曹安公路2383弄55号" },
        {
          value: "Monica摩托主题咖啡店",
          address: "嘉定区江桥镇曹安公路2409号1F，2383弄62号1F"
        },
        {
          value: "浮生若茶（凌空soho店）",
          address: "上海长宁区金钟路968号9号楼地下一层"
        },
        { value: "NONO JUICE  鲜榨果汁", address: "上海市长宁区天山西路119号" },
        { value: "CoCo都可(北新泾店）", address: "上海市长宁区仙霞西路" },
        {
          value: "快乐柠檬（神州智慧店）",
          address: "上海市长宁区天山西路567号1层R117号店铺"
        },
        {
          value: "Merci Paul cafe",
          address: "上海市普陀区光复西路丹巴路28弄6号楼819"
        },
        {
          value: "猫山王（西郊百联店）",
          address: "上海市长宁区仙霞西路88号第一层G05-F01-1-306"
        },
        { value: "枪会山", address: "上海市普陀区棕榈路" },
        { value: "纵食", address: "元丰天山花园(东门) 双流路267号" },
        { value: "钱记", address: "上海市长宁区天山西路" },
        { value: "壹杯加", address: "上海市长宁区通协路" },
        {
          value: "唦哇嘀咖",
          address: "上海市长宁区新泾镇金钟路999号2幢（B幢）第01层第1-02A单元"
        },
        { value: "爱茜茜里(西郊百联)", address: "长宁区仙霞西路88号1305室" },
        {
          value: "爱茜茜里(近铁广场)",
          address:
            "上海市普陀区真北路818号近铁城市广场北区地下二楼N-B2-O2-C商铺"
        },
        {
          value: "鲜果榨汁（金沙江路和美广店）",
          address: "普陀区金沙江路2239号金沙和美广场B1-10-6"
        },
        {
          value: "开心丽果（缤谷店）",
          address: "上海市长宁区威宁路天山路341号"
        },
        { value: "超级鸡车（丰庄路店）", address: "上海市嘉定区丰庄路240号" },
        { value: "妙生活果园（北新泾店）", address: "长宁区新渔路144号" },
        { value: "香宜度麻辣香锅", address: "长宁区淞虹路148号" },
        {
          value: "凡仔汉堡（老真北路店）",
          address: "上海市普陀区老真北路160号"
        },
        { value: "港式小铺", address: "上海市长宁区金钟路968号15楼15-105室" },
        { value: "蜀香源麻辣香锅（剑河路店）", address: "剑河路443-1" },
        { value: "北京饺子馆", address: "长宁区北新泾街道天山西路490-1号" },
        {
          value: "饭典*新简餐（凌空SOHO店）",
          address: "上海市长宁区金钟路968号9号楼地下一层9-83室"
        },
        {
          value: "焦耳·川式快餐（金钟路店）",
          address: "上海市金钟路633号地下一层甲部"
        },
        { value: "动力鸡车", address: "长宁区仙霞西路299弄3号101B" },
        { value: "浏阳蒸菜", address: "天山西路430号" },
        { value: "四海游龙（天山西路店）", address: "上海市长宁区天山西路" },
        {
          value: "樱花食堂（凌空店）",
          address: "上海市长宁区金钟路968号15楼15-105室"
        },
        { value: "壹分米客家传统调制米粉(天山店)", address: "天山西路428号" },
        {
          value: "福荣祥烧腊（平溪路店）",
          address: "上海市长宁区协和路福泉路255弄57-73号"
        },
        {
          value: "速记黄焖鸡米饭",
          address: "上海市长宁区北新泾街道金钟路180号1层01号摊位"
        },
        { value: "红辣椒麻辣烫", address: "上海市长宁区天山西路492号" },
        {
          value: "(小杨生煎)西郊百联餐厅",
          address: "长宁区仙霞西路88号百联2楼"
        },
        { value: "阳阳麻辣烫", address: "天山西路389号" },
        {
          value: "南拳妈妈龙虾盖浇饭",
          address: "普陀区金沙江路1699号鑫乐惠美食广场A13"
        }
      ];
    },
    // 获取 treedata
    getTreeData() {
      var that = this;
      const { search } = window.location;
      let searchParams = new URLSearchParams(search);
      let courseId = searchParams.get("courseId");
      let MyAxios = axios.create({
        baseURL: "http://zj.yfree.ccc/api/",
        headers: { "Content-Type": "application/json" }
      });

      MyAxios.get("/courseTree", { params: { courseId: this.courseId } }).then(
        function(response) {
          if (response.data.errcode == 0) {
            that.courseTree = response.data.data;
            let child = [];
            for (let i in response.data.data) {
              child = [];
              for (let j in response.data.data[i]) {
                let obj2 = {
                  id: j,
                  label: response.data.data[i][j].period_title,
                  claims: response.data.data[i][j].period_summary
                };
                child.push(obj2);
              }
              let obj = {
                id: i,
                label: response.data.data[i].chapter_name,
                children: child
              };
              child.pop(); // 去掉一个不必要的干扰元素
              that.treeData.push(obj);
            }
          }
        }
      );
      a; /////////////////???????
    },
    // 显示章节和课时属性
    dialogDataSet(isChapter, id) {
      if (isChapter) {
        this.unityDialogVisible = true;
        let chapter = this.courseTree[id];
        let tags = [];
        let claims = [];
        for (let i in chapter) {
          if (chapter[i].tags) tags = tags.concat(chapter[i].tags);
          if (chapter[i].claims) claims = claims.concat(chapter[i].claims);
        }
        tags = Array.from(new Set(tags));
        claims = Array.from(new Set(claims));
        this.claims = claims;
        this.selectedTags = tags;
      } else {
        this.dialogVisible = true;
        let courseTree = this.courseTree;
        let tags = [];
        let claims = [];
        for (let i in courseTree) {
          if (courseTree[i][id]) {
            if (courseTree[i][id].tags)
              tags = tags.concat(courseTree[i][id].tags);
            if (courseTree[i][id].claims)
              claims = claims.concat(courseTree[i][id].claims);
            break;
          }
        }
        tags = Array.from(new Set(tags));
        claims = Array.from(new Set(claims));
        this.claims = claims;
        this.selectedTags = tags;
      }
    },
    // 删除一个 claim
    removeClaim(claimIndex) {
      this.claims.splice(claimIndex, 1);
    },
    // 添加一个 claim
    claimsInputConfirm() {
      if (this.claimsText) {
        this.claims.splice(0, 0, this.claimsText);
        this.claimsText = "";
      }
    },
    // 删除一个 tag
    tagClose(index) {
      this.selectedTags.splice(index, 1);
    }
  },
  mounted() {
    this.courseId = document.querySelector("#courseId").value;
    this.tags = this.getAllTags();
    this.treeData = this.getTreeData();
  }
};
</script>

<style scope>
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
  margin-right: 5px;
}
.el-popover {
}

/* tag 输入 */
.button-new-tag {
  width: 100px;
  height: 32px;
  line-height: 30px;
  padding-top: 0;
  padding-bottom: 0;
}
.input-new-tag {
  width: 210px;
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
</style>