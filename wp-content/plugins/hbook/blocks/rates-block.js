/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

var registerBlockType = wp.blocks.registerBlockType;
var InspectorControls = wp.editor.InspectorControls;
var _wp$components = wp.components,
    PanelBody = _wp$components.PanelBody,
    SelectControl = _wp$components.SelectControl;


registerBlockType('hbook/rates', {
	title: hb_blocks_text.rates_title,
	icon: 'grid-view',
	category: 'hbook-blocks',

	edit: function edit(props) {
		var setAttributes = props.setAttributes,
		    attributes = props.attributes;
		var _props$attributes = props.attributes,
		    accom_id = _props$attributes.accom_id,
		    type = _props$attributes.type,
		    sorting = _props$attributes.sorting;


		function on_accom_change(changes) {
			setAttributes({ accom_id: changes });
		}

		function on_type_change(changes) {
			setAttributes({ type: changes });
		}

		function on_sorting_change(changes) {
			setAttributes({ sorting: changes });
		}

		return [wp.element.createElement(
			InspectorControls,
			null,
			wp.element.createElement(
				PanelBody,
				{ title: hb_blocks_text.rates_settings },
				wp.element.createElement(SelectControl, {
					label: hb_blocks_text.accom,
					value: accom_id,
					onChange: on_accom_change,
					options: hb_blocks_data.accom_options_without_all
				}),
				wp.element.createElement(SelectControl, {
					label: hb_blocks_text.rates_type,
					value: type,
					onChange: on_type_change,
					options: [{ value: 'accom', label: hb_blocks_text.rates_type_accom }, { value: 'extra_adults', label: hb_blocks_text.rates_type_adults }, { value: 'extra_children', label: hb_blocks_text.rates_type_children }]
				}),
				wp.element.createElement(SelectControl, {
					label: hb_blocks_text.rates_sorting,
					value: sorting,
					onChange: on_sorting_change,
					options: [{ value: 'grouped', label: hb_blocks_text.rates_sorting_grouped }, { value: 'chrono', label: hb_blocks_text.rates_sorting_chrono }]
				})
			)
		), wp.element.createElement(
			'div',
			null,
			wp.element.createElement(
				'div',
				null,
				hb_blocks_text.rates_block
			),
			!accom_id && wp.element.createElement(
				'div',
				{ style: { color: '#d94f4f', fontSize: '13px' } },
				hb_blocks_text.select_accom
			)
		)];
	},
	save: function save() {
		return null;
	}
});

/***/ })
/******/ ]);