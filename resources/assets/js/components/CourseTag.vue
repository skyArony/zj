<template>
  <div>
    <el-tag :key="tag"
            v-for="tag in dynamicTags"
            closable
            :disable-transitions="false"
            @close="handleClose(tag)">
      {{tag}}
    </el-tag>
    <el-input class="input-new-tag"
              v-if="inputVisible"
              v-model="inputValue"
              ref="saveTagInput"
              size="small"
              @keyup.enter.native="handleInputConfirm"
              @blur="handleInputConfirm">
    </el-input>
    <el-button v-else
               class="button-new-tag"
               size="small"
               @click="showInput"
               ref="myBtn">+ New Tag</el-button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dynamicTags: "",
      inputVisible: false, // 是否显示输入的表单，false 时显示文字，true 时显示表单
      inputValue: "",
      courseId: ""
    };
  },
  methods: {
    // 显示输入框
    showInput() {
      this.inputVisible = true;
      this.$nextTick(_ => {
        this.$refs.saveTagInput.$refs.input.focus();
      });
    },

    // 警告提示
    warning(msg) {
      this.$notify({
        title: "警告",
        message: msg,
        type: "warning",
        duration: "2000"
      });
    },

    // 错误提示
    error(msg) {
      this.$notify({
        title: "错误",
        message: msg,
        type: "error",
        duration: "2000"
      });
    },

    // 删除一个 tag
    async handleClose(tag) {
      let response = await this.removeTag(tag);
      if (response.data.errcode == 0) {
        this.$store.commit("removeTag", tag);
        // this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
      } else {
        this.error(response.data.errcode + ":" + response.data.errmsg);
      }
    },

    // 增加一个 tag
    async handleInputConfirm() {
      let inputValue = this.inputValue.replace(/\s/g, '')
      console.log(inputValue)
      if (inputValue) {
        if (this.dynamicTags.indexOf(inputValue) == -1) {
          let response = await this.addTag(inputValue);
          if (response.data.errcode == 0) {
            this.$store.commit("addTag", inputValue);
            // this.dynamicTags.push(inputValue);
            this.inputVisible = false;
            this.inputValue = "";
          } else {
            this.error(response.data.errcode + ":" + response.data.errmsg);
          }
        } else this.warning("重复的标签");
      } else {
        this.inputValue = ''
        this.inputVisible = false;
      }
    },

    // 添加 tag 的 ajax
    addTag(tag) {
      let that = this
      let MyAxios = axios.create({
        headers: { "Content-Type": "application/json" }
      });
      return MyAxios.post("/api/tag/" + this.courseId, {
        tag: tag
      }).catch(function(error) {
        if(error.response.data.errcode == -4009)
          alert("没有操作权限!")
        else alert(error.response.data.errmsg)
        that.inputValue = "";
      });
    },

    // 删除 tag 的 ajax
    removeTag(tag) {
      let MyAxios = axios.create();
      return MyAxios.delete("/api/tag/" + this.courseId, {
        params: {
          tag: tag
        }
      }).catch(function(error) {
        if(error.response.data.errcode == -4009)
          alert("没有操作权限!")
        else alert(error.response.data.errmsg)
      });
    },

    // 获取 tag 的 ajax
    listTags() {
      var that = this;
      let MyAxios = axios.create();
      MyAxios.get("/api/tag/" + this.courseId).then(function(response) {
        if (response.data.errcode == 0) {
          that.dynamicTags = response.data.data;
          that.$store.commit("setTag", that.dynamicTags);
        }
      }).catch(function(error) {
        alert(error.response.data.errmsg)
      });
    }
  },
  mounted: function() {
    this.courseId = document.querySelector("#courseId").value;
    this.listTags();
  }
};
</script>

<style scoped>
.el-tag {
  margin-right: 10px;
  margin-bottom: 10px;
}
.button-new-tag {
  height: 32px;
  line-height: 30px;
  padding-top: 0;
  padding-bottom: 0;
  margin-bottom: 10px;
}
.input-new-tag {
  width: 90px;
  vertical-align: bottom;
  margin-bottom: 10px;
}
</style>