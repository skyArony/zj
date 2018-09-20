import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

// const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    state: {
        // 一门课程的 tags
        dynamicTags: [],
        // 当前问卷页的所有问题
        questions: [],
        // 正在设置的问题的 index
        index: null,
        // 当前要从课程总tag 表中删除的 tag
        removeTag: '',
        // 用户的个人信息
        userInfo: {}
    },
    mutations: {
        // 设置用户信息
        setUserInfo(state, data) {
            state.userInfo = data
        },
        // 添加 tag
        addTag(state, tag) {
            state.dynamicTags.push(tag)
        },
        // 删除 tag
        removeTag(state, tag) {
            state.removeTag = tag
            state.dynamicTags.splice(state.dynamicTags.indexOf(tag), 1)
        },
        // 批量设置 tag
        setTag(state, tags) {
            state.dynamicTags = tags
        },
        // 添加 question
        addQuestion(state, question) {
            state.questions.push(question)
        },
        // 删除 question,根据情况重置或删除 index
        deleteQuestion(state, question) {
            if (state.index != null)
                var nowId = state.questions[state.index].id
            let deleteIndex = state.questions.findIndex(
                function (item) {
                    return item.id == question.id
                })
            state.questions.splice(deleteIndex, 1)
            if (state.index != null) {
                if (deleteIndex == state.index)
                    state.index = null
                else
                    state.index = state.questions.findIndex(
                        function (item) {
                            return item.id == nowId
                        })
            }

        },
        // 批量设置 question
        setQuestion(state, questions) {
            state.questions = questions
        },
        // 编辑 question 的选项和题干
        editQuestion(state, question) {
            let index = state.questions.findIndex(
                function (item) {
                    return item.id == question.id
                })
            if (question.question) state.questions[index].question = question.question
            if (question.options) state.questions[index].options = question.options
        },
        // 删除问题的一个选项
        deleteOption(state, option) {
            let index = state.questions[state.index].options.indexOf(option)
            state.questions[state.index].options.splice(index, 1)
        },
        // 设置正在编辑 Detail 的 question 的 index
        editQuestionDetail(state, question) {
            state.index = state.questions.findIndex(
                function (item) {
                    return item.id == question.id
                })
        },
        //  添加一个 tag 到 option 的 addtag 或 removeTag
        addTagToOption(state, obj) {
            if (obj.type == 'add') {
                if (state.questions[state.index].addTags[obj.option]) {
                    if (!state.questions[state.index].addTags[obj.option].includes(obj.tag))
                        state.questions[state.index].addTags[obj.option].push(obj.tag)
                } else {
                    Vue.set(state.questions[state.index].addTags, obj.option, [])
                    state.questions[state.index].addTags[obj.option].push(obj.tag)
                }
            } else if (obj.type == 'remove') {
                if (state.questions[state.index].removeTags[obj.option]) {
                    if (!state.questions[state.index].removeTags[obj.option].includes(obj.tag))
                        state.questions[state.index].removeTags[obj.option].push(obj.tag)
                }
                else {
                    Vue.set(state.questions[state.index].removeTags, obj.option, [])
                    state.questions[state.index].removeTags[obj.option].push(obj.tag)
                }
            }
        },
        // 清空所有问题的已选 addTag 和 removetag
        clearAllQuestionsTag(state) {
            for(let index in state.questions) {
                state.questions[index].addTags = {}
                state.questions[index].removeTags = {}
            }
        },
        // 在 option 的一个 addTag 和 removetag 中移除一个 tag
        removeTagFromOption(state, obj) {
            if (obj.type == 'add') {
                state.questions[state.index].addTags[obj.option].splice(obj.index, 1)
            } else if (obj.type == 'remove') {
                state.questions[state.index].removeTags[obj.option].splice(obj.index, 1)
            }
        }
    },
    getters: {},
    actions: {},
})