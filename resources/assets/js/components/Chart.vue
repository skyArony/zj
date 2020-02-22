<template>
  <div>
    <div id="survey" class="tab-pane fade in show active">
      <el-row>
        <b>时间段:&nbsp;</b>
        <el-date-picker
          v-model="timeRange"
          size="small"
          :editable="false"
          value-format="timestamp"
          type="daterange"
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        ></el-date-picker
        >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>课程:&nbsp;</b>
        <el-select v-model="courseId" size="small" placeholder="请选择">
          <el-option
            v-for="item in allUserCourse"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          ></el-option> </el-select
        >&nbsp;&nbsp;&nbsp;
        <el-button type="primary" size="small" @click="getSurveyRecord()"
          >查询</el-button
        >
      </el-row>
      <hr />
      <h3>
        <i class="voyager-documentation"></i> 问卷统计
        <small>课程问卷的填写统计</small>
      </h3>
      <div style="height:700px; width:100%;">
        <canvas id="surveyChart" style="height:700px; width:100%"></canvas>
      </div>
    </div>
    <div id="record" class="tab-pane fade in">
      <el-row>
        <b>时间段:&nbsp;</b>
        <el-date-picker
          v-model="timeRange"
          size="small"
          :editable="false"
          value-format="timestamp"
          type="daterange"
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        ></el-date-picker
        >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>课程:&nbsp;</b>
        <el-select v-model="courseId" size="small" placeholder="请选择">
          <el-option
            v-for="item in allUserCourse"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          ></el-option> </el-select
        >&nbsp;&nbsp;&nbsp;
        <b>班级:&nbsp;</b>
        <el-select v-model="classId" size="small" placeholder="请选择">
          <el-option
            v-for="item in classList"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          ></el-option> </el-select
        >&nbsp;&nbsp;&nbsp;
        <el-button type="primary" size="small" @click="getRecordList()"
          >查询</el-button
        >
      </el-row>
      <hr />
      <h3>
        <i class="voyager-documentation"></i> 问卷记录
        <small>课程问卷的填写记录</small>
      </h3>
      <el-table :data="tableData" style="width: 100%">
        <el-table-column type="index" width="50"> </el-table-column>
        <el-table-column prop="user" label="填写者"> </el-table-column>
        <el-table-column prop="userId" label="填写者 ID"> </el-table-column>
        <el-table-column prop="sid" label="填写者学号"> </el-table-column>
        <el-table-column prop="time" label="填写时间"> </el-table-column>
        <el-table-column prop="action" label="操作">
          <template slot-scope="scope">
            <el-button
              @click="showRecord(scope.row)"
              type="primary"
              size="small"
            >
              查看
            </el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div id="tag" class="tab-pane fade in">
      <el-row>
        <b>时间段:&nbsp;</b>
        <el-date-picker
          v-model="timeRange"
          size="small"
          :editable="false"
          value-format="timestamp"
          type="daterange"
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        ></el-date-picker
        >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>课程:&nbsp;</b>
        <el-select v-model="courseId" size="small" placeholder="请选择">
          <el-option
            v-for="item in allUserCourse"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          ></el-option> </el-select
        >&nbsp;&nbsp;&nbsp;
        <el-button type="primary" size="small" @click="getSurveyRecord()"
          >查询</el-button
        >
      </el-row>
      <hr />
      <h3>
        <i class="voyager-tag"></i> 知识点
        <small>定制课程标记的知识点</small>
      </h3>
      <div style="height:500px; width:500px; margin:40px auto">
        <canvas id="tagChart" style="height:500px; width:500px"></canvas>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      MyAxios: axios.create({
        headers: { 'Content-Type': 'application/json' }
      }),
      chartSelect: 1, // 选择的表格
      timeRange: '', //  时间范围
      courseId: '', // 课程 ID
      surveyRecords: '', // 请求到的数据
      allUserCourse: [], // 用户所有的课程信息
      tagsData: [], // 获取到的当前课程的 tag 信息
      tableData: [], // 表格数据
      classList: [],
      classId : '' // 班级 ID
    }
  },
  methods: {
    // 初始化
    init() {
      this.getUserAllCourse()
    },
    // 获取用户所有的班级
    getClassList() {
      let that = this
      this.MyAxios.get('/api/classList')
        .then(function(response) {
          console.log(response)
          for (var index in response.data.data) {
            that.classList.push({
              value: response.data.data[index].id,
              label: response.data.data[index].className,
            })
          
          }
          if (that.allUserCourse.length > 0) {
            that.classId = that.classList[0].value
            that.getSurveyRecord()
            that.getRecordList()
          }
        })
    },
    // 获取某一门课程的所有问卷记录
    getRecordList() {
      this.tableData = []
      let that = this
      this.MyAxios.get('/api/surveyRecord/courseId/' + this.courseId, {
          params: {
            classId: this.classId,
          }
        })
        .then(function(response) {
            for (var index in response.data.data) {
            that.tableData.push({
              time: response.data.data[index].created_at,
              userId: response.data.data[index].creater_id,
              sid: response.data.data[index].user.sid,
              user: response.data.data[index].user.name,
              recordId: response.data.data[index].id,
              courseId: response.data.data[index].course_id,
            })
          }
        })
    },
    // 获取用户所有的课程
    getUserAllCourse() {
      let that = this
      this.MyAxios.get('/api/user/course')
        .then(function(response) {
          for (var index in response.data.data) {
            that.allUserCourse.push({
              value: response.data.data[index].id,
              label: response.data.data[index].name
            })
          }
          if (that.allUserCourse.length > 0) {
            that.courseId = that.allUserCourse[0].value
            that.getClassList()
          }
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    // 初始化获取数据
    getSurveyRecord() {
      this.surveyRecords = []
      this.tagsData = []
      let that = this
      // 课程 ID 必须
      if (!this.courseId) {
        alert('课程选择不能为空')
        return
      }
      // 默认时间段
      if (!this.timeRange) {
        this.timeRange = []
        this.timeRange.push(Date.now() - 1296000000)
        this.timeRange.push(Date.now())
      }
      this.MyAxios.get('/api/chart/surveyRecord/', {
        params: {
          startTime: this.timeRange[0],
          endTime: this.timeRange[1],
          courseId: this.courseId
        }
      })
        .then(function(response) {
          that.surveyRecords = response.data.data
          that.getTagDetail()
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    // 获取 tag 详细信息
    getTagDetail() {
      let that = this
      // 课程 ID 必须
      if (!this.courseId) {
        alert('课程选择不能为空')
        return
      }
      this.MyAxios.get('/api/tag/detail/' + this.courseId)
        .then(function(response) {
          that.tagsData = response.data.data
          that.renderChart()
        })
        .catch(function(error) {
          alert(error.response.data.errmsg)
        })
    },
    // 渲染表格
    renderChart() {
      let that = this
      // 问卷数据表格渲染
      var ctx = document.getElementById('surveyChart').getContext('2d')
      var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: this.x,
          datasets: [
            {
              label: '填写数',
              data: this.surveyChartData,
              borderColor: 'rgba(54, 162, 235, 0.3)',
              backgroundColor: 'rgba(54, 162, 235, 0.3)',
              borderWidth: 2,
              lineTension: 0
            }
          ]
        },
        options: {
          scales: {
            yAxes: [
              {
                ticks: {
                  stepSize: 5,
                  suggestedMax: 5
                }
              }
            ]
          }
        }
      })

      // 知识点数据表格渲染
      var ctx2 = document.getElementById('tagChart').getContext('2d')
      var myLineChart = new Chart(ctx2, {
        type: 'pie',
        data: {
          labels: this.tagChartData[1],
          datasets: [
            {
              data: this.tagChartData[0],
              backgroundColor: this.tagChartData[2]
            }
          ]
        },
        options: {}
      })
    },
    // 选择图表
    selectChart(index) {
      this.chartSelect = index
    },
    // 跳转填写记录
    showRecord(row) {
      window.open('/showCustomCourse/' + row.courseId + '/' + row.recordId)
    }

  },
  computed: {
    // 线形图 x 轴的内容
    x: function() {
      let data = []
      let start = moment(this.timeRange[0])
      let end = moment(this.timeRange[1])
      while (start <= end) {
        data.push(start.format('YYYY.M.D'))
        start.add(1, 'd')
      }
      return data
    },
    // 线形图 表格数据
    surveyChartData: function() {
      let data = []
      let temp = {}
      for (let key in this.surveyRecords) {
        let date = this.surveyRecords[key].updated_at.substr(0, 10)
        if (temp.hasOwnProperty(date)) temp[date] += 1
        else temp[date] = 1
      }
      let start = moment(this.timeRange[0])
      let end = moment(this.timeRange[1])
      while (start <= end) {
        let dateKey = start.format('YYYY-MM-DD')
        if (temp.hasOwnProperty(dateKey)) data.push(temp[dateKey])
        else data.push(0)
        // else data.push(Math.round(Math.random() * 100) + 0)
        start.add(1, 'd')
      }
      return data
    },

    // 饼状图 表格数据
    tagChartData: function() {
      let data = []
      data[0] = [] // 数量
      data[1] = [] // tag
      data[2] = [] // 颜色
      let temp = {}
      for (let key in this.surveyRecords) {
        let tags = JSON.parse(this.surveyRecords[key].tags)
        for (let key2 in tags) {
          if (temp.hasOwnProperty(tags[key2])) temp[tags[key2]] += 1
          else temp[tags[key2]] = 1
        }
      }
      for (let key in temp) {
        data[0].push(temp[key])
        data[1].push(this.tagsData[key].label)
        data[2].push(
          '#' +
            ('00000' + ((Math.random() * 0x1000000) << 0).toString(16)).substr(
              -6
            )
        )
      }
      if (data[0].length == 0 && data[1].length == 0) {
        data[0] = [1]
        data[1] = ['无数据']
      }
      return data
    }
  },
  mounted: function() {
    this.init()
  }
}
</script>


<style lang="stylus" scoped></style>
