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
    ToggleControl = _wp$components.ToggleControl,
    SelectControl = _wp$components.SelectControl;


registerBlockType('hbook/booking-form', {
	title: hb_blocks_text.booking_form_title,
	icon: 'welcome-widgets-menus',
	category: 'hbook-blocks',

	edit: function edit(props) {
		var setAttributes = props.setAttributes,
		    attributes = props.attributes;
		var _props$attributes = props.attributes,
		    accom_id = _props$attributes.accom_id,
		    search_only = _props$attributes.search_only,
		    redirection_page_id = _props$attributes.redirection_page_id;


		function on_accom_change(changes) {
			setAttributes({ accom_id: changes });
		}

		function on_redirection_page_change(changes) {
			setAttributes({ redirection_page_id: changes });
		}

		function on_search_only_change() {
			setAttributes({ search_only: !search_only });
		}

		return [wp.element.createElement(
			InspectorControls,
			null,
			wp.element.createElement(
				PanelBody,
				{ title: hb_blocks_text.booking_form_settings },
				wp.element.createElement(SelectControl, {
					label: hb_blocks_text.accom,
					value: accom_id,
					onChange: on_accom_change,
					options: hb_blocks_data.accom_options
				}),
				hb_blocks_data.pages_options.length > 0 && !hb_blocks_data.current_accom_id && wp.element.createElement(ToggleControl, {
					label: hb_blocks_text.search_only,
					checked: search_only,
					onChange: on_search_only_change
				}),
				wp.element.createElement(SelectControl, {
					label: hb_blocks_text.redirection_page,
					value: redirection_page_id,
					onChange: on_redirection_page_change,
					options: hb_blocks_data.pages_options
				})
			)
		), wp.element.createElement(
			'div',
			null,
			wp.element.createElement(
				'div',
				null,
				hb_blocks_text.booking_form_block
			),
			search_only && redirection_page_id == 'none' && wp.element.createElement(
				'div',
				{ style: { color: '#d94f4f', fontSize: '13px' } },
				hb_blocks_text.select_redirection_page
			)
		)];
	},
	save: function save() {
		return null;
	}
});

/***/ })
/******/ ]);