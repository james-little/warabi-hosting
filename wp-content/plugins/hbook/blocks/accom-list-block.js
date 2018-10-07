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
    TextControl = _wp$components.TextControl,
    ToggleControl = _wp$components.ToggleControl;


registerBlockType('hbook/accom-list', {
	title: hb_blocks_text.accom_list_title,
	icon: 'list-view',
	category: 'hbook-blocks',

	edit: function edit(props) {
		var setAttributes = props.setAttributes,
		    attributes = props.attributes;
		var _props$attributes = props.attributes,
		    show_thumb = _props$attributes.show_thumb,
		    link_thumb = _props$attributes.link_thumb,
		    thumb_width = _props$attributes.thumb_width,
		    thumb_height = _props$attributes.thumb_height;


		function on_show_thumb_change() {
			setAttributes({ show_thumb: !show_thumb });
		}

		function on_link_thumb_change() {
			setAttributes({ link_thumb: !link_thumb });
		}

		function on_thumb_width_change(changes) {
			setAttributes({ thumb_width: changes });
		}

		function on_thumb_height_change(changes) {
			setAttributes({ thumb_height: changes });
		}

		return [wp.element.createElement(
			InspectorControls,
			null,
			wp.element.createElement(
				PanelBody,
				{ title: hb_blocks_text.accom_list_settings },
				wp.element.createElement(ToggleControl, {
					label: hb_blocks_text.show_thumb,
					checked: show_thumb,
					onChange: on_show_thumb_change
				}),
				show_thumb && wp.element.createElement(ToggleControl, {
					label: hb_blocks_text.link_thumb_to_accom,
					checked: link_thumb,
					onChange: on_link_thumb_change
				}),
				show_thumb && wp.element.createElement(TextControl, {
					label: hb_blocks_text.thumb_width,
					value: thumb_width,
					onChange: on_thumb_width_change,
					type: 'number',
					step: '10'
				}),
				show_thumb && wp.element.createElement(TextControl, {
					label: hb_blocks_text.thumb_height,
					value: thumb_height,
					onChange: on_thumb_height_change,
					type: 'number',
					step: '10'
				})
			)
		), wp.element.createElement(
			'div',
			null,
			hb_blocks_text.accom_list_block
		)];
	},
	save: function save() {
		return null;
	}
});

/***/ })
/******/ ]);