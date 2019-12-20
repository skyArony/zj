<template>
  <div class="question">
    <font>{{question.title}}</font>
    <div class="option">
      <el-radio-group v-if="question.type == 'radio'" v-model="radio" @change="emitData">
        <el-radio v-for="(value, key) in options" :key="key" :label="key">{{value}}</el-radio>
      </el-radio-group>
      <el-checkbox-group
        v-else-if="question.type == 'multi'"
        v-model="checkList"
        @change="emitData"
      >
        <el-checkbox v-for="(value, key) in options" :key="key" :label="key">{{value}}</el-checkbox>
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
      radio: '',
      checkList: []
    }
  },
  computed: {
    options: function() {
      return JSON.parse(this.question.option)
    }
  },
  methods: {
    emitData(data) {
      let answer = JSON.parse(this.question.answer)
      let res = false
      if (typeof data == 'string') {
        if (data == '') res = null
        else if (data == answer) res = true
        else res = false
      } else {
        res = this.arrayEquals(data, answer)
      }
      this.$emit('setAnswer', {
        id: this.question.id,
        status: res
      })
    },
    arrayEquals(arr1, arr2) {
      if (arr1.length == 0) return null
      else if (arr1.length != arr2.length) return false
      else {
        arr1.sort()
        arr2.sort()
        for (let i = 0; i < arr1.length; i++) {
          if (arr1[i] != arr2[i]) return false
        }
        return true
      }
    }
  }
}
</script>

<style scoped>
.el-checkbox,
.el-radio {
  margin-left: 0px;
  margin-right: 30px;
  margin-bottom: 5px;
  white-space: normal;
  display: flex;
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
  padding: 15px 10px 10px 10px;
}
</style>

<style>
.el-radio__label {
  line-height: 19px;
}
</style>

