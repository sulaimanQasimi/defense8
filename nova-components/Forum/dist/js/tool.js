/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Category.vue?vue&type=script&lang=js":
/*!*********************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Category.vue?vue&type=script&lang=js ***!
  \*********************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _mixins__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../mixins */ "./resources/js/mixins/index.js");

/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  mixins: [_mixins__WEBPACK_IMPORTED_MODULE_0__.VistitCategory, _mixins__WEBPACK_IMPORTED_MODULE_0__.PanelControl, _mixins__WEBPACK_IMPORTED_MODULE_0__.ThreadAction],
  props: {
    request: null
  },
  data: function data() {
    return {
      category: null,
      threads: null
    };
  },
  created: function created() {
    this.initialize();
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Thread.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Thread.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  props: {
    request: Object
  },
  data: function data() {
    return {};
  },
  mounted: function mounted() {
    Nova.request().get("/forum/api/thread/".concat(this.request.id)).then(function (_ref) {
      var data = _ref.data.data;
      console.log(data);
    })["catch"](function (e) {});
    Nova.request().get("/forum/api/thread/".concat(this.request.id, "/posts")).then(function (_ref2) {
      var data = _ref2.data.data;
      console.log(data);
    })["catch"](function (e) {});
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=script&lang=js":
/*!*****************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=script&lang=js ***!
  \*****************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _mixins_HandleCategory__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../mixins/HandleCategory */ "./resources/js/mixins/HandleCategory.js");
/* harmony import */ var _mixins_PanelControl__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../mixins/PanelControl */ "./resources/js/mixins/PanelControl.js");


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  mixins: [_mixins_HandleCategory__WEBPACK_IMPORTED_MODULE_0__["default"], _mixins_PanelControl__WEBPACK_IMPORTED_MODULE_1__["default"]],
  props: {},
  data: function data() {
    return {
      categories: [],
      title: null,
      description: null
    };
  },
  mounted: function mounted() {},
  created: function created() {
    this.intialize();
  },
  methods: {}
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Category.vue?vue&type=template&id=9507cef2":
/*!*************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Category.vue?vue&type=template&id=9507cef2 ***!
  \*************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }

var _hoisted_1 = {
  "class": "bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden p-8"
};
var _hoisted_2 = {
  key: 0,
  "class": "mt-2"
};
var _hoisted_3 = {
  "class": "flex items-center ml-auto"
};
var _hoisted_4 = {
  "class": "flex gap-2 mb-6"
};
var _hoisted_5 = {
  key: 0
};
var _hoisted_6 = {
  "class": "text-center"
};
var _hoisted_7 = {
  "class": "text-center"
};
var _hoisted_8 = {
  "class": "w-full divide-y divide-gray-100 dark:divide-gray-700",
  dusk: "resource-table"
};
var _hoisted_9 = {
  "class": "bg-gray-50 dark:bg-gray-800"
};
var _hoisted_10 = ["textContent"];
var _hoisted_11 = ["textContent"];
var _hoisted_12 = ["textContent"];
var _hoisted_13 = ["textContent"];
var _hoisted_14 = ["textContent"];
var _hoisted_15 = ["textContent"];
var _hoisted_16 = {
  "class": "cursor-pointer px-2 w-[1%] white-space-nowrap text-right align-middle dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
};
var _hoisted_17 = {
  "class": "flex items-center justify-end space-x-0 text-gray-400"
};
var _hoisted_18 = ["href"];
var _hoisted_19 = ["onClick"];
var _hoisted_20 = {
  "class": "flex items-center gap-1"
};
var _hoisted_21 = ["onClick"];
var _hoisted_22 = {
  "class": "flex items-center gap-1"
};
var _hoisted_23 = ["onClick"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ModalHeader = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalHeader");
  var _component_FormLabel = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("FormLabel");
  var _component_ModalContent = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalContent");
  var _component_CancelButton = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("CancelButton");
  var _component_Button = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Button");
  var _component_ModalFooter = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalFooter");
  var _component_Modal = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Modal");
  var _component_LoadingView = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("LoadingView");
  var _component_Card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Card");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Modal, {
    show: _ctx.show
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalHeader, {
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__(!_ctx.editable ? 'Create Thread' : 'Edit Thread'))
      }, null, 8 /* PROPS */, ["textContent"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalContent, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_FormLabel, {
            "class": "space-x-1"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__("Title")), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
            "class": "w-full form-control form-input form-control-bordered",
            "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
              return _ctx.title = $event;
            })
          }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.title]])]), !_ctx.editable ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_FormLabel, {
            "class": "space-x-1"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__("Remark")), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
            rows: "1",
            "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
              return _ctx.description = $event;
            }),
            type: "text",
            "class": "font-mono text-xs resize-none block w-full px-3 py-3 dark:text-gray-400 bg-clip-border focus:outline-none focus:ring focus:ring-inset",
            style: {
              "background-clip": "border-box"
            }
          }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, _ctx.description]])])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true)];
        }),
        _: 1 /* STABLE */
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalFooter, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_CancelButton, {
            component: "button",
            type: "button",
            dusk: "cancel-action-button",
            "class": "ml-auto mr-3",
            onClick: _cache[2] || (_cache[2] = function ($event) {
              return _ctx.close();
            })
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__("Cancel")), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Button, {
            type: "button",
            ref: "runButton",
            dusk: "confirm-action-button",
            loading: true,
            variant: "solid",
            state: 'default',
            onClick: _cache[3] || (_cache[3] = function ($event) {
              return !_ctx.editable ? _ctx.createResource() : _ctx.updateResource();
            })
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__(!_ctx.editable ? "Create" : "Edit")), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }, 512 /* NEED_PATCH */)])];
        }),
        _: 1 /* STABLE */
      })])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["show"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "bg-yellow-300 dark:bg-gray-900 shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold",
    onClick: _cache[4] || (_cache[4] = function ($event) {
      return _ctx.open();
    })
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__(!_ctx.editable ? "Create" : "Edit")), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_LoadingView, {
        loading: _ctx.loading
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [$data.category ? ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("div", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("h1", _hoisted_6, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.category.title), 1 /* TEXT */), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("p", _hoisted_7, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)($data.category.description), 1 /* TEXT */)])) : (0,vue__WEBPACK_IMPORTED_MODULE_0__.createCommentVNode)("v-if", true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_8, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", _hoisted_9, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
            textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Title')),
            "class": "header border border-gray-200"
          }, null, 8 /* PROPS */, _hoisted_10), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
            textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('User')),
            "class": "header border border-gray-200"
          }, null, 8 /* PROPS */, _hoisted_11), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
            textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Reply')),
            "class": "header border border-gray-200"
          }, null, 8 /* PROPS */, _hoisted_12)]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.threads, function (thread, index) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
              "class": "header border border-gray-200",
              textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(thread.title)
            }, null, 8 /* PROPS */, _hoisted_13), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
              "class": "header border border-gray-200",
              textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(thread.author_name)
            }, null, 8 /* PROPS */, _hoisted_14), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
              "class": "header border border-gray-200",
              textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(thread.reply_count)
            }, null, 8 /* PROPS */, _hoisted_15), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
              dusk: "448-view-button",
              "class": "inline-flex items-center justify-center h-9 w-9 hover:text-primary-500 dark:hover:text-primary-500 v-popper--has-tooltip",
              disabled: "false",
              href: "/forum/category?id=".concat(thread.id)
            }, _toConsumableArray(_cache[6] || (_cache[6] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "flex items-center gap-1"
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "fas fa-eye"
            })], -1 /* HOISTED */)])), 8 /* PROPS */, _hoisted_18), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
              "aria-label": "ویرایش",
              dusk: "448-edit-button",
              "class": "inline-flex items-center justify-center h-9 w-9 hover:text-primary-500 dark:hover:text-primary-500 v-popper--has-tooltip",
              disabled: "false",
              onClick: function onClick($event) {
                return _ctx.editResource(thread.id);
              }
            }, _toConsumableArray(_cache[7] || (_cache[7] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "flex items-center gap-1"
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "fas fa-marker"
            })], -1 /* HOISTED */)])), 8 /* PROPS */, _hoisted_19), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
              type: "button",
              "class": "border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip",
              onClick: _cache[5] || (_cache[5] = function ($event) {
                return _ctx["private"]($data.category);
              })
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_20, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
                'fas fa-user-lock text-green-300': thread.is_private,
                'fas fa-users': !thread.is_private
              })
            }, null, 2 /* CLASS */)])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
              type: "button",
              "class": "border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip",
              onClick: function onClick($event) {
                return thread.locked ? _ctx.unlock(thread.id) : _ctx.lock(thread.id);
              }
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_22, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
                'fas fa-lock-open': !thread.locked,
                'fas fa-lock text-green-300': thread.locked
              })
            }, null, 2 /* CLASS */)])], 8 /* PROPS */, _hoisted_21), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
              type: "button",
              "class": "border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip",
              onClick: function onClick($event) {
                return _ctx.deleteResource(thread.id);
              }
            }, _toConsumableArray(_cache[8] || (_cache[8] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "flex items-center gap-1"
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "fas fa-trash-can"
            })], -1 /* HOISTED */)])), 8 /* PROPS */, _hoisted_23)])])]);
          }), 256 /* UNKEYED_FRAGMENT */))])])];
        }),
        _: 1 /* STABLE */
      }, 8 /* PROPS */, ["loading"])];
    }),
    _: 1 /* STABLE */
  })], 64 /* STABLE_FRAGMENT */);
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Thread.vue?vue&type=template&id=561a4bd3":
/*!***********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Thread.vue?vue&type=template&id=561a4bd3 ***!
  \***********************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
function render(_ctx, _cache, $props, $setup, $data, $options) {
  return null;
}

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe":
/*!*********************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe ***!
  \*********************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* binding */ render)
/* harmony export */ });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "vue");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }

var _hoisted_1 = {
  "class": "bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden p-8"
};
var _hoisted_2 = {
  "class": "mt-2"
};
var _hoisted_3 = {
  "class": "flex items-center ml-auto"
};
var _hoisted_4 = {
  "class": "flex gap-2 mb-6"
};
var _hoisted_5 = {
  "class": "w-full divide-y divide-gray-100 dark:divide-gray-700",
  dusk: "resource-table"
};
var _hoisted_6 = {
  "class": "bg-gray-50 dark:bg-gray-800"
};
var _hoisted_7 = ["textContent"];
var _hoisted_8 = ["textContent"];
var _hoisted_9 = ["textContent"];
var _hoisted_10 = ["textContent"];
var _hoisted_11 = ["textContent"];
var _hoisted_12 = ["textContent"];
var _hoisted_13 = ["textContent"];
var _hoisted_14 = ["textContent"];
var _hoisted_15 = ["textContent"];
var _hoisted_16 = {
  "class": "cursor-pointer px-2 w-[1%] white-space-nowrap text-right align-middle dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
};
var _hoisted_17 = {
  "class": "flex items-center justify-end space-x-0 text-gray-400"
};
var _hoisted_18 = ["href"];
var _hoisted_19 = ["onClick"];
var _hoisted_20 = ["onClick"];
var _hoisted_21 = {
  "class": "flex items-center gap-1"
};
var _hoisted_22 = ["onClick"];
var _hoisted_23 = {
  "class": "flex items-center gap-1"
};
var _hoisted_24 = ["onClick"];
function render(_ctx, _cache, $props, $setup, $data, $options) {
  var _component_ModalHeader = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalHeader");
  var _component_FormLabel = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("FormLabel");
  var _component_ModalContent = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalContent");
  var _component_CancelButton = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("CancelButton");
  var _component_Button = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Button");
  var _component_ModalFooter = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("ModalFooter");
  var _component_Modal = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Modal");
  var _component_LoadingView = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("LoadingView");
  var _component_Card = (0,vue__WEBPACK_IMPORTED_MODULE_0__.resolveComponent)("Card");
  return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Modal, {
    show: _ctx.show
  }, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_1, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalHeader, {
        textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__(!_ctx.editable ? 'Create Category' : 'Edit Category'))
      }, null, 8 /* PROPS */, ["textContent"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalContent, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_FormLabel, {
            "class": "space-x-1"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__("Title")), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("input", {
            "class": "w-full form-control form-input form-control-bordered",
            "onUpdate:modelValue": _cache[0] || (_cache[0] = function ($event) {
              return $data.title = $event;
            })
          }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.title]])]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_2, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_FormLabel, {
            "class": "space-x-1"
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__("Remark")), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.withDirectives)((0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("textarea", {
            rows: "1",
            "onUpdate:modelValue": _cache[1] || (_cache[1] = function ($event) {
              return $data.description = $event;
            }),
            type: "text",
            "class": "font-mono text-xs resize-none block w-full px-3 py-3 dark:text-gray-400 bg-clip-border focus:outline-none focus:ring focus:ring-inset",
            style: {
              "background-clip": "border-box"
            }
          }, null, 512 /* NEED_PATCH */), [[vue__WEBPACK_IMPORTED_MODULE_0__.vModelText, $data.description]])])];
        }),
        _: 1 /* STABLE */
      }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_ModalFooter, null, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_3, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_CancelButton, {
            component: "button",
            type: "button",
            dusk: "cancel-action-button",
            "class": "ml-auto mr-3",
            onClick: _cache[2] || (_cache[2] = function ($event) {
              return _ctx.close();
            })
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__("Cancel")), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Button, {
            type: "button",
            ref: "runButton",
            dusk: "confirm-action-button",
            loading: true,
            variant: "solid",
            state: 'default',
            onClick: _cache[3] || (_cache[3] = function ($event) {
              return !_ctx.editable ? _ctx.createCategory() : _ctx.updateCategory();
            })
          }, {
            "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
              return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createTextVNode)((0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__(!_ctx.editable ? "Create" : "Edit")), 1 /* TEXT */)];
            }),
            _: 1 /* STABLE */
          }, 512 /* NEED_PATCH */)])];
        }),
        _: 1 /* STABLE */
      })])];
    }),
    _: 1 /* STABLE */
  }, 8 /* PROPS */, ["show"]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_4, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
    type: "button",
    "class": "bg-yellow-300 dark:bg-gray-900 shrink-0 h-9 px-4 focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring text-white dark:text-gray-800 inline-flex items-center font-bold",
    onClick: _cache[4] || (_cache[4] = function ($event) {
      return _ctx.open();
    })
  }, (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__(!_ctx.editable ? "Create" : "Edit")), 1 /* TEXT */)]), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_Card, null, {
    "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
      return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createVNode)(_component_LoadingView, {
        loading: _ctx.loading
      }, {
        "default": (0,vue__WEBPACK_IMPORTED_MODULE_0__.withCtx)(function () {
          return [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("table", _hoisted_5, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("thead", _hoisted_6, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
            textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Title')),
            "class": "header border border-gray-200"
          }, null, 8 /* PROPS */, _hoisted_7), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
            textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Description')),
            "class": "header border border-gray-200"
          }, null, 8 /* PROPS */, _hoisted_8), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
            textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Category')),
            "class": "header border border-gray-200"
          }, null, 8 /* PROPS */, _hoisted_9), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
            textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Post')),
            "class": "header border border-gray-200"
          }, null, 8 /* PROPS */, _hoisted_10), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
            textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(_ctx.__('Thread')),
            "class": "header border border-gray-200"
          }, null, 8 /* PROPS */, _hoisted_11), _cache[5] || (_cache[5] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("th", null, null, -1 /* HOISTED */))]), ((0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(true), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)(vue__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,vue__WEBPACK_IMPORTED_MODULE_0__.renderList)($data.categories, function (category, index) {
            return (0,vue__WEBPACK_IMPORTED_MODULE_0__.openBlock)(), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementBlock)("tr", null, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
              "class": "header border border-gray-200",
              textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(category.title)
            }, null, 8 /* PROPS */, _hoisted_12), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
              "class": "header border border-gray-200",
              textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(category.description)
            }, null, 8 /* PROPS */, _hoisted_13), _cache[9] || (_cache[9] = (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
              "class": "header border border-gray-200",
              textContent: ''
            }, null, -1 /* HOISTED */)), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
              "class": "header border border-gray-200",
              textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(category.post_count)
            }, null, 8 /* PROPS */, _hoisted_14), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", {
              "class": "header border border-gray-200",
              textContent: (0,vue__WEBPACK_IMPORTED_MODULE_0__.toDisplayString)(category.thread_count)
            }, null, 8 /* PROPS */, _hoisted_15), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("td", _hoisted_16, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("div", _hoisted_17, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
              dusk: "448-view-button",
              "class": "inline-flex items-center justify-center h-9 w-9 hover:text-primary-500 dark:hover:text-primary-500 v-popper--has-tooltip",
              disabled: "false",
              href: "/forum/category?id=".concat(category.id)
            }, _toConsumableArray(_cache[6] || (_cache[6] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "flex items-center gap-1"
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "fas fa-eye"
            })], -1 /* HOISTED */)])), 8 /* PROPS */, _hoisted_18), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("a", {
              "aria-label": "ویرایش",
              dusk: "448-edit-button",
              "class": "inline-flex items-center justify-center h-9 w-9 hover:text-primary-500 dark:hover:text-primary-500 v-popper--has-tooltip",
              disabled: "false",
              onClick: function onClick($event) {
                return _ctx.editCategory(category.id);
              }
            }, _toConsumableArray(_cache[7] || (_cache[7] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "flex items-center gap-1"
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "fas fa-marker"
            })], -1 /* HOISTED */)])), 8 /* PROPS */, _hoisted_19), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
              type: "button",
              "class": "border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip",
              onClick: function onClick($event) {
                return _ctx["private"](category);
              }
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_21, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
                'fas fa-user-lock text-green-300': category.is_private,
                'fas fa-users': !category.is_private
              })
            }, null, 2 /* CLASS */)])], 8 /* PROPS */, _hoisted_20), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
              type: "button",
              "class": "border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip",
              onClick: function onClick($event) {
                return _ctx.openChat(category);
              }
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", _hoisted_23, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": (0,vue__WEBPACK_IMPORTED_MODULE_0__.normalizeClass)({
                'fas fa-lock text-green-300': !category.accepts_threads,
                'fas fa-lock-open': category.accepts_threads
              })
            }, null, 2 /* CLASS */)])], 8 /* PROPS */, _hoisted_22), (0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("button", {
              type: "button",
              "class": "border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center bg-transparent border-transparent text-gray-500 dark:text-gray-400 hover:[&:not(:disabled)]:text-primary-500 h-9 w-9 v-popper--has-tooltip",
              onClick: function onClick($event) {
                return _ctx.deleteCategory(category.id);
              }
            }, _toConsumableArray(_cache[8] || (_cache[8] = [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "flex items-center gap-1"
            }, [(0,vue__WEBPACK_IMPORTED_MODULE_0__.createElementVNode)("span", {
              "class": "fas fa-trash-can"
            })], -1 /* HOISTED */)])), 8 /* PROPS */, _hoisted_24)])])]);
          }), 256 /* UNKEYED_FRAGMENT */))])])];
        }),
        _: 1 /* STABLE */
      }, 8 /* PROPS */, ["loading"])];
    }),
    _: 1 /* STABLE */
  })], 64 /* STABLE_FRAGMENT */);
}

/***/ }),

/***/ "./resources/js/mixins/HandleCategory.js":
/*!***********************************************!*\
  !*** ./resources/js/mixins/HandleCategory.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      loading: false
    };
  },
  methods: {
    editCategory: function editCategory(id) {
      var _this = this;
      this.editId = id;
      this.loading = true;
      Nova.request().get("forum/api/category/".concat(id)).then(function (_ref) {
        var data = _ref.data.data;
        _this.intialize();
        _this.title = data.title;
        _this.description = data.description;
        _this.show = true;
        _this.editable = true;
        _this.loading = false;
      })["catch"](function (e) {
        console.log(e);
      });
    },
    updateCategory: function updateCategory() {
      var _this2 = this;
      this.loading = true;
      Nova.request().patch("/forum/api/category/".concat(this.editId), {
        title: this.title,
        description: this.description
      }).then(function (_ref2) {
        var data = _ref2.data.data;
        _this2.intialize();
        _this2.title = null;
        _this2.description = null;
        _this2.show = false;
        _this2.editable = false;
        _this2.editId = id;
        _this2.loading = false;
      })["catch"](function (e) {
        console.log(e);
      });
    },
    deleteCategory: function deleteCategory(id) {
      var _this3 = this;
      this.loading = true;
      Nova.request()["delete"]("/forum/api/category/".concat(id), {
        force: false
      }).then(function (_ref3) {
        var data = _ref3.data.data;
        _this3.intialize();
        _this3.loading = false;
      })["catch"](function (e) {
        console.log(e);
      });
    },
    createCategory: function createCategory() {
      var _this4 = this;
      this.loading = true;
      Nova.request().post("/forum/api/category", {
        title: this.title,
        description: this.description
      }).then(function (_ref4) {
        var data = _ref4.data.data;
        _this4.intialize();
        _this4.title = null;
        _this4.description = null;
        _this4.show = false;
        _this4.loading = false;
      })["catch"](function (e) {
        console.log(e);
      });
    },
    intialize: function intialize() {
      var _this5 = this;
      this.loading = true;
      Nova.request().get("/forum/api/category").then(function (_ref5) {
        var data = _ref5.data.data;
        _this5.categories = data;
        _this5.loading = false;
      })["catch"](function (e) {});
    },
    openChat: function openChat(category) {
      var _this6 = this;
      this.loading = true;
      Nova.request().patch("/forum/api/category/".concat(category.id), {
        title: category.title,
        description: category.description,
        accepts_threads: !category.accepts_threads
      }).then(function (_ref6) {
        var data = _ref6.data.data;
        _this6.intialize();
        _this6.loading = false;
      })["catch"](function (e) {
        console.log(e);
      });
    },
    "private": function _private(category) {
      var _this7 = this;
      this.loading = true;
      Nova.request().patch("/forum/api/category/".concat(category.id), {
        title: category.title,
        description: category.description,
        is_private: !category.is_private
      }).then(function (_ref7) {
        var data = _ref7.data.data;
        _this7.intialize();
        _this7.loading = false;
      })["catch"](function (e) {
        console.log(e);
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/mixins/PanelControl.js":
/*!*********************************************!*\
  !*** ./resources/js/mixins/PanelControl.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      show: false,
      editId: null,
      editable: false
    };
  },
  methods: {
    close: function close() {
      this.show = false;
    },
    open: function open() {
      this.show = true;
    }
  }
});

/***/ }),

/***/ "./resources/js/mixins/ThreadAction.js":
/*!*********************************************!*\
  !*** ./resources/js/mixins/ThreadAction.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  methods: {
    pin: function pin(id) {
      Nova.request().post("/forum/api/thread/".concat(id, "/pin"));
      this.initialize();
    },
    unpin: function unpin(id) {
      Nova.request().post("/forum/api/thread/".concat(id, "/pin"));
      this.initialize();
    },
    lock: function lock(id) {
      Nova.request().post("/forum/api/thread/".concat(id, "/pin"));
      this.initialize();
    },
    unlock: function unlock(id) {
      Nova.request().post("/forum/api/thread/".concat(id, "/pin"));
      this.initialize();
    }
  }
});

/***/ }),

/***/ "./resources/js/mixins/VistitCategory.js":
/*!***********************************************!*\
  !*** ./resources/js/mixins/VistitCategory.js ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      loading: false,
      categoryId: null,
      categories: [],
      title: null,
      description: null
    };
  },
  methods: {
    initialize: function initialize() {
      var _this = this;
      Nova.request().get("/forum/api/category/".concat(this.request.id)).then(function (_ref) {
        var data = _ref.data.data;
        _this.category = data;
      })["catch"](function (e) {});
      Nova.request().get("/forum/api/category/".concat(this.request.id, "/thread")).then(function (_ref2) {
        var data = _ref2.data.data;
        _this.threads = data;
      })["catch"](function (e) {});
    },
    createResource: function createResource() {
      var _this2 = this;
      Nova.request().post("/forum/api/category/".concat(this.request.id, "/thread"), {
        title: this.title,
        content: this.description
      }).then(function (_ref3) {
        var data = _ref3.data;
        _this2.initialize();
        _this2.title = null;
        _this2.description = null;
        _this2.show = false;
        _this2.loading = false;
      })["catch"](function (e) {});
    },
    editResource: function editResource(id) {
      var _this3 = this;
      this.editId = id;
      this.loading = true;
      Nova.request().get("/forum/api/thread/".concat(id)).then(function (_ref4) {
        var data = _ref4.data.data;
        _this3.initialize();
        _this3.title = data.title;
        _this3.description = data.content;
        _this3.show = true;
        _this3.editable = true;
        _this3.loading = false;
      })["catch"](function (e) {
        console.log(e);
      });
    },
    updateResource: function updateResource() {
      var _this4 = this;
      this.loading = true;
      Nova.request().post("/forum/api/thread/".concat(this.editId, "/rename"), {
        title: this.title
      }).then(function (_ref5) {
        var data = _ref5.data.data;
        _this4.initialize();
        _this4.title = null;
        _this4.description = null;
        _this4.show = false;
        _this4.editable = false;
        _this4.loading = false;
      })["catch"](function (e) {
        console.log(e);
      });
    },
    deleteResource: function deleteResource(id) {
      var _this5 = this;
      this.loading = true;
      Nova.request()["delete"]("/forum/api/thread/".concat(id), {
        force: false
      }).then(function (_ref6) {
        var data = _ref6.data.data;
        _this5.initialize();
        _this5.loading = false;
      })["catch"](function (e) {
        console.log(e);
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/mixins/index.js":
/*!**************************************!*\
  !*** ./resources/js/mixins/index.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   PanelControl: () => (/* reexport safe */ _PanelControl__WEBPACK_IMPORTED_MODULE_1__["default"]),
/* harmony export */   ThreadAction: () => (/* reexport safe */ _ThreadAction__WEBPACK_IMPORTED_MODULE_2__["default"]),
/* harmony export */   VistitCategory: () => (/* reexport safe */ _VistitCategory__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _VistitCategory__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./VistitCategory */ "./resources/js/mixins/VistitCategory.js");
/* harmony import */ var _PanelControl__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./PanelControl */ "./resources/js/mixins/PanelControl.js");
/* harmony import */ var _ThreadAction__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ThreadAction */ "./resources/js/mixins/ThreadAction.js");




/***/ }),

/***/ "./resources/js/tool.js":
/*!******************************!*\
  !*** ./resources/js/tool.js ***!
  \******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _pages_Tool__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./pages/Tool */ "./resources/js/pages/Tool.vue");
/* harmony import */ var _pages_Category__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./pages/Category */ "./resources/js/pages/Category.vue");
/* harmony import */ var _pages_Thread__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./pages/Thread */ "./resources/js/pages/Thread.vue");



Nova.booting(function (app, store) {
  Nova.inertia('Forum', _pages_Tool__WEBPACK_IMPORTED_MODULE_0__["default"]);
  Nova.inertia('Category', _pages_Category__WEBPACK_IMPORTED_MODULE_1__["default"]);
  Nova.inertia('Thread', _pages_Thread__WEBPACK_IMPORTED_MODULE_2__["default"]);
});

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css":
/*!******************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css ***!
  \******************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../node_modules/css-loader/dist/runtime/api.js */ "./node_modules/css-loader/dist/runtime/api.js");
/* harmony import */ var _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0__);
// Imports

var ___CSS_LOADER_EXPORT___ = _node_modules_css_loader_dist_runtime_api_js__WEBPACK_IMPORTED_MODULE_0___default()(function(i){return i[1]});
// Module
___CSS_LOADER_EXPORT___.push([module.id, "\n/* Scoped Styles */\n", ""]);
// Exports
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (___CSS_LOADER_EXPORT___);


/***/ }),

/***/ "./node_modules/css-loader/dist/runtime/api.js":
/*!*****************************************************!*\
  !*** ./node_modules/css-loader/dist/runtime/api.js ***!
  \*****************************************************/
/***/ ((module) => {



/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
// eslint-disable-next-line func-names
module.exports = function (cssWithMappingToString) {
  var list = []; // return the list of modules as css string

  list.toString = function toString() {
    return this.map(function (item) {
      var content = cssWithMappingToString(item);

      if (item[2]) {
        return "@media ".concat(item[2], " {").concat(content, "}");
      }

      return content;
    }).join("");
  }; // import a list of modules into the list
  // eslint-disable-next-line func-names


  list.i = function (modules, mediaQuery, dedupe) {
    if (typeof modules === "string") {
      // eslint-disable-next-line no-param-reassign
      modules = [[null, modules, ""]];
    }

    var alreadyImportedModules = {};

    if (dedupe) {
      for (var i = 0; i < this.length; i++) {
        // eslint-disable-next-line prefer-destructuring
        var id = this[i][0];

        if (id != null) {
          alreadyImportedModules[id] = true;
        }
      }
    }

    for (var _i = 0; _i < modules.length; _i++) {
      var item = [].concat(modules[_i]);

      if (dedupe && alreadyImportedModules[item[0]]) {
        // eslint-disable-next-line no-continue
        continue;
      }

      if (mediaQuery) {
        if (!item[2]) {
          item[2] = mediaQuery;
        } else {
          item[2] = "".concat(mediaQuery, " and ").concat(item[2]);
        }
      }

      list.push(item);
    }
  };

  return list;
};

/***/ }),

/***/ "./resources/css/tool.css":
/*!********************************!*\
  !*** ./resources/css/tool.css ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css":
/*!**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css ***!
  \**********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! !../../../node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js */ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js");
/* harmony import */ var _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_lang_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! !!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css */ "./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css");

            

var options = {};

options.insert = "head";
options.singleton = false;

var update = _node_modules_style_loader_dist_runtime_injectStylesIntoStyleTag_js__WEBPACK_IMPORTED_MODULE_0___default()(_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"], options);



/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_lang_css__WEBPACK_IMPORTED_MODULE_1__["default"].locals || {});

/***/ }),

/***/ "./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js":
/*!****************************************************************************!*\
  !*** ./node_modules/style-loader/dist/runtime/injectStylesIntoStyleTag.js ***!
  \****************************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {



var isOldIE = function isOldIE() {
  var memo;
  return function memorize() {
    if (typeof memo === 'undefined') {
      // Test for IE <= 9 as proposed by Browserhacks
      // @see http://browserhacks.com/#hack-e71d8692f65334173fee715c222cb805
      // Tests for existence of standard globals is to allow style-loader
      // to operate correctly into non-standard environments
      // @see https://github.com/webpack-contrib/style-loader/issues/177
      memo = Boolean(window && document && document.all && !window.atob);
    }

    return memo;
  };
}();

var getTarget = function getTarget() {
  var memo = {};
  return function memorize(target) {
    if (typeof memo[target] === 'undefined') {
      var styleTarget = document.querySelector(target); // Special case to return head of iframe instead of iframe itself

      if (window.HTMLIFrameElement && styleTarget instanceof window.HTMLIFrameElement) {
        try {
          // This will throw an exception if access to iframe is blocked
          // due to cross-origin restrictions
          styleTarget = styleTarget.contentDocument.head;
        } catch (e) {
          // istanbul ignore next
          styleTarget = null;
        }
      }

      memo[target] = styleTarget;
    }

    return memo[target];
  };
}();

var stylesInDom = [];

function getIndexByIdentifier(identifier) {
  var result = -1;

  for (var i = 0; i < stylesInDom.length; i++) {
    if (stylesInDom[i].identifier === identifier) {
      result = i;
      break;
    }
  }

  return result;
}

function modulesToDom(list, options) {
  var idCountMap = {};
  var identifiers = [];

  for (var i = 0; i < list.length; i++) {
    var item = list[i];
    var id = options.base ? item[0] + options.base : item[0];
    var count = idCountMap[id] || 0;
    var identifier = "".concat(id, " ").concat(count);
    idCountMap[id] = count + 1;
    var index = getIndexByIdentifier(identifier);
    var obj = {
      css: item[1],
      media: item[2],
      sourceMap: item[3]
    };

    if (index !== -1) {
      stylesInDom[index].references++;
      stylesInDom[index].updater(obj);
    } else {
      stylesInDom.push({
        identifier: identifier,
        updater: addStyle(obj, options),
        references: 1
      });
    }

    identifiers.push(identifier);
  }

  return identifiers;
}

function insertStyleElement(options) {
  var style = document.createElement('style');
  var attributes = options.attributes || {};

  if (typeof attributes.nonce === 'undefined') {
    var nonce =  true ? __webpack_require__.nc : 0;

    if (nonce) {
      attributes.nonce = nonce;
    }
  }

  Object.keys(attributes).forEach(function (key) {
    style.setAttribute(key, attributes[key]);
  });

  if (typeof options.insert === 'function') {
    options.insert(style);
  } else {
    var target = getTarget(options.insert || 'head');

    if (!target) {
      throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");
    }

    target.appendChild(style);
  }

  return style;
}

function removeStyleElement(style) {
  // istanbul ignore if
  if (style.parentNode === null) {
    return false;
  }

  style.parentNode.removeChild(style);
}
/* istanbul ignore next  */


var replaceText = function replaceText() {
  var textStore = [];
  return function replace(index, replacement) {
    textStore[index] = replacement;
    return textStore.filter(Boolean).join('\n');
  };
}();

function applyToSingletonTag(style, index, remove, obj) {
  var css = remove ? '' : obj.media ? "@media ".concat(obj.media, " {").concat(obj.css, "}") : obj.css; // For old IE

  /* istanbul ignore if  */

  if (style.styleSheet) {
    style.styleSheet.cssText = replaceText(index, css);
  } else {
    var cssNode = document.createTextNode(css);
    var childNodes = style.childNodes;

    if (childNodes[index]) {
      style.removeChild(childNodes[index]);
    }

    if (childNodes.length) {
      style.insertBefore(cssNode, childNodes[index]);
    } else {
      style.appendChild(cssNode);
    }
  }
}

function applyToTag(style, options, obj) {
  var css = obj.css;
  var media = obj.media;
  var sourceMap = obj.sourceMap;

  if (media) {
    style.setAttribute('media', media);
  } else {
    style.removeAttribute('media');
  }

  if (sourceMap && typeof btoa !== 'undefined') {
    css += "\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))), " */");
  } // For old IE

  /* istanbul ignore if  */


  if (style.styleSheet) {
    style.styleSheet.cssText = css;
  } else {
    while (style.firstChild) {
      style.removeChild(style.firstChild);
    }

    style.appendChild(document.createTextNode(css));
  }
}

var singleton = null;
var singletonCounter = 0;

function addStyle(obj, options) {
  var style;
  var update;
  var remove;

  if (options.singleton) {
    var styleIndex = singletonCounter++;
    style = singleton || (singleton = insertStyleElement(options));
    update = applyToSingletonTag.bind(null, style, styleIndex, false);
    remove = applyToSingletonTag.bind(null, style, styleIndex, true);
  } else {
    style = insertStyleElement(options);
    update = applyToTag.bind(null, style, options);

    remove = function remove() {
      removeStyleElement(style);
    };
  }

  update(obj);
  return function updateStyle(newObj) {
    if (newObj) {
      if (newObj.css === obj.css && newObj.media === obj.media && newObj.sourceMap === obj.sourceMap) {
        return;
      }

      update(obj = newObj);
    } else {
      remove();
    }
  };
}

module.exports = function (list, options) {
  options = options || {}; // Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
  // tags it will allow on a page

  if (!options.singleton && typeof options.singleton !== 'boolean') {
    options.singleton = isOldIE();
  }

  list = list || [];
  var lastIdentifiers = modulesToDom(list, options);
  return function update(newList) {
    newList = newList || [];

    if (Object.prototype.toString.call(newList) !== '[object Array]') {
      return;
    }

    for (var i = 0; i < lastIdentifiers.length; i++) {
      var identifier = lastIdentifiers[i];
      var index = getIndexByIdentifier(identifier);
      stylesInDom[index].references--;
    }

    var newLastIdentifiers = modulesToDom(newList, options);

    for (var _i = 0; _i < lastIdentifiers.length; _i++) {
      var _identifier = lastIdentifiers[_i];

      var _index = getIndexByIdentifier(_identifier);

      if (stylesInDom[_index].references === 0) {
        stylesInDom[_index].updater();

        stylesInDom.splice(_index, 1);
      }
    }

    lastIdentifiers = newLastIdentifiers;
  };
};

/***/ }),

/***/ "./node_modules/vue-loader/dist/exportHelper.js":
/*!******************************************************!*\
  !*** ./node_modules/vue-loader/dist/exportHelper.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, exports) => {


Object.defineProperty(exports, "__esModule", ({ value: true }));
// runtime helper for setting properties on components
// in a tree-shakable way
exports["default"] = (sfc, props) => {
    const target = sfc.__vccOpts || sfc;
    for (const [key, val] of props) {
        target[key] = val;
    }
    return target;
};


/***/ }),

/***/ "./resources/js/pages/Category.vue":
/*!*****************************************!*\
  !*** ./resources/js/pages/Category.vue ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Category_vue_vue_type_template_id_9507cef2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Category.vue?vue&type=template&id=9507cef2 */ "./resources/js/pages/Category.vue?vue&type=template&id=9507cef2");
/* harmony import */ var _Category_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Category.vue?vue&type=script&lang=js */ "./resources/js/pages/Category.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp_htdocs_defense6_nova_components_Forum_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_defense6_nova_components_Forum_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Category_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Category_vue_vue_type_template_id_9507cef2__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/pages/Category.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/pages/Thread.vue":
/*!***************************************!*\
  !*** ./resources/js/pages/Thread.vue ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Thread_vue_vue_type_template_id_561a4bd3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Thread.vue?vue&type=template&id=561a4bd3 */ "./resources/js/pages/Thread.vue?vue&type=template&id=561a4bd3");
/* harmony import */ var _Thread_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Thread.vue?vue&type=script&lang=js */ "./resources/js/pages/Thread.vue?vue&type=script&lang=js");
/* harmony import */ var C_xampp_htdocs_defense6_nova_components_Forum_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;
const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_defense6_nova_components_Forum_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__["default"])(_Thread_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Thread_vue_vue_type_template_id_561a4bd3__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/pages/Thread.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/pages/Tool.vue":
/*!*************************************!*\
  !*** ./resources/js/pages/Tool.vue ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _Tool_vue_vue_type_template_id_ef10eebe__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Tool.vue?vue&type=template&id=ef10eebe */ "./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe");
/* harmony import */ var _Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Tool.vue?vue&type=script&lang=js */ "./resources/js/pages/Tool.vue?vue&type=script&lang=js");
/* harmony import */ var _Tool_vue_vue_type_style_index_0_id_ef10eebe_lang_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css */ "./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css");
/* harmony import */ var C_xampp_htdocs_defense6_nova_components_Forum_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/vue-loader/dist/exportHelper.js */ "./node_modules/vue-loader/dist/exportHelper.js");




;


const __exports__ = /*#__PURE__*/(0,C_xampp_htdocs_defense6_nova_components_Forum_node_modules_vue_loader_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_3__["default"])(_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__["default"], [['render',_Tool_vue_vue_type_template_id_ef10eebe__WEBPACK_IMPORTED_MODULE_0__.render],['__file',"resources/js/pages/Tool.vue"]])
/* hot reload */
if (false) {}


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (__exports__);

/***/ }),

/***/ "./resources/js/pages/Category.vue?vue&type=script&lang=js":
/*!*****************************************************************!*\
  !*** ./resources/js/pages/Category.vue?vue&type=script&lang=js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Category_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Category_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Category.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Category.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/pages/Thread.vue?vue&type=script&lang=js":
/*!***************************************************************!*\
  !*** ./resources/js/pages/Thread.vue?vue&type=script&lang=js ***!
  \***************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Thread_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Thread_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Thread.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Thread.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/pages/Tool.vue?vue&type=script&lang=js":
/*!*************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=script&lang=js ***!
  \*************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__["default"])
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=script&lang=js */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=script&lang=js");
 

/***/ }),

/***/ "./resources/js/pages/Category.vue?vue&type=template&id=9507cef2":
/*!***********************************************************************!*\
  !*** ./resources/js/pages/Category.vue?vue&type=template&id=9507cef2 ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Category_vue_vue_type_template_id_9507cef2__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Category_vue_vue_type_template_id_9507cef2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Category.vue?vue&type=template&id=9507cef2 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Category.vue?vue&type=template&id=9507cef2");


/***/ }),

/***/ "./resources/js/pages/Thread.vue?vue&type=template&id=561a4bd3":
/*!*********************************************************************!*\
  !*** ./resources/js/pages/Thread.vue?vue&type=template&id=561a4bd3 ***!
  \*********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Thread_vue_vue_type_template_id_561a4bd3__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Thread_vue_vue_type_template_id_561a4bd3__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Thread.vue?vue&type=template&id=561a4bd3 */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Thread.vue?vue&type=template&id=561a4bd3");


/***/ }),

/***/ "./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe":
/*!*******************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   render: () => (/* reexport safe */ _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_template_id_ef10eebe__WEBPACK_IMPORTED_MODULE_0__.render)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_use_0_node_modules_vue_loader_dist_templateLoader_js_ruleSet_1_rules_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_template_id_ef10eebe__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!../../../node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=template&id=ef10eebe */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5.use[0]!./node_modules/vue-loader/dist/templateLoader.js??ruleSet[1].rules[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=template&id=ef10eebe");


/***/ }),

/***/ "./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css":
/*!*********************************************************************************!*\
  !*** ./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css ***!
  \*********************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_dist_cjs_js_node_modules_css_loader_dist_cjs_js_clonedRuleSet_9_use_1_node_modules_vue_loader_dist_stylePostLoader_js_node_modules_postcss_loader_dist_cjs_js_clonedRuleSet_9_use_2_node_modules_vue_loader_dist_index_js_ruleSet_0_use_0_Tool_vue_vue_type_style_index_0_id_ef10eebe_lang_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/style-loader/dist/cjs.js!../../../node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!../../../node_modules/vue-loader/dist/stylePostLoader.js!../../../node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!../../../node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css */ "./node_modules/style-loader/dist/cjs.js!./node_modules/css-loader/dist/cjs.js??clonedRuleSet-9.use[1]!./node_modules/vue-loader/dist/stylePostLoader.js!./node_modules/postcss-loader/dist/cjs.js??clonedRuleSet-9.use[2]!./node_modules/vue-loader/dist/index.js??ruleSet[0].use[0]!./resources/js/pages/Tool.vue?vue&type=style&index=0&id=ef10eebe&lang=css");


/***/ }),

/***/ "vue":
/*!**********************!*\
  !*** external "Vue" ***!
  \**********************/
/***/ ((module) => {

module.exports = Vue;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			id: moduleId,
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/tool": 0,
/******/ 			"css/tool": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkacme_forum"] = self["webpackChunkacme_forum"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/nonce */
/******/ 	(() => {
/******/ 		__webpack_require__.nc = undefined;
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/tool"], () => (__webpack_require__("./resources/js/tool.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/tool"], () => (__webpack_require__("./resources/css/tool.css")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;