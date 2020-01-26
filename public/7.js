webpackJsonp([7],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/js/components/product.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash__ = __webpack_require__("./node_modules/lodash/lodash.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_lodash___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_lodash__);
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
    slider: {
      type: Boolean,
      required: false,
      default: false
    },
    item: {
      type: Object,
      required: false,
      default: function _default() {
        return {
          name: 'Fucking Awesome – Angel 2 Hoodie Hunter',
          img: "../../../public/storage/inventory/t.png",
          size: [{
            name: 'L',
            count: 3,
            price: 40031,
            pr: localStorage.currency === 'usd' ? 40031 / 377.320 : localStorage.currency === 'ru' ? 40031 / 6 : 40031
          }, {
            name: 'M',
            count: 10,
            price: 40101,
            pr: localStorage.currency === 'usd' ? 40101 / 377.320 : localStorage.currency === 'ru' ? 40101 / 6 : 40101
          }, {
            name: 'XXL',
            count: 0,
            price: 40001,
            pr: localStorage.currency === 'usd' ? 40001 / 377.320 : localStorage.currency === 'ru' ? 40001 / 6 : 40001
          }],
          inCart: __WEBPACK_IMPORTED_MODULE_0_lodash___default.a.sample([true, false]),
          inFavourite: __WEBPACK_IMPORTED_MODULE_0_lodash___default.a.sample([true, false]),
          inSale: __WEBPACK_IMPORTED_MODULE_0_lodash___default.a.sample([true, false]),
          inNew: __WEBPACK_IMPORTED_MODULE_0_lodash___default.a.sample([true, false])
        };
      }
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

  computed: {
    currency: function currency() {
      return localStorage.currency === 'usd' ? '$' : localStorage.currency === 'ru' ? 'р.' : 'тг.';
    }
  },
  methods: {
    addCounter: function addCounter() {
      this.item.size[this.numberSize].count > this.count ? this.count++ : null;
    },
    removeCounter: function removeCounter() {
      this.count > 0 ? this.count-- : null;
    },
    addNumberSize: function addNumberSize() {
      if (this.numberSize < this.item.size.length - 1) {
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
      if (this.count > 0 && this.item.inCart === false) this.item.inCart = !this.item.inCart;else if (this.item.inCart === false) {
        swal({
          title: "Выберите количество больше нуля",
          text: "Данное колличество невозможно купить",
          icon: "warning",
          dangerMode: true
        });
      } else {
        this.item.inCart = !this.item.inCart;
      }
    }
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1b2b3ef4\",\"scoped\":true,\"hasInlineConfig\":true}!./node_modules/sass-loader/lib/loader.js!./node_modules/vue-loader/lib/selector.js?type=styles&index=0!./resources/js/components/product.vue":
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__("./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\nbutton[data-v-1b2b3ef4]:focus {\n  outline: none !important;\n  -webkit-box-shadow: none !important;\n          box-shadow: none !important;\n}\n.carousel-cell[data-v-1b2b3ef4] {\n  padding-top: 10px;\n  padding-bottom: 10px;\n  width: 65%;\n  height: auto;\n  margin-left: 10px;\n  margin-right: 10px;\n}\n@media (min-width: 768px) {\n.carousel-cell[data-v-1b2b3ef4] {\n    width: 25%;\n}\n}\n@media (min-width: 992px) {\n.carousel-cell[data-v-1b2b3ef4] {\n    width: 16.66666667%;\n}\n}\n.go-to-product[data-v-1b2b3ef4] {\n  cursor: pointer;\n}\n.card[data-v-1b2b3ef4] {\n  border: 0;\n  background: #FFFFFF;\n  -webkit-box-shadow: 0 4px 5px rgba(0, 0, 0, 0.09);\n          box-shadow: 0 4px 5px rgba(0, 0, 0, 0.09);\n  border-radius: 15px;\n}\n.card .card-body #event[data-v-1b2b3ef4] {\n    background-color: #F33C3C;\n    -webkit-box-shadow: 0 4px 20px rgba(247, 7, 7, 0.43);\n            box-shadow: 0 4px 20px rgba(247, 7, 7, 0.43);\n    border-radius: 32px;\n    left: -15px;\n}\n.card .card-body #event span[data-v-1b2b3ef4] {\n      font-size: 18px;\n      line-height: 35px;\n}\n.card .card-body > div[data-v-1b2b3ef4] {\n    padding: 0 23px;\n}\n.card .card-body [type=\"number\"][data-v-1b2b3ef4] {\n    font-size: 14px;\n}\n.card .card-body #btn-add-to-cart[data-v-1b2b3ef4] {\n    background: #000;\n    color: white;\n    border-radius: 0 15px 0 15px;\n}\n.card .card-body #btn-add-to-cart[data-v-1b2b3ef4]:focus {\n      outline: 0 !important;\n}\n.card .card-body #btn-add-to-cart[data-v-1b2b3ef4]:active {\n      outline: 0 !important;\n}\n.card .card-body #btn-remove-in-cart[data-v-1b2b3ef4] {\n    background: #04B900;\n    color: white;\n    border-radius: 0 15px 0 15px;\n}\n.card .card-body #btn-remove-in-cart[data-v-1b2b3ef4]:focus {\n      outline: 0 !important;\n}\n.card .card-body #btn-remove-in-cart[data-v-1b2b3ef4]:active {\n      outline: 0 !important;\n}\n.card .card-body .btn-angle[data-v-1b2b3ef4] {\n    background-color: white;\n    color: #F33C3C;\n    height: 15px;\n    display: block;\n    border: none !important;\n    outline: none !important;\n}\n.card .card-body .btn-angle > i[data-v-1b2b3ef4] {\n      font-size: 16px;\n      font-weight: bold;\n}\n.card .card-body .btn-angle[data-v-1b2b3ef4]:hover {\n      color: black;\n}\n.card .card-body .btn-angle[data-v-1b2b3ef4]:focus, .card .card-body .btn-angle[data-v-1b2b3ef4]::-moz-focus-inner, .card .card-body .btn-angle[data-v-1b2b3ef4]:active {\n      outline: none !important;\n      border: 0 !important;\n      box-shadow: none !important;\n      -moz-outline-style: none !important;\n      outline: 0 !important;\n}\n.card a.name[data-v-1b2b3ef4] {\n    font-size: 16px;\n    line-height: 24px;\n    color: black;\n    text-decoration: none;\n}\n.card a.name[data-v-1b2b3ef4]:hover {\n      color: #F33C3C;\n}\n.card p.price[data-v-1b2b3ef4] {\n    font-weight: bold;\n    font-size: 24px;\n    line-height: 35px;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/css-loader/lib/css-base.js":
/***/ (function(module, exports) {

/*
	MIT License http://www.opensource.org/licenses/mit-license.php
	Author Tobias Koppers @sokra
*/
// css base code, injected by the css-loader
module.exports = function(useSourceMap) {
	var list = [];

	// return the list of modules as css string
	list.toString = function toString() {
		return this.map(function (item) {
			var content = cssWithMappingToString(item, useSourceMap);
			if(item[2]) {
				return "@media " + item[2] + "{" + content + "}";
			} else {
				return content;
			}
		}).join("");
	};

	// import a list of modules into the list
	list.i = function(modules, mediaQuery) {
		if(typeof modules === "string")
			modules = [[null, modules, ""]];
		var alreadyImportedModules = {};
		for(var i = 0; i < this.length; i++) {
			var id = this[i][0];
			if(typeof id === "number")
				alreadyImportedModules[id] = true;
		}
		for(i = 0; i < modules.length; i++) {
			var item = modules[i];
			// skip already imported module
			// this implementation is not 100% perfect for weird media query combinations
			//  when a module is imported multiple times with different media queries.
			//  I hope this will never occur (Hey this way we have smaller bundles)
			if(typeof item[0] !== "number" || !alreadyImportedModules[item[0]]) {
				if(mediaQuery && !item[2]) {
					item[2] = mediaQuery;
				} else if(mediaQuery) {
					item[2] = "(" + item[2] + ") and (" + mediaQuery + ")";
				}
				list.push(item);
			}
		}
	};
	return list;
};

function cssWithMappingToString(item, useSourceMap) {
	var content = item[1] || '';
	var cssMapping = item[3];
	if (!cssMapping) {
		return content;
	}

	if (useSourceMap && typeof btoa === 'function') {
		var sourceMapping = toComment(cssMapping);
		var sourceURLs = cssMapping.sources.map(function (source) {
			return '/*# sourceURL=' + cssMapping.sourceRoot + source + ' */'
		});

		return [content].concat(sourceURLs).concat([sourceMapping]).join('\n');
	}

	return [content].join('\n');
}

// Adapted from convert-source-map (MIT)
function toComment(sourceMap) {
	// eslint-disable-next-line no-undef
	var base64 = btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap))));
	var data = 'sourceMappingURL=data:application/json;charset=utf-8;base64,' + base64;

	return '/*# ' + data + ' */';
}


/***/ }),

/***/ "./node_modules/vue-loader/lib/component-normalizer.js":
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-1b2b3ef4\",\"hasScoped\":true,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/js/components/product.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { class: _vm.slider ? "carousel-cell" : "col-md-3 col-lg-2 col-6" },
    [
      _c("div", { staticClass: "card" }, [
        _c("div", { staticClass: "card-body px-0 pb-0" }, [
          _c("div", [
            _vm.item.inNew || _vm.item.inSale
              ? _c(
                  "div",
                  {
                    staticClass: "position-absolute px-4 py-1",
                    attrs: { id: "event" }
                  },
                  [
                    _vm.item.inNew
                      ? _c(
                          "span",
                          {
                            staticClass:
                              "text-uppercase font-weight-bold text-white"
                          },
                          [_vm._v("new")]
                        )
                      : _vm.item.inSale
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
            _c("img", {
              staticClass: "img-fluid w-100",
              attrs: {
                "data-flickity-lazyload": _vm.item.img,
                alt: "item.name"
              }
            }),
            _vm._v(" "),
            _c(
              "a",
              { staticClass: "mt-2 pb-0 mb-0 name", attrs: { href: "#" } },
              [_vm._v(_vm._s(_vm.item.name))]
            ),
            _vm._v(" "),
            _c("p", { staticClass: "price mt-1 pt-0" }, [
              _vm._v(
                _vm._s(_vm.item.size[_vm.numberSize].pr) +
                  " 1 " +
                  _vm._s(_vm.currency)
              )
            ])
          ]),
          _vm._v(" "),
          _c("div", { staticClass: "row px-0 mx-0" }, [
            _c("div", { staticClass: "col-4 px-0" }, [
              !_vm.item.inCart
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
                    attrs: {
                      type: "number",
                      value: "1",
                      readonly: "",
                      disabled: ""
                    },
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
                        value: _vm.item.size[_vm.numberSize].name,
                        expression: "item.size[numberSize].name"
                      }
                    ],
                    staticClass:
                      "form-control w-100 bg-white border-0 px-0 font-weight-bolder text-center",
                    attrs: { type: "text", readonly: "", disabled: "" },
                    domProps: { value: _vm.item.size[_vm.numberSize].name },
                    on: {
                      input: function($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.item.size[_vm.numberSize],
                          "name",
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

/***/ "./node_modules/vue-style-loader/lib/addStylesClient.js":
/***/ (function(module, exports, __webpack_require__) {

/*
  MIT License http://www.opensource.org/licenses/mit-license.php
  Author Tobias Koppers @sokra
  Modified by Evan You @yyx990803
*/

var hasDocument = typeof document !== 'undefined'

if (typeof DEBUG !== 'undefined' && DEBUG) {
  if (!hasDocument) {
    throw new Error(
    'vue-style-loader cannot be used in a non-browser environment. ' +
    "Use { target: 'node' } in your Webpack config to indicate a server-rendering environment."
  ) }
}

var listToStyles = __webpack_require__("./node_modules/vue-style-loader/lib/listToStyles.js")

/*
type StyleObject = {
  id: number;
  parts: Array<StyleObjectPart>
}

type StyleObjectPart = {
  css: string;
  media: string;
  sourceMap: ?string
}
*/

var stylesInDom = {/*
  [id: number]: {
    id: number,
    refs: number,
    parts: Array<(obj?: StyleObjectPart) => void>
  }
*/}

var head = hasDocument && (document.head || document.getElementsByTagName('head')[0])
var singletonElement = null
var singletonCounter = 0
var isProduction = false
var noop = function () {}
var options = null
var ssrIdKey = 'data-vue-ssr-id'

// Force single-tag solution on IE6-9, which has a hard limit on the # of <style>
// tags it will allow on a page
var isOldIE = typeof navigator !== 'undefined' && /msie [6-9]\b/.test(navigator.userAgent.toLowerCase())

module.exports = function (parentId, list, _isProduction, _options) {
  isProduction = _isProduction

  options = _options || {}

  var styles = listToStyles(parentId, list)
  addStylesToDom(styles)

  return function update (newList) {
    var mayRemove = []
    for (var i = 0; i < styles.length; i++) {
      var item = styles[i]
      var domStyle = stylesInDom[item.id]
      domStyle.refs--
      mayRemove.push(domStyle)
    }
    if (newList) {
      styles = listToStyles(parentId, newList)
      addStylesToDom(styles)
    } else {
      styles = []
    }
    for (var i = 0; i < mayRemove.length; i++) {
      var domStyle = mayRemove[i]
      if (domStyle.refs === 0) {
        for (var j = 0; j < domStyle.parts.length; j++) {
          domStyle.parts[j]()
        }
        delete stylesInDom[domStyle.id]
      }
    }
  }
}

function addStylesToDom (styles /* Array<StyleObject> */) {
  for (var i = 0; i < styles.length; i++) {
    var item = styles[i]
    var domStyle = stylesInDom[item.id]
    if (domStyle) {
      domStyle.refs++
      for (var j = 0; j < domStyle.parts.length; j++) {
        domStyle.parts[j](item.parts[j])
      }
      for (; j < item.parts.length; j++) {
        domStyle.parts.push(addStyle(item.parts[j]))
      }
      if (domStyle.parts.length > item.parts.length) {
        domStyle.parts.length = item.parts.length
      }
    } else {
      var parts = []
      for (var j = 0; j < item.parts.length; j++) {
        parts.push(addStyle(item.parts[j]))
      }
      stylesInDom[item.id] = { id: item.id, refs: 1, parts: parts }
    }
  }
}

function createStyleElement () {
  var styleElement = document.createElement('style')
  styleElement.type = 'text/css'
  head.appendChild(styleElement)
  return styleElement
}

function addStyle (obj /* StyleObjectPart */) {
  var update, remove
  var styleElement = document.querySelector('style[' + ssrIdKey + '~="' + obj.id + '"]')

  if (styleElement) {
    if (isProduction) {
      // has SSR styles and in production mode.
      // simply do nothing.
      return noop
    } else {
      // has SSR styles but in dev mode.
      // for some reason Chrome can't handle source map in server-rendered
      // style tags - source maps in <style> only works if the style tag is
      // created and inserted dynamically. So we remove the server rendered
      // styles and inject new ones.
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  if (isOldIE) {
    // use singleton mode for IE9.
    var styleIndex = singletonCounter++
    styleElement = singletonElement || (singletonElement = createStyleElement())
    update = applyToSingletonTag.bind(null, styleElement, styleIndex, false)
    remove = applyToSingletonTag.bind(null, styleElement, styleIndex, true)
  } else {
    // use multi-style-tag mode in all other cases
    styleElement = createStyleElement()
    update = applyToTag.bind(null, styleElement)
    remove = function () {
      styleElement.parentNode.removeChild(styleElement)
    }
  }

  update(obj)

  return function updateStyle (newObj /* StyleObjectPart */) {
    if (newObj) {
      if (newObj.css === obj.css &&
          newObj.media === obj.media &&
          newObj.sourceMap === obj.sourceMap) {
        return
      }
      update(obj = newObj)
    } else {
      remove()
    }
  }
}

var replaceText = (function () {
  var textStore = []

  return function (index, replacement) {
    textStore[index] = replacement
    return textStore.filter(Boolean).join('\n')
  }
})()

function applyToSingletonTag (styleElement, index, remove, obj) {
  var css = remove ? '' : obj.css

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = replaceText(index, css)
  } else {
    var cssNode = document.createTextNode(css)
    var childNodes = styleElement.childNodes
    if (childNodes[index]) styleElement.removeChild(childNodes[index])
    if (childNodes.length) {
      styleElement.insertBefore(cssNode, childNodes[index])
    } else {
      styleElement.appendChild(cssNode)
    }
  }
}

function applyToTag (styleElement, obj) {
  var css = obj.css
  var media = obj.media
  var sourceMap = obj.sourceMap

  if (media) {
    styleElement.setAttribute('media', media)
  }
  if (options.ssrId) {
    styleElement.setAttribute(ssrIdKey, obj.id)
  }

  if (sourceMap) {
    // https://developer.chrome.com/devtools/docs/javascript-debugging
    // this makes source maps inside style tags work properly in Chrome
    css += '\n/*# sourceURL=' + sourceMap.sources[0] + ' */'
    // http://stackoverflow.com/a/26603875
    css += '\n/*# sourceMappingURL=data:application/json;base64,' + btoa(unescape(encodeURIComponent(JSON.stringify(sourceMap)))) + ' */'
  }

  if (styleElement.styleSheet) {
    styleElement.styleSheet.cssText = css
  } else {
    while (styleElement.firstChild) {
      styleElement.removeChild(styleElement.firstChild)
    }
    styleElement.appendChild(document.createTextNode(css))
  }
}


/***/ }),

/***/ "./node_modules/vue-style-loader/lib/listToStyles.js":
/***/ (function(module, exports) {

/**
 * Translates the list format produced by css-loader into something
 * easier to manipulate.
 */
module.exports = function listToStyles (parentId, list) {
  var styles = []
  var newStyles = {}
  for (var i = 0; i < list.length; i++) {
    var item = list[i]
    var id = item[0]
    var css = item[1]
    var media = item[2]
    var sourceMap = item[3]
    var part = {
      id: parentId + ':' + i,
      css: css,
      media: media,
      sourceMap: sourceMap
    }
    if (!newStyles[id]) {
      styles.push(newStyles[id] = { id: id, parts: [part] })
    } else {
      newStyles[id].parts.push(part)
    }
  }
  return styles
}


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