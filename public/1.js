webpackJsonp([1],{

/***/ 373:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(378)
}
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(380)
/* template */
var __vue_template__ = __webpack_require__(381)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-d0d16962"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/Index-Result.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d0d16962", Component.options)
  } else {
    hotAPI.reload("data-v-d0d16962", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 378:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(379);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(1)("4059b74c", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-d0d16962\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/stylus-loader/index.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Index-Result.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-d0d16962\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/stylus-loader/index.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Index-Result.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 379:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(0)(false);
// imports


// module
exports.push([module.i, "\n@media screen and (min-width: 830px) {\n.taskDetail[data-v-d0d16962] {\n    width: 80%;\n}\n.task-left[data-v-d0d16962] {\n    margin-right: 25px;\n}\n}\n@media screen and (max-width: 830px) and (min-width: 425px) {\n.taskDetail[data-v-d0d16962] {\n    width: 80%;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.task-left[data-v-d0d16962] {\n    margin-right: 0;\n}\nh1[data-v-d0d16962] {\n    font-size: 1.5rem;\n}\n}\n@media screen and (max-width: 425px) {\n.taskDetail[data-v-d0d16962] {\n    width: 100%;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.task-left[data-v-d0d16962] {\n    margin-right: 0;\n}\nh1[data-v-d0d16962] {\n    font-size: 1.5rem;\n}\n}\n.pannel[data-v-d0d16962] {\n  background-color: #fff;\n  border: 1px solid transparent;\n  border-radius: 4px;\n  -webkit-box-shadow: 0 2px 10px rgba(0,0,0,0.05);\n          box-shadow: 0 2px 10px rgba(0,0,0,0.05);\n}\n.taskDetail[data-v-d0d16962] {\n  margin: 20px auto;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n}\n.taskDetail .task-left[data-v-d0d16962] {\n  -webkit-box-flex: 1;\n      -ms-flex: 1 0;\n          flex: 1 0;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n  padding: 0 20px;\n  margin-bottom: 20px;\n  -webkit-box-sizing: border-box;\n          box-sizing: border-box;\n}\n.taskDetail .task-left .task-info[data-v-d0d16962] {\n  color: #9b9b9b;\n  font-size: 12px;\n  font-weight: 400;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-align: center;\n      -ms-flex-align: center;\n          align-items: center;\n}\n.taskDetail .task-left .task-info .task-info-item[data-v-d0d16962] {\n  margin-right: 20px;\n}\n.taskDetail .task-left .task-info .task-info-item span[data-v-d0d16962] {\n  color: #409dfd;\n}\n.taskDetail .task-left .task-detail[data-v-d0d16962] {\n  margin: 20px 0;\n  color: #222;\n  line-height: 1.5rem;\n}\n.taskDetail .task-left .task-file[data-v-d0d16962] {\n  font-size: 13px;\n  margin-bottom: 30px;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n}\n.taskDetail .task-left .task-file i[data-v-d0d16962] {\n  margin-bottom: 15px;\n}\n.taskDetail .task-left .task-file i a[data-v-d0d16962] {\n  text-decoration: none;\n}\n", ""]);

// exports


/***/ }),

/***/ 380:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      MyAxios: axios.create({
        headers: { "Content-Type": "application/json" }
      }),
      resultData: ""
    };
  },

  methods: {
    toTask: function toTask(taksId) {
      this.$router.push({ path: "/index/task/" + taksId });
    },
    init: function init() {
      var resultId = this.$route.params.resultId;
      var that = this;
      this.MyAxios.get("/api/result/" + resultId).then(function (response) {
        that.resultData = response.data.data;
        that.resultData.file = JSON.parse(that.resultData.file);
      }).catch(function (error) {
        if (error.response.status == 404) location.href = "/404";else alert(error.response.data.errmsg);
      });
    }
  },
  // 从其他路由过来,在此进行数据的获取
  activated: function activated() {
    this.$emit("changePage", "task");
    this.init();
  }
});

/***/ }),

/***/ 381:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "taskDetail" }, [
    _c("div", { staticClass: "task-left pannel" }, [
      _c("h1", [_vm._v(_vm._s(_vm.resultData.title))]),
      _vm._v(" "),
      _c("div", { staticClass: "task-info" }, [
        _c("div", { staticClass: "task-info-item publish-date" }, [
          _vm._v(_vm._s(_vm.resultData.created_at))
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "task-info-item team-number" }, [
          _vm._v("课题:\n        "),
          _c(
            "span",
            {
              staticStyle: { cursor: "pointer" },
              on: {
                click: function($event) {
                  return _vm.toTask(_vm.resultData.task_id)
                }
              }
            },
            [_vm._v(_vm._s(_vm.resultData.task))]
          )
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "task-info-item regist-end-time" }, [
          _vm._v("研究团队:\n        "),
          _c("span", [_vm._v(_vm._s(_vm.resultData.team))])
        ])
      ]),
      _vm._v(" "),
      _c("div", {
        staticClass: "task-detail",
        domProps: { innerHTML: _vm._s(_vm.resultData.detail) }
      }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "task-file" },
        _vm._l(_vm.resultData.file, function(item, index) {
          return _c("i", { key: index, staticClass: "el-icon-document" }, [
            _vm._v("\n         \n        "),
            _c("a", { attrs: { href: "storage/" + item.download_link } }, [
              _vm._v(_vm._s(item.original_name))
            ])
          ])
        }),
        0
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-d0d16962", module.exports)
  }
}

/***/ })

});