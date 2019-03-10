<template>
  <div>
    <div class="pannel container">搜索用户：<br/>
      <el-input v-model="keyword"
                type="search"
                @blur="keywordCheck"
                placeholder="请输入内容"
                class="input-with-select">
        <el-select v-model="type"
                   slot="prepend"
                   placeholder="搜索方式">
          <el-option label="根据 ID 号搜索"
                     value="id"></el-option>
          <el-option label="根据用户名搜索"
                     value="name"></el-option>
        </el-select>
        <el-button slot="append"
                   icon="el-icon-search"
                   @click="search"></el-button>
      </el-input>
      <el-button size="medium"
                 type="primary"
                 style="margin-left:20px"
                 @click="showQRCode">扫码加入班级</el-button>
      <div class="search-res">
        <el-card v-for="(item, index) in searchRes"
                 :key="index"
                 :body-style="{ padding: '0px', display: 'flex', height: '100px', width: '280px'}">
          <img :src="item.avatar">
          <div class="search-res-item-info">
            <span class="item-name">{{item.name}}</span>
            <span class="item-id">{{item.id}}</span>
            <el-button size="mini"
                       type="text"
                       @click="addMember(item)">添加成员</el-button>
          </div>
        </el-card>
      </div>
    </div>
    <div class="pannel container">
      {{className}}
      <font style="font-size:14px;color:#2196f3;">{{tableData.length}}人</font>
      <el-table :data="tableData"
                style="width: 100%">
        <el-table-column label="头像"
                         width="180">
          <template slot-scope="scope">
            <img :src="scope.row.avatar" />
          </template>
        </el-table-column>
        <el-table-column prop="name"
                         label="名称">
        </el-table-column>
        <el-table-column prop="id"
                         label="ID">
        </el-table-column>
        <el-table-column prop="phone"
                         label="手机">
        </el-table-column>
        <el-table-column prop="QQ"
                         label="QQ">
        </el-table-column>
        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button size="mini"
                       type="danger"
                       @click="deleteMember(scope.row.id)">删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      MyAxios: axios.create({
        headers: { "Content-Type": "application/json" }
      }),
      type: "",
      keyword: "",
      classId: "",
      className: "",
      tableData: [],
      searchRes: []
    }
  },
  methods: {
    init() {
      let that = this
      this.classId = window.location.href.match(/\d+/)[0]
      // 团队成员信息
      this.MyAxios.get("/api/class/member/" + this.classId)
        .then(function(response) {
          that.tableData = response.data.data
        })
        .catch(function(error) {
          if (error.response.status == 404) location.href = "/404"
          else alert(error.response.data.errmsg)
        })
      // 团队信息
      this.MyAxios.get("/api/class/" + this.classId)
        .then(function(response) {
          that.className = response.data.data.className
        })
        .catch(function(error) {
          if (error.response.status == 404) location.href = "/404"
          else alert(error.response.data.errmsg)
        })
    },
    search() {
      if (this.keyword == "" || this.select == "" || this.type == "") return
      else {
        let that = this
        this.MyAxios.get("/api/search/user", {
          params: {
            keyword: this.keyword,
            type: this.type
          }
        })
          .then(function(response) {
            that.searchRes = response.data.data
          })
          .catch(function(error) {
            alert(error.response.data.errmsg)
          })
      }
    },
    addMember(user) {
      let that = this
      this.MyAxios.post("/api/class/member/", {
        classId: this.classId,
        sid: user.id
      })
        .then(function(response) {
          that.tableData.push(user)
          that.tableData = Array.from(new Set(that.tableData))
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    deleteMember(userId) {
      let that = this
      this.MyAxios.delete("/api/class/member/", {
        params: {
          classId: this.classId,
          sid: userId
        }
      })
        .then(function(response) {
          that.tableData = that.tableData.filter(function(item) {
            return item.id != userId
          })
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    keywordCheck() {
      if (this.keyword == "") this.searchRes = ""
    },
    showQRCode() {
      this.$alert("<div id='qrcode'></div>", "扫码加入班级", {
        dangerouslyUseHTMLString: true
      })
        .then(() => {})
        .catch(() => {})

      // 这里有必要延时,否则会报错
      setTimeout(function() {
        let domain = window.location.href.match(/^(.*?)\/admin\/.*?/)[1]
        let classId = window.location.href.match(
          /^.*?\/admin\/class\/member\/(\d+)/
        )[1]
        let joinUrl = domain + "/joinclass/" + classId
        if (document.getElementById("qrcode").innerHTML == "") {
          let qrcode = new QRCode("qrcode", {
            width: 350,
            height: 350
          })
          qrcode.makeCode(joinUrl)
        }
      }, 50)
    }
  },
  mounted: function() {
    this.init()
  }
}
</script>


<style lang="stylus" scoped>
.pannel
  margin-bottom 22px
  background-color #fff
  border 1px solid transparent
  border-radius 4px
  box-shadow 0 2px 10px rgba(0, 0, 0, 0.05)

.container
  padding 15px 25px
  width 100%
  font-size 17px
  font-weight 400

  .input-with-select
    margin-top 15px
    width 700px

    .el-select
      width 145px

  .el-table img
    width 50px
    height 50px
    object-fit cover

.search-res
  margin-top 10px
  display flex
  flex-wrap wrap

  .el-card
    margin-right 20px
    margin-top 15px

  img
    width 100px
    height 100px

  .search-res-item-info
    flex-grow 1
    padding 14px
    display flex
    flex-direction column
    text-align center

    .item-id
      font-size 12px

    .el-button
      margin-top 10px
</style>

<style>
.el-input-group__prepend {
  background-color: #fff;
}
#qrcode img {
  margin: auto;
}
</style>





