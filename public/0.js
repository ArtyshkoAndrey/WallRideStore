webpackJsonp([0,4],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/mini-news.vue":
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

/* harmony default export */ __webpack_exports__["default"] = ({
  name: "mini-news",
  props: {
    news: {
      type: Object,
      required: true
    },
    active: {
      type: Boolean,
      default: false,
      required: false
    },
    index: {
      type: Number,
      required: true
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/news.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mini_news__ = __webpack_require__("./resources/js/components/mini-news.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__mini_news___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__mini_news__);
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
  name: "news",
  components: { miniNews: __WEBPACK_IMPORTED_MODULE_0__mini_news___default.a },
  props: {
    news: {
      type: Array,
      required: false,
      default: function _default() {
        return [{
          img: '../../../public/storage/images/news1.jpg',
          title: 'Новая коллекция Polar Skate Co',
          slug: 'new-collection'
        }, {
          img: '../../../public/storage/images/news2.jpg',
          title: 'Новогодние скидки в Wallride Store',
          slug: 'cristmas-sale'
        }, {
          img: '../../../public/storage/images/news1.jpg',
          title: 'Новая коллекция Polar Skate Co',
          slug: 'new-collection2'
        }];
      }
    }
  },
  data: function data() {
    return {
      item: {},
      activated: []
    };
  },
  mounted: function mounted() {
    this.adaptiveHeight();
    window.addEventListener("resize", this.adaptiveHeight);

    this.item = this.news[0];
    this.activated = new Array(this.news.length);
    this.activated.fill(false);
    this.activated[0] = true;
  },

  methods: {
    getNews: function getNews(index) {
      this.item = this.news[index];
      this.activated.fill(false);
      this.activated[index] = true;
    },
    adaptiveHeight: function adaptiveHeight() {
      var h = $('#mini-news').height();
      $('#big-news').height(h - this.rem(1));
    },
    rem: function rem(count) {
      var unit = $('html').css('font-size');

      if (typeof count !== 'undefined' && count > 0) {
        return parseInt(unit) * count;
      } else {
        return parseInt(unit);
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1a2e07c4\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/news.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.fade-enter-active[data-v-1a2e07c4], .fade-leave-active[data-v-1a2e07c4] {\n  -webkit-transition: opacity 1s;\n  transition: opacity 1s;\n}\n.fade-enter[data-v-1a2e07c4], .fade-leave-to[data-v-1a2e07c4] {\n  opacity: 0;\n}\n.info-big-news[data-v-1a2e07c4] {\n  color: white;\n  bottom: 0;\n  padding: 10px;\n  z-index: 2;\n}\n.info-big-news a[data-v-1a2e07c4] {\n    font-size: 16px;\n}\n.darkened[data-v-1a2e07c4] {\n  position: relative;\n  height: 100%;\n  border-radius: 10px;\n}\n.darkened img[data-v-1a2e07c4] {\n    min-height: 100%;\n    min-width: 100%;\n    position: relative;\n    top: 50%;\n    left: 50%;\n    -webkit-transform: translate(-50%, -50%);\n    transform: translate(-50%, -50%);\n    display: block;\n    margin: auto;\n    height: auto;\n    max-height: 100%;\n    width: auto;\n    max-width: 100%;\n    -o-object-fit: cover;\n       object-fit: cover;\n    -o-object-position: 85% 20%;\n       object-position: 85% 20%;\n    border-radius: 10px;\n}\n.darkened[data-v-1a2e07c4]::before {\n  content: '';\n  position: absolute;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  background: black;\n  background: -webkit-gradient(linear, left bottom, left top, from(rgba(0, 0, 0, 0.804359)), color-stop(50%, rgba(0, 0, 0, 0.737132)), to(rgba(0, 0, 0, 0.361782)));\n  background: linear-gradient(0deg, rgba(0, 0, 0, 0.804359) 0%, rgba(0, 0, 0, 0.737132) 50%, rgba(0, 0, 0, 0.361782) 100%);\n  z-index: 1;\n  height: 100%;\n  border-radius: 10px;\n}\n.card[data-v-1a2e07c4] {\n  height: 100%;\n  border-radius: 10px;\n  border: 0;\n}\n.card .card-body[data-v-1a2e07c4] {\n    height: 100%;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4351b44e\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/mini-news.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.darkened[data-v-4351b44e] {\n  position: relative;\n  height: 100%;\n  border-radius: 10px 0 0 10px;\n}\n.darkened[data-v-4351b44e]::before {\n  content: '';\n  position: absolute;\n  top: 0;\n  left: 0;\n  right: 0;\n  bottom: 0;\n  background-color: rgba(0, 0, 0, 0.5);\n  z-index: 1;\n  height: 100%;\n  border-radius: 10px 0 0 10px;\n}\n.card[data-v-4351b44e] {\n  border: 0;\n  -webkit-box-shadow: 0 4px 40px rgba(0, 0, 0, 0.08);\n          box-shadow: 0 4px 40px rgba(0, 0, 0, 0.08);\n  border-radius: 10px;\n  background: #ffffff;\n  color: black;\n  cursor: pointer;\n  -webkit-transition: 0.3s;\n  transition: 0.3s;\n}\n.card.active[data-v-4351b44e] {\n    background: #000000;\n    color: white;\n}\n.card img[data-v-4351b44e] {\n    min-height: 100%;\n    min-width: 100%;\n    position: relative;\n    top: 50%;\n    left: 50%;\n    -webkit-transform: translate(-50%, -50%);\n            transform: translate(-50%, -50%);\n    display: block;\n    margin: auto;\n    height: auto;\n    max-height: 100%;\n    width: auto;\n    max-width: 100%;\n    -o-object-fit: cover;\n       object-fit: cover;\n    border-radius: 10px 0 0 10px;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1a2e07c4\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/news.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c(
      "div",
      { staticClass: "col-lg-4 col-md-6 pl-sm-0", attrs: { id: "mini-news" } },
      [
        _c(
          "div",
          { staticClass: "row" },
          _vm._l(_vm.news, function(oneNews, index) {
            return _c("miniNews", {
              key: oneNews.slug,
              attrs: {
                news: oneNews,
                active: _vm.activated[index],
                index: index
              },
              on: {
                toggle: function($event) {
                  return _vm.getNews(index)
                }
              }
            })
          }),
          1
        )
      ]
    ),
    _vm._v(" "),
    _c("div", { staticClass: "col-lg-8 col-md-6", attrs: { id: "big-news" } }, [
      _c("div", { staticClass: "card mt-3" }, [
        _c("div", { staticClass: "card-body p-0" }, [
          _c(
            "div",
            { staticClass: "darkened" },
            [
              _c("transition", { attrs: { name: "fade", appear: "" } }, [
                _c("img", {
                  staticClass: "img-fluid",
                  attrs: { src: _vm.item.img, alt: "" }
                })
              ])
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "div",
            { staticClass: "position-absolute info-big-news" },
            [
              _c("transition-group", { attrs: { name: "fade", appear: "" } }, [
                _c("h2", { key: "1" }, [_vm._v(_vm._s(_vm.item.title))]),
                _vm._v(" "),
                _c(
                  "a",
                  { key: "2", staticClass: "c-red", attrs: { href: "#" } },
                  [
                    _vm._v("Подробнее "),
                    _c("img", {
                      attrs: {
                        src: "/../../img/arrow-long-right-red.png",
                        width: "100",
                        alt: ""
                      }
                    })
                  ]
                )
              ])
            ],
            1
          )
        ])
      ])
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1a2e07c4", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4351b44e\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/mini-news.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "col-12 mt-3" }, [
    _c(
      "div",
      {
        class: _vm.active ? "card active" : "card",
        on: {
          click: function($event) {
            return _vm.$emit("toggle", _vm.index)
          }
        }
      },
      [
        _c("div", { staticClass: "card-body p-0" }, [
          _c("div", { staticClass: "row" }, [
            _c("div", { staticClass: "col-5" }, [
              _c("div", { staticClass: "darkened" }, [
                _c("img", {
                  staticClass: "img-fluid",
                  attrs: { src: _vm.news.img, alt: "" }
                })
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-7 py-4" }, [
              _c("h5", [_vm._v(_vm._s(_vm.news.title))])
            ])
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4351b44e", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1a2e07c4\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/news.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1a2e07c4\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/news.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("7d6964e7", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1a2e07c4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./news.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1a2e07c4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./news.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4351b44e\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/mini-news.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4351b44e\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/mini-news.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("29a731ee", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4351b44e\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./mini-news.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4351b44e\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./mini-news.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/js/components/mini-news.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4351b44e\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/mini-news.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/mini-news.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-4351b44e\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/mini-news.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-4351b44e"
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
Component.options.__file = "resources/js/components/mini-news.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4351b44e", Component.options)
  } else {
    hotAPI.reload("data-v-4351b44e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/components/news.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1a2e07c4\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/news.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/news.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1a2e07c4\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/news.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-1a2e07c4"
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
Component.options.__file = "resources/js/components/news.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1a2e07c4", Component.options)
  } else {
    hotAPI.reload("data-v-1a2e07c4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});