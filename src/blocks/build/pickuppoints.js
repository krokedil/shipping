/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/blocks/src/PickupPoints/index.tsx":
/*!***********************************************!*\
  !*** ./src/blocks/src/PickupPoints/index.tsx ***!
  \***********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _woocommerce_blocks_checkout__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @woocommerce/blocks-checkout */ \"@woocommerce/blocks-checkout\");\n/* harmony import */ var _woocommerce_blocks_checkout__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_woocommerce_blocks_checkout__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ \"@wordpress/components\");\n/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/blocks */ \"@wordpress/blocks\");\n/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react-dom */ \"react-dom\");\n/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react */ \"react\");\n/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_4__);\n// @ts-ignore - Cant avoid this issue, but its loaded in by Webpack\n\n// @ts-ignore - Cant avoid this issue, but its loaded in by Webpack\n\n// @ts-ignore - Cant avoid this issue, but its loaded in by Webpack\n\n// @ts-ignore - Cant avoid this issue, but its loaded in by Webpack\n\n\nconst metadata = __webpack_require__(/*! ./block.json */ \"./src/blocks/src/PickupPoints/block.json\");\nconst callback = (value) => {\n    return value;\n};\n/*registerCheckoutFilters( 'my-extension-namespace', {\n    itemName: callback,\n} );*/\nconst Edit = () => {\n    return react__WEBPACK_IMPORTED_MODULE_4___default().createElement((react__WEBPACK_IMPORTED_MODULE_4___default().Fragment), null);\n};\nconst Block = (props) => {\n    var _a;\n    const { cart } = props;\n    console.log(\"cart\", cart);\n    const [pickupPoints, setPickupPoints] = react__WEBPACK_IMPORTED_MODULE_4___default().useState(null);\n    const [selectedPickupPoint, setSelectedPickupPoint] = react__WEBPACK_IMPORTED_MODULE_4___default().useState(null);\n    const [selectedRate, setSelectedRate] = react__WEBPACK_IMPORTED_MODULE_4___default().useState(null);\n    // If the cart did not exist, return null.\n    if (!cart) {\n        return null;\n    }\n    const { shippingRates } = cart;\n    // If shippingRates is null, return null.\n    if (!shippingRates) {\n        return null;\n    }\n    const getSelectedRate = () => {\n        // Loop each shippingRate and find the selected one. The shipping rates is a array of packages that contains several rates each. So loop each package and their rates.\n        shippingRates.forEach((shippingPackage) => {\n            shippingPackage.shipping_rates.forEach((rate) => {\n                if (rate.selected) {\n                    setSelectedRate(rate);\n                }\n            });\n        });\n    };\n    const getPickupPoints = () => {\n        if (selectedRate && selectedRate.meta_data) {\n            const tmpPickupPoints = selectedRate.meta_data.find((meta) => meta.key === 'krokedil_pickup_points');\n            const tmpSelectedPickupPoint = selectedRate.meta_data.find((meta) => meta.key === 'krokedil_selected_pickup_point');\n            if (tmpPickupPoints) {\n                // Json decode the value and set it to the pickupPoints variable.\n                setPickupPoints(JSON.parse(tmpPickupPoints.value));\n            }\n            if (tmpSelectedPickupPoint) {\n                // Json decode the value and set it to the selectedPickupPoint variable.\n                setSelectedPickupPoint(JSON.parse(tmpSelectedPickupPoint.value));\n            }\n        }\n    };\n    const getElement = () => {\n        const options = pickupPoints.map((pickupPoint) => {\n            return {\n                value: pickupPoint.id,\n                label: pickupPoint.name,\n            };\n        });\n        return (react__WEBPACK_IMPORTED_MODULE_4___default().createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SelectControl, { key: selectedRate.rate_id, className: \"krokedil_shipping_pickup_point__select\", \"data-rate-id\": selectedRate.rate_id, name: \"krokedil_shipping_pickup_point\", id: \"krokedil_shipping_pickup_point\", onChange: (value) => {\n                const selectedPickupPoint = pickupPoints.find((pickupPoint) => pickupPoint.id === value);\n                setSelectedPickupPoint(selectedPickupPoint);\n            }, value: selectedPickupPoint ? selectedPickupPoint.id : '', options: options, variant: \"minimal\" }));\n    };\n    react__WEBPACK_IMPORTED_MODULE_4___default().useEffect(() => {\n        getSelectedRate();\n    }, [shippingRates]);\n    react__WEBPACK_IMPORTED_MODULE_4___default().useEffect(() => {\n        getPickupPoints();\n    }, [selectedRate]);\n    react__WEBPACK_IMPORTED_MODULE_4___default().useEffect(() => {\n        // Trigger the checkout block to refresh when the selected pickup point changes.\n        if (selectedPickupPoint) {\n            (0,_woocommerce_blocks_checkout__WEBPACK_IMPORTED_MODULE_0__.extensionCartUpdate)({\n                namespace: \"krokedil-pickup-point\",\n                data: {\n                    id: selectedPickupPoint.id,\n                    rate_id: selectedRate.rate_id,\n                },\n            });\n        }\n    }, [selectedPickupPoint]);\n    if (!pickupPoints) {\n        return null;\n    }\n    // If we have pickup points, render them.\n    return react__WEBPACK_IMPORTED_MODULE_4___default().createElement((react__WEBPACK_IMPORTED_MODULE_4___default().Fragment), null, react_dom__WEBPACK_IMPORTED_MODULE_3___default().createPortal(getElement(), (_a = document.querySelector(`input[value=\"${selectedRate.rate_id}\"]`)) === null || _a === void 0 ? void 0 : _a.parentElement));\n};\n(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_2__.registerBlockType)(metadata, {\n    icon: 'cart',\n    category: 'woocommerce',\n    edit: () => react__WEBPACK_IMPORTED_MODULE_4___default().createElement(Edit, null),\n    save: () => react__WEBPACK_IMPORTED_MODULE_4___default().createElement(Edit, null),\n});\n(0,_woocommerce_blocks_checkout__WEBPACK_IMPORTED_MODULE_0__.registerCheckoutBlock)({ metadata, component: Block });\n\n\n//# sourceURL=webpack://krokedil-shipping/./src/blocks/src/PickupPoints/index.tsx?");

/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "react-dom":
/*!***************************!*\
  !*** external "ReactDOM" ***!
  \***************************/
/***/ ((module) => {

module.exports = window["ReactDOM"];

/***/ }),

/***/ "@woocommerce/blocks-checkout":
/*!****************************************!*\
  !*** external ["wc","blocksCheckout"] ***!
  \****************************************/
/***/ ((module) => {

module.exports = window["wc"]["blocksCheckout"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "./src/blocks/src/PickupPoints/block.json":
/*!************************************************!*\
  !*** ./src/blocks/src/PickupPoints/block.json ***!
  \************************************************/
/***/ ((module) => {

eval("module.exports = /*#__PURE__*/JSON.parse('{\"name\":\"krokedil/krokedil-pickup-points\",\"version\":\"1.0.0\",\"title\":\"Pickup points\",\"description\":\"Allow customers to select a pickup point.\",\"category\":\"woocommerce\",\"supports\":{\"align\":false,\"html\":false,\"multiple\":false,\"reusable\":false,\"inserter\":false,\"lock\":false},\"attributes\":{\"lock\":{\"type\":\"object\",\"default\":{\"remove\":true,\"move\":true}}},\"parent\":[\"woocommerce/checkout-shipping-methods-block\"],\"textdomain\":\"woocommerce\",\"$schema\":\"https://schemas.wp.org/trunk/block.json\",\"apiVersion\":3,\"editorScript\":\"file:../build/pickuppoints.js\"}');\n\n//# sourceURL=webpack://krokedil-shipping/./src/blocks/src/PickupPoints/block.json?");

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
/******/ 			// no module.id needed
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
/************************************************************************/
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
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./src/blocks/src/PickupPoints/index.tsx");
/******/ 	
/******/ })()
;