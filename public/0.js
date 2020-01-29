webpackJsonp([0,2],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/product-list.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_flickity__ = __webpack_require__("./node_modules/vue-flickity/src/flickity.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_vue_flickity___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_vue_flickity__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__product__ = __webpack_require__("./resources/js/components/product.vue");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__product___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__product__);
//



/* harmony default export */ __webpack_exports__["default"] = ({
  name: "product-list",
  components: { Flickity: __WEBPACK_IMPORTED_MODULE_0_vue_flickity___default.a, product: __WEBPACK_IMPORTED_MODULE_1__product___default.a },
  data: function data() {
    return {
      flickityOptions: {
        initialIndex: 3,
        prevNextButtons: false,
        pageDots: false,
        freeScroll: true,
        adaptiveHeight: true,
        percentPosition: false,
        imagesLoaded: true,
        lazyLoad: 10
      }
    };
  },

  methods: {
    next: function next() {
      this.$refs.flickity.next();
    },
    previous: function previous() {
      this.$refs.flickity.previous();
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/product.vue":
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
  name: "product",
  props: {
    currency: {
      required: true
    },
    slider: {
      type: Boolean,
      required: false,
      default: false
    },
    item: {
      type: Object,
      required: false,
      default: false
    }
  },
  data: function data() {
    return {
      count: 0,
      numberSize: 0
    };
  },
  mounted: function mounted() {
    console.log(this.item);
  },

  methods: {
    addCounter: function addCounter() {
      this.item.skus[this.numberSize].stock > this.count ? this.count++ : null;
    },
    removeCounter: function removeCounter() {
      this.count > 0 ? this.count-- : null;
    },
    addNumberSize: function addNumberSize() {
      if (this.numberSize < this.item.skus.length - 1) {
        this.numberSize++;
        this.count = 0;
      }
    },
    removeNumberSize: function removeNumberSize() {
      if (this.numberSize > 0) {
        this.numberSize--;
        this.count = 0;
      }
    },
    addToCart: function addToCart() {
      // if (this.count > 0 && false === false)
      //   this.item.inCart = !this.item.inCart;
      // else if(this.item.inCart === false) {
      //   swal({
      //     title: "Выберите количество больше нуля",
      //     text: "Данное колличество невозможно купить",
      //     icon: "warning",
      //     dangerMode: true,
      //   })
      // } else {
      //   this.item.inCart = !this.item.inCart;
      // }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1b2b3ef4\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/product.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\nbutton[data-v-1b2b3ef4]:focus {\n  outline: none !important;\n  -webkit-box-shadow: none !important;\n          box-shadow: none !important;\n}\n.carousel-cell[data-v-1b2b3ef4] {\n  padding-top: 10px;\n  padding-bottom: 10px;\n  width: 65%;\n  height: auto;\n  margin-left: 10px;\n  margin-right: 10px;\n}\n@media (min-width: 768px) {\n.carousel-cell[data-v-1b2b3ef4] {\n    width: 25%;\n}\n}\n@media (min-width: 992px) {\n.carousel-cell[data-v-1b2b3ef4] {\n    width: 16.66666667%;\n}\n}\n@media (min-width: 1200px) {\n.carousel-cell[data-v-1b2b3ef4] {\n    width: 13%;\n}\n}\n.go-to-product[data-v-1b2b3ef4] {\n  cursor: pointer;\n}\n.card[data-v-1b2b3ef4] {\n  border: 0;\n  background: #FFFFFF;\n  -webkit-box-shadow: 0 4px 5px rgba(0, 0, 0, 0.09);\n          box-shadow: 0 4px 5px rgba(0, 0, 0, 0.09);\n  border-radius: 15px;\n}\n.card .card-body #event[data-v-1b2b3ef4] {\n    background-color: #F33C3C;\n    -webkit-box-shadow: 0 4px 20px rgba(247, 7, 7, 0.43);\n            box-shadow: 0 4px 20px rgba(247, 7, 7, 0.43);\n    border-radius: 32px;\n    left: -15px;\n}\n.card .card-body #event span[data-v-1b2b3ef4] {\n      font-size: 18px;\n      line-height: 35px;\n}\n.card .card-body > div[data-v-1b2b3ef4] {\n    padding: 0 23px;\n}\n.card .card-body [type=\"number\"][data-v-1b2b3ef4] {\n    font-size: 14px;\n}\n.card .card-body #btn-add-to-cart[data-v-1b2b3ef4] {\n    background: #000;\n    color: white;\n    border-radius: 0 15px 0 15px;\n}\n.card .card-body #btn-add-to-cart[data-v-1b2b3ef4]:focus {\n      outline: 0 !important;\n}\n.card .card-body #btn-add-to-cart[data-v-1b2b3ef4]:active {\n      outline: 0 !important;\n}\n.card .card-body #btn-remove-in-cart[data-v-1b2b3ef4] {\n    background: #04B900;\n    color: white;\n    border-radius: 0 15px 0 15px;\n}\n.card .card-body #btn-remove-in-cart[data-v-1b2b3ef4]:focus {\n      outline: 0 !important;\n}\n.card .card-body #btn-remove-in-cart[data-v-1b2b3ef4]:active {\n      outline: 0 !important;\n}\n.card .card-body .btn-angle[data-v-1b2b3ef4] {\n    background-color: white;\n    color: #F33C3C;\n    height: 15px;\n    display: block;\n    border: none !important;\n    outline: none !important;\n}\n.card .card-body .btn-angle > i[data-v-1b2b3ef4] {\n      font-size: 16px;\n      font-weight: bold;\n}\n.card .card-body .btn-angle[data-v-1b2b3ef4]:hover {\n      color: black;\n}\n.card .card-body .btn-angle[data-v-1b2b3ef4]:focus, .card .card-body .btn-angle[data-v-1b2b3ef4]::-moz-focus-inner, .card .card-body .btn-angle[data-v-1b2b3ef4]:active {\n      outline: none !important;\n      border: 0 !important;\n      box-shadow: none !important;\n      -moz-outline-style: none !important;\n      outline: 0 !important;\n}\n.card a.name[data-v-1b2b3ef4] {\n    font-size: 16px;\n    line-height: 24px;\n    color: black;\n    text-decoration: none;\n}\n.card a.name[data-v-1b2b3ef4]:hover {\n      color: #F33C3C;\n}\n.card p.price[data-v-1b2b3ef4] {\n    font-weight: bold;\n    font-size: 24px;\n    line-height: 35px;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-d5e796f2\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/product-list.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1b2b3ef4\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/product.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    {
      class: _vm.slider
        ? "carousel-cell"
        : "col-md-4 col-lg-3 col-sm-6 col-10 offset-1 offset-sm-0 my-3"
    },
    [
      _c("div", { staticClass: "card" }, [
        _c("div", { staticClass: "card-body px-0 pb-0" }, [
          _c("div", [
            _vm.item.on_new || _vm.item.om_sale
              ? _c(
                  "div",
                  {
                    staticClass: "position-absolute px-4 py-1",
                    attrs: { id: "event" }
                  },
                  [
                    _vm.item.on_new
                      ? _c(
                          "span",
                          {
                            staticClass:
                              "text-uppercase font-weight-bold text-white"
                          },
                          [_vm._v("new")]
                        )
                      : _vm.item.om_sale
                      ? _c(
                          "span",
                          {
                            staticClass:
                              "text-uppercase font-weight-bold text-white"
                          },
                          [_vm._v("sale")]
                        )
                      : _vm._e()
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.slider
              ? _c("img", {
                  staticClass: "img-fluid w-100 mb-3 rounded",
                  attrs: {
                    "data-flickity-lazyload": _vm.item.image_url,
                    alt: "item.image"
                  }
                })
              : _c("img", {
                  staticClass: "img-fluid w-100 mb-3 rounded",
                  attrs: { src: _vm.item.image_url, alt: "item.image" }
                }),
            _vm._v(" "),
            _c(
              "a",
              { staticClass: "mt-4 pb-0 mb-0 name", attrs: { href: "#" } },
              [_vm._v(_vm._s(_vm.item.title))]
            ),
            _vm._v(" "),
            _c("p", { staticClass: "price mt-1 pt-0" }, [
              _vm._v(
                _vm._s(
                  Math.round(
                    _vm.item.skus[_vm.numberSize].price * _vm.currency.ratio
                  )
                ) +
                  " " +
                  _vm._s(_vm.currency.symbol)
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row px-0 mx-0" }, [
            _c("div", { staticClass: "col-4 px-0" }, [
              true
                ? _c(
                    "button",
                    {
                      staticClass: "btn w-100",
                      attrs: { id: "btn-add-to-cart" },
                      on: {
                        click: function($event) {
                          return _vm.addToCart()
                        }
                      }
                    },
                    [_c("i", { staticClass: "fal fa-shopping-bag" })]
                  )
                : _c(
                    "button",
                    {
                      staticClass: "btn w-100",
                      attrs: { id: "btn-remove-in-cart" },
                      on: {
                        click: function($event) {
                          return _vm.addToCart()
                        }
                      }
                    },
                    [_c("i", { staticClass: "fal fa-check" })]
                  )
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-4 px-0" }, [
              _c("div", { staticClass: "row m-0" }, [
                _c("div", { staticClass: "col-8 m-0 p-0" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.count,
                        expression: "count"
                      }
                    ],
                    staticClass:
                      "form-control w-100 bg-white border-0 pr-0 font-weight-bolder text-center",
                    attrs: { type: "number", readonly: "", disabled: "" },
                    domProps: { value: _vm.count },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.count = $event.target.value
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-4 px-0" }, [
                  _c("div", { staticClass: "row p-0 m-0" }, [
                    _c("div", { staticClass: "col-12 p-0 h-100 w-100" }, [
                      _c(
                        "button",
                        {
                          directives: [
                            {
                              name: "long-press",
                              rawName: "v-long-press",
                              value: _vm.addCounter,
                              expression: "addCounter"
                            }
                          ],
                          staticClass: "btn p-0 m-0 btn-angle",
                          on: { click: _vm.addCounter }
                        },
                        [_c("i", { staticClass: "fal fa-angle-up" })]
                      )
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "col-12 p-0 h-100 w-100" }, [
                      _c(
                        "button",
                        {
                          directives: [
                            {
                              name: "long-press",
                              rawName: "v-long-press",
                              value: _vm.removeCounter,
                              expression: "removeCounter"
                            }
                          ],
                          staticClass: "btn p-0 m-0 btn-angle",
                          on: { click: _vm.removeCounter }
                        },
                        [_c("i", { staticClass: "fal fa-angle-down" })]
                      )
                    ])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "col-4 pr-0 pl-1" }, [
              _c("div", { staticClass: "row m-0" }, [
                _c("div", { staticClass: "col-2 pl-0 pr-1" }, [
                  _c(
                    "button",
                    {
                      directives: [
                        {
                          name: "long-press",
                          rawName: "v-long-press",
                          value: _vm.addNumberSize,
                          expression: "addNumberSize"
                        }
                      ],
                      staticClass: "btn p-0 m-0 bg-transparent btn-angle h-100",
                      on: { click: _vm.addNumberSize }
                    },
                    [_c("i", { staticClass: "fal fa-angle-left mt-1" })]
                  )
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-6 m-0 pl-1 pr-0" }, [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.item.skus[_vm.numberSize].title,
                        expression: "item.skus[numberSize].title"
                      }
                    ],
                    staticClass:
                      "form-control w-100 bg-white border-0 px-0 font-weight-bolder text-center",
                    attrs: { type: "text", readonly: "", disabled: "" },
                    domProps: { value: _vm.item.skus[_vm.numberSize].title },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.item.skus[_vm.numberSize],
                          "title",
                          $event.target.value
                        )
                      }
                    }
                  })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col-2 px-0" }, [
                  _c(
                    "button",
                    {
                      directives: [
                        {
                          name: "long-press",
                          rawName: "v-long-press",
                          value: _vm.removeNumberSize,
                          expression: "removeNumberSize"
                        }
                      ],
                      staticClass: "btn p-0 m-0 bg-transparent btn-angle h-100",
                      on: { click: _vm.removeNumberSize }
                    },
                    [_c("i", { staticClass: "fal fa-angle-right mt-1" })]
                  )
                ])
              ])
            ])
          ])
        ])
      ])
    ]
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1b2b3ef4", module.exports)
  }
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1b2b3ef4\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/product.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1b2b3ef4\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/product.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("1fda5f57", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1b2b3ef4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./product.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1b2b3ef4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../node_modules/sass-loader/lib/loader.js!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./product.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-d5e796f2\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/product-list.vue":
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__("./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-d5e796f2\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/product-list.vue");
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__("./node_modules/vue-style-loader/lib/addStylesClient.js")("557b3956", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-d5e796f2\",\"scoped\":false,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./product-list.vue", function() {
     var newContent = require("!!../../../node_modules/css-loader/index.js!../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-d5e796f2\",\"scoped\":false,\"hasInlineConfig\":true}!../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./product-list.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ "./resources/js/components/product-list.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-d5e796f2\",\"scoped\":false,\"hasInlineConfig\":true}!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/product-list.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/product-list.vue")
/* template */
var __vue_template__ = null
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = null
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
Component.options.__file = "resources/js/components/product-list.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d5e796f2", Component.options)
  } else {
    hotAPI.reload("data-v-d5e796f2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ "./resources/js/components/product.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__("./node_modules/vue-style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1b2b3ef4\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/product.vue")
}
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/product.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1b2b3ef4\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/product.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-1b2b3ef4"
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
Component.options.__file = "resources/js/components/product.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1b2b3ef4", Component.options)
  } else {
    hotAPI.reload("data-v-1b2b3ef4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});