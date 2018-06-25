import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

// const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    state: {
        dynamicTags: []
    },
    mutations: {
        addTag(state, tag) {
            state.dynamicTags.push(tag)
        },
        removeTag(state, tag) {
            state.dynamicTags.splice(state.dynamicTags.indexOf(tag), 1)
        },
        setTag(state, tags) {
            state.dynamicTags = tags
        }
    },
    getters: {},
    actions: {},
})