
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// 单文件组件
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('worlduc-coursetree', require('./components/CourseTree.vue'));
Vue.component('worlduc-coursetag', require('./components/CourseTag.vue'));
Vue.component('worlduc-surveyedit', require('./components/SurveyEdit.vue'));
Vue.component('worlduc-questionedit', require('./components/QuestionEdit.vue'));
Vue.component('worlduc-questionList', require('./components/QuestionList.vue'));
Vue.component('worlduc-option', require('./components/Option.vue'));
Vue.component('worlduc-questionDetail', require('./components/QuestionDetail.vue'));
Vue.component('worlduc-survey', require('./components/Survey.vue'));
Vue.component('worlduc-question', require('./components/Question.vue'));
Vue.component('worlduc-customcourse', require('./components/CustomCourse.vue'));
Vue.component('worlduc-video', require('./components/Video.vue'));
Vue.component('worlduc-profile', require('./components/Profile.vue'));
Vue.component('worlduc-404', require('./components/404.vue'));
Vue.component('worlduc-readme', require('./components/Readme.vue'));

// element ui
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

// vuex
import store from './store';

Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    store,
    // render: h => h(App)s
});
