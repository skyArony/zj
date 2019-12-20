webpackJsonp([0],{

/***/ 377:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(379)
}
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(381)
/* template */
var __vue_template__ = __webpack_require__(382)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-38edc337"
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
Component.options.__file = "resources/assets/js/components/Index-Task.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-38edc337", Component.options)
  } else {
    hotAPI.reload("data-v-38edc337", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 379:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(380);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(1)("4093b06a", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38edc337\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/stylus-loader/index.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Index-Task.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-38edc337\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/stylus-loader/index.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Index-Task.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 380:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(0)(false);
// imports


// module
exports.push([module.i, "\n@media screen and (min-width: 830px) {\n.taskDetail[data-v-38edc337] {\n    width: 80%;\n}\n.task-left[data-v-38edc337] {\n    margin-right: 25px;\n}\n}\n@media screen and (max-width: 830px) and (min-width: 425px) {\n.taskDetail[data-v-38edc337] {\n    width: 80%;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.task-left[data-v-38edc337] {\n    margin-right: 0;\n}\nh1[data-v-38edc337] {\n    font-size: 1.5rem;\n}\n}\n@media screen and (max-width: 425px) {\n.taskDetail[data-v-38edc337] {\n    width: 100%;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.task-left[data-v-38edc337] {\n    margin-right: 0;\n}\nh1[data-v-38edc337] {\n    font-size: 1.5rem;\n}\n}\n.el-icon-question[data-v-38edc337] {\n  font-size: 20px;\n  margin-left: 20px;\n}\n.pannel[data-v-38edc337] {\n  background-color: #fff;\n  border: 1px solid transparent;\n  border-radius: 4px;\n  -webkit-box-shadow: 0 2px 10px rgba(0,0,0,0.05);\n          box-shadow: 0 2px 10px rgba(0,0,0,0.05);\n}\n.taskDetail[data-v-38edc337] {\n  margin: 20px auto;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n}\n.taskDetail .task-left[data-v-38edc337] {\n  -webkit-box-flex: 3;\n      -ms-flex: 3 0;\n          flex: 3 0;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n  padding: 0 20px;\n  margin-bottom: 20px;\n  -webkit-box-sizing: border-box;\n          box-sizing: border-box;\n}\n.taskDetail .task-left .task-info[data-v-38edc337] {\n  color: #9b9b9b;\n  font-size: 12px;\n  font-weight: 400;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-align: center;\n      -ms-flex-align: center;\n          align-items: center;\n}\n.taskDetail .task-left .task-info .task-info-item[data-v-38edc337] {\n  margin-right: 20px;\n}\n.taskDetail .task-left .task-info .task-info-item span[data-v-38edc337] {\n  color: #409dfd;\n}\n.taskDetail .task-left .task-detail[data-v-38edc337] {\n  margin: 20px 0;\n  color: #222;\n  line-height: 1.5rem;\n}\n.taskDetail .task-left .task-file[data-v-38edc337] {\n  font-size: 13px;\n  margin-bottom: 30px;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n}\n.taskDetail .task-left .task-file i[data-v-38edc337] {\n  margin-bottom: 15px;\n}\n.taskDetail .task-left .task-file i a[data-v-38edc337] {\n  text-decoration: none;\n}\n.taskDetail .task-right[data-v-38edc337] {\n  -webkit-box-flex: 1;\n      -ms-flex: 1 0;\n          flex: 1 0;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n  padding: 20px;\n  margin-bottom: 20px;\n  -webkit-box-sizing: border-box;\n          box-sizing: border-box;\n  overflow: hidden;\n}\n.taskDetail .task-right .teacher-info[data-v-38edc337] {\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n}\n.taskDetail .task-right .teacher-info .teacher-img[data-v-38edc337] {\n  width: 64px;\n  height: 64px;\n  border-radius: 32px;\n  -o-object-fit: cover;\n     object-fit: cover;\n}\n.taskDetail .task-right .teacher-info .teacher-name[data-v-38edc337] {\n  margin-left: 20px;\n  margin-top: 10px;\n}\n.taskDetail .task-right .more-tasks-title[data-v-38edc337] {\n  border-bottom: 1px solid #e5e9ef;\n}\n.taskDetail .task-right .more-tasks-title h3[data-v-38edc337] {\n  margin-bottom: 10px;\n}\n.taskDetail .task-right .task-item-container[data-v-38edc337] {\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n  padding: 16px 0;\n  width: 100%;\n}\n.taskDetail .task-right .task-item-container .task-item[data-v-38edc337] {\n  width: 100%;\n  margin-bottom: 5px;\n  font-size: 14px;\n  color: #757575;\n  overflow: hidden;\n  text-overflow: ellipsis;\n  white-space: nowrap;\n}\n.taskDetail .task-right .task-item-container .task-item[data-v-38edc337]:hover {\n  color: #409dfd;\n  cursor: pointer;\n}\n", ""]);

// exports


/***/ }),

/***/ 381:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(57);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);


function _asyncToGenerator(fn) { return function () { var gen = fn.apply(this, arguments); return new Promise(function (resolve, reject) { function step(key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { return Promise.resolve(value).then(function (value) { step("next", value); }, function (err) { step("throw", err); }); } } return step("next"); }); }; }

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
      taskData: "",
      moreTask: "",
      teamData: [],
      role: ""
    };
  },

  methods: {
    toTask: function toTask(taksId) {
      this.$router.push({ path: "/index/task/" + taksId });
    },
    init: function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee(taskId) {
        var that;
        return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                // 可报名的团队-初始化
                that = this;
                _context.next = 3;
                return this.MyAxios.get("/api/user/team/").then(function (response) {
                  var teams = response.data.data;
                  for (var index in teams) {
                    that.$set(teams[index], "isSign", false);
                  }that.teamData = teams;
                }).catch(function (error) {
                  if (error.response.data.errcode != -5000) {
                    alert(error.response.data.errmsg);
                  }
                });

              case 3:
                // 获取 task 详细数据
                this.MyAxios.get("/api/task/" + taskId).then(function (response) {
                  that.taskData = response.data.data;
                  that.taskData.file = JSON.parse(that.taskData.file);
                  var teams = that.teamData;
                  for (var index in teams) {
                    if (that.taskData.signTeams.includes(teams[index].id)) that.$set(teams[index], "isSign", true);else that.$set(teams[index], "isSign", false);
                  }
                  that.teamData = teams;
                  that.MyAxios.get("/api/task/more/" + that.taskData.creater_id).then(function (response) {
                    that.moreTask = response.data.data;
                  }).catch(function (error) {
                    alert(error.response.data.errmsg);
                  });
                }).catch(function (error) {
                  if (error.response.status == 404) location.href = "/404";else alert(error.response.data.errmsg);
                });

              case 4:
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function init(_x) {
        return _ref.apply(this, arguments);
      }

      return init;
    }(),
    sign: function sign(teamId, taskId, index) {
      var that = this;
      this.MyAxios.post("/api/task/sign", {
        taskId: taskId,
        teamId: teamId
      }).then(function (response) {
        alert("报名成功,请在「申请截止」时间之前,前往后台提交开题申请!");
        that.teamData[index].isSign = true;
      }).catch(function (error) {
        alert(error.response.data.errmsg);
      });
    },
    roleDeal: function roleDeal() {
      var tokenPreg = document.cookie.match(/token=(\w+)\.(\w+)\.(\w+)/);
      if (tokenPreg) {
        var yyy = tokenPreg[2];
        var arr = JSON.parse(window.atob(yyy));
        this.role = arr.role;
      }
    }
  },
  // 同级页面的切换,在此进行数据的获取
  beforeRouteUpdate: function beforeRouteUpdate(to, from, next) {
    this.init(to.params.taskId);
    next();
  },

  // 从其他路由过来,在此进行数据的获取
  activated: function activated() {
    this.$emit("changePage", "task");
    this.taskData = "";
    this.init(this.$route.params.taskId);
    this.roleDeal();
  }
});

/***/ }),

/***/ 382:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "taskDetail" }, [
    _c("div", { staticClass: "task-left pannel" }, [
      _c("h1", [_vm._v(_vm._s(_vm.taskData.title))]),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "task-info" },
        [
          _c("div", { staticClass: "task-info-item publish-date" }, [
            _vm._v(_vm._s(_vm.taskData.created_at))
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "task-info-item team-number" }, [
            _vm._v("报名队数:\n        "),
            _c("span", [_vm._v(_vm._s(_vm.taskData.registTeams))])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "task-info-item regist-end-time" }, [
            _vm._v("距报名截止:\n        "),
            _c("span", [_vm._v(_vm._s(_vm.taskData.regist_end_at))])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "task-info-item regist-end-time" }, [
            _vm._v("距申请截止:\n        "),
            _c("span", [_vm._v(_vm._s(_vm.taskData.request_end_at))])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "task-info-item submit-end-time" }, [
            _vm._v("距课题截止:\n        "),
            _c("span", [_vm._v(_vm._s(_vm.taskData.submit_end_at))])
          ]),
          _vm._v(" "),
          _vm.role == 4
            ? _c(
                "el-popover",
                { attrs: { placement: "bottom", trigger: "hover" } },
                [
                  _c(
                    "el-table",
                    { attrs: { data: _vm.teamData, "max-height": "300" } },
                    [
                      _c("el-table-column", {
                        attrs: { prop: "title", label: "可选团队" },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "default",
                              fn: function(scope) {
                                return [
                                  _c("div", { staticClass: "surveyTitle" }, [
                                    _vm._v(_vm._s(scope.row.team_name))
                                  ])
                                ]
                              }
                            }
                          ],
                          null,
                          false,
                          3109136204
                        )
                      }),
                      _vm._v(" "),
                      _c("el-table-column", {
                        attrs: { label: "操作", width: "55" },
                        scopedSlots: _vm._u(
                          [
                            {
                              key: "default",
                              fn: function(scope) {
                                return [
                                  scope.row.isSign
                                    ? _c(
                                        "el-button",
                                        {
                                          attrs: {
                                            type: "text",
                                            size: "small",
                                            disabled: ""
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                已报名\n              "
                                          )
                                        ]
                                      )
                                    : _c(
                                        "el-button",
                                        {
                                          attrs: {
                                            type: "text",
                                            size: "small"
                                          },
                                          nativeOn: {
                                            click: function($event) {
                                              $event.preventDefault()
                                              return _vm.sign(
                                                scope.row.id,
                                                _vm.taskData.id,
                                                scope.$index
                                              )
                                            }
                                          }
                                        },
                                        [
                                          _vm._v(
                                            "\n                报名\n              "
                                          )
                                        ]
                                      )
                                ]
                              }
                            }
                          ],
                          null,
                          false,
                          3441282276
                        )
                      })
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "el-button",
                    {
                      staticClass: "button",
                      attrs: {
                        slot: "reference",
                        type: "primary",
                        size: "mini",
                        plain: ""
                      },
                      on: {
                        click: function($event) {
                          $event.stopPropagation()
                        }
                      },
                      slot: "reference"
                    },
                    [_vm._v("报名")]
                  )
                ],
                1
              )
            : _vm._e(),
          _vm._v(" "),
          _c(
            "el-tooltip",
            {
              attrs: {
                content:
                  "报名 → 提交课题申请计划书 → 教师通过申请,给予提交资格 → 提交成果",
                placement: "top"
              }
            },
            [_c("i", { staticClass: "el-icon-question" })]
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("div", {
        staticClass: "task-detail",
        domProps: { innerHTML: _vm._s(_vm.taskData.detail) }
      }),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "task-file" },
        _vm._l(_vm.taskData.file, function(item, index) {
          return _c("i", { key: index, staticClass: "el-icon-document" }, [
            _vm._v("\n         \n        "),
            _c("a", { attrs: { href: "storage/" + item.download_link } }, [
              _vm._v(_vm._s(item.original_name))
            ])
          ])
        }),
        0
      )
    ]),
    _vm._v(" "),
    _c("div", { staticClass: "task-right pannel" }, [
      _c("div", { staticClass: "teacher-info" }, [
        _c("img", {
          staticClass: "teacher-img",
          attrs: { src: _vm.taskData.creater_avatar }
        }),
        _vm._v(" "),
        _c("div", { staticClass: "teacher-name" }, [
          _vm._v(_vm._s(_vm.taskData.creater_name))
        ])
      ]),
      _vm._v(" "),
      _vm._m(0),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "task-item-container" },
        _vm._l(_vm.moreTask, function(item) {
          return _c(
            "div",
            {
              key: item.id,
              staticClass: "task-item",
              on: {
                click: function($event) {
                  return _vm.toTask(item.id)
                }
              }
            },
            [_vm._v(_vm._s(item.title))]
          )
        }),
        0
      )
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "more-tasks-title" }, [
      _c("h3", [_vm._v("更多课题")])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-38edc337", module.exports)
  }
}

/***/ })

});