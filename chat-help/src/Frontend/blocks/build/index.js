/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./block.json":
/*!********************!*\
  !*** ./block.json ***!
  \********************/
/***/ ((module) => {

"use strict";
module.exports = /*#__PURE__*/JSON.parse('{"apiVersion":2,"name":"create-block/whatsapp-button","title":"WhatsApp Button","category":"whatsapp-block","icon":"whatsapp","description":"WhatsApp button block for WhatsHelp plugin.","textdomain":"chat-help","editorScript":"file:./build/index.js","editorStyle":"file:./build/index.css","supports":{"html":false,"color":{"background":true,"text":true,"gradients":true,"hover":true},"spacing":{},"typography":{}},"example":{"attributes":{"text":"How can I help you?","gradients":"red-to-blue","links":true}},"attributes":{"text":{"type":"string","default":"How can I help you?"},"info":{"type":"string","default":"Robert / Sales Support"},"title":{"type":"string","default":"How can I help you?"},"online":{"type":"string","default":"I am online"},"offline":{"type":"string","default":"I am offline"},"buttonType":{"type":"string","default":"basic-button"},"whatsappType":{"type":"string","default":"number"},"buttonSize":{"type":"string","default":"size-normal"},"borderRadius":{"type":"string","default":"border-radius-rounded"},"topPadding":{"type":"number","default":7},"rightPadding":{"type":"number","default":12},"bottomPadding":{"type":"number","default":7},"leftPadding":{"type":"number","default":12},"visibility":{"type":"string","default":""},"textAlignment":{"type":"string","default":"left"},"iconTarget":{"type":"boolean","default":false},"buttonLinkTarget":{"type":"boolean","default":true},"numberInput":{"type":"string","default":""},"groupInput":{"type":"string","default":""},"prefilledMessageInput":{"type":"string","default":"Hi! I have a question about your services."},"imageUrl":{"type":"string","default":""},"timeZone":{"type":"string","default":""},"mondayStart":{"type":"string","default":"00:01"},"mondayEnd":{"type":"string","default":"23:59"},"tuesdayStart":{"type":"string","default":"00:01"},"tuesdayEnd":{"type":"string","default":"23:59"},"wednesdayStart":{"type":"string","default":"00:01"},"wednesdayEnd":{"type":"string","default":"23:59"},"thursdayStart":{"type":"string","default":"00:01"},"thursdayEnd":{"type":"string","default":"23:59"},"fridayStart":{"type":"string","default":"00:01"},"fridayEnd":{"type":"string","default":"23:59"},"saturdayStart":{"type":"string","default":"00:01"},"saturdayEnd":{"type":"string","default":"23:59"},"sundayStart":{"type":"string","default":"00:01"},"sundayEnd":{"type":"string","default":"05:00"}}}');

/***/ }),

/***/ "./node_modules/classnames/index.js":
/*!******************************************!*\
  !*** ./node_modules/classnames/index.js ***!
  \******************************************/
/***/ ((module, exports) => {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames () {
		var classes = '';

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (arg) {
				classes = appendClass(classes, parseValue(arg));
			}
		}

		return classes;
	}

	function parseValue (arg) {
		if (typeof arg === 'string' || typeof arg === 'number') {
			return arg;
		}

		if (typeof arg !== 'object') {
			return '';
		}

		if (Array.isArray(arg)) {
			return classNames.apply(null, arg);
		}

		if (arg.toString !== Object.prototype.toString && !arg.toString.toString().includes('[native code]')) {
			return arg.toString();
		}

		var classes = '';

		for (var key in arg) {
			if (hasOwn.call(arg, key) && arg[key]) {
				classes = appendClass(classes, key);
			}
		}

		return classes;
	}

	function appendClass (value, newClass) {
		if (!newClass) {
			return value;
		}
	
		if (value) {
			return value + ' ' + newClass;
		}
	
		return value + newClass;
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else // removed by dead control flow
{}
}());


/***/ }),

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./editor.scss */ "./src/editor.scss");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__);







const agentImage = __webpack_require__(/*! ./images/user.jpg */ "./src/images/user.jpg");
const {
  SelectControl,
  TextControl,
  RangeControl
} = wp.components;
const timezones = [{
  value: 'Africa/Abidjan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Abidjan', 'chat-help')
}, {
  value: 'Africa/Accra',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Accra', 'chat-help')
}, {
  value: 'Africa/Addis_Ababa',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Addis_Ababa', 'chat-help')
}, {
  value: 'Africa/Algiers',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Algiers', 'chat-help')
}, {
  value: 'Africa/Asmara',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Asmara', 'chat-help')
}, {
  value: 'Africa/Asmera',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Asmera', 'chat-help')
}, {
  value: 'Africa/Bamako',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Bamako', 'chat-help')
}, {
  value: 'Africa/Bangui',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Bangui', 'chat-help')
}, {
  value: 'Africa/Banjul',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Banjul', 'chat-help')
}, {
  value: 'Africa/Bissau',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Bissau', 'chat-help')
}, {
  value: 'Africa/Blantyre',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Blantyre', 'chat-help')
}, {
  value: 'Africa/Brazzaville',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Brazzaville', 'chat-help')
}, {
  value: 'Africa/Bujumbura',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Bujumbura', 'chat-help')
}, {
  value: 'Africa/Cairo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Cairo', 'chat-help')
}, {
  value: 'Africa/Casablanca',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Casablanca', 'chat-help')
}, {
  value: 'Africa/Ceuta',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Ceuta', 'chat-help')
}, {
  value: 'Africa/Conakry',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Conakry', 'chat-help')
}, {
  value: 'Africa/Dakar',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Dakar', 'chat-help')
}, {
  value: 'Africa/Dar_es_Salaam',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Dar_es_Salaam', 'chat-help')
}, {
  value: 'Africa/Djibouti',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Djibouti', 'chat-help')
}, {
  value: 'Africa/Douala',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Douala', 'chat-help')
}, {
  value: 'Africa/El_Aaiun',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/El_Aaiun', 'chat-help')
}, {
  value: 'Africa/Freetown',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Freetown', 'chat-help')
}, {
  value: 'Africa/Gaborone',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Gaborone', 'chat-help')
}, {
  value: 'Africa/Harare',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Harare', 'chat-help')
}, {
  value: 'Africa/Johannesburg',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Johannesburg', 'chat-help')
}, {
  value: 'Africa/Juba',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Juba', 'chat-help')
}, {
  value: 'Africa/Kampala',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Kampala', 'chat-help')
}, {
  value: 'Africa/Khartoum',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Khartoum', 'chat-help')
}, {
  value: 'Africa/Kigali',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Kigali', 'chat-help')
}, {
  value: 'Africa/Kinshasa',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Kinshasa', 'chat-help')
}, {
  value: 'Africa/Lagos',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Lagos', 'chat-help')
}, {
  value: 'Africa/Libreville',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Libreville', 'chat-help')
}, {
  value: 'Africa/Lome',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Lome', 'chat-help')
}, {
  value: 'Africa/Luanda',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Luanda', 'chat-help')
}, {
  value: 'Africa/Lubumbashi',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Lubumbashi', 'chat-help')
}, {
  value: 'Africa/Lusaka',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Lusaka', 'chat-help')
}, {
  value: 'Africa/Malabo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Malabo', 'chat-help')
}, {
  value: 'Africa/Maputo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Maputo', 'chat-help')
}, {
  value: 'Africa/Maseru',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Maseru', 'chat-help')
}, {
  value: 'Africa/Mbabane',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Mbabane', 'chat-help')
}, {
  value: 'Africa/Mogadishu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Mogadishu', 'chat-help')
}, {
  value: 'Africa/Monrovia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Monrovia', 'chat-help')
}, {
  value: 'Africa/Nairobi',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Nairobi', 'chat-help')
}, {
  value: 'Africa/Ndjamena',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Ndjamena', 'chat-help')
}, {
  value: 'Africa/Niamey',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Niamey', 'chat-help')
}, {
  value: 'Africa/Nouakchott',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Nouakchott', 'chat-help')
}, {
  value: 'Africa/Ouagadougou',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Ouagadougou', 'chat-help')
}, {
  value: 'Africa/Porto-Novo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Porto-Novo', 'chat-help')
}, {
  value: 'Africa/Sao_Tome',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Sao_Tome', 'chat-help')
}, {
  value: 'Africa/Timbuktu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Timbuktu', 'chat-help')
}, {
  value: 'Africa/Tripoli',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Tripoli', 'chat-help')
}, {
  value: 'Africa/Tunis',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Tunis', 'chat-help')
}, {
  value: 'Africa/Windhoek',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Africa/Windhoek', 'chat-help')
}, {
  value: 'America/Adak',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Adak', 'chat-help')
}, {
  value: 'America/Anchorage',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Anchorage', 'chat-help')
}, {
  value: 'America/Anguilla',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Anguilla', 'chat-help')
}, {
  value: 'America/Antigua',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Antigua', 'chat-help')
}, {
  value: 'America/Araguaina',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Araguaina', 'chat-help')
}, {
  value: 'America/Argentina/Buenos_Aires',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/Buenos_Aires', 'chat-help')
}, {
  value: 'America/Argentina/Catamarca',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/Catamarca', 'chat-help')
}, {
  value: 'America/Argentina/ComodRivadavia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/ComodRivadavia', 'chat-help')
}, {
  value: 'America/Argentina/Cordoba',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/Cordoba', 'chat-help')
}, {
  value: 'America/Argentina/Jujuy',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/Jujuy', 'chat-help')
}, {
  value: 'America/Argentina/La_Rioja',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/La_Rioja', 'chat-help')
}, {
  value: 'America/Argentina/Mendoza',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/Mendoza', 'chat-help')
}, {
  value: 'America/Argentina/Rio_Gallegos',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/Rio_Gallegos', 'chat-help')
}, {
  value: 'America/Argentina/Salta',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/Salta', 'chat-help')
}, {
  value: 'America/Argentina/San_Juan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/San_Juan', 'chat-help')
}, {
  value: 'America/Argentina/San_Luis',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/San_Luis', 'chat-help')
}, {
  value: 'America/Argentina/Tucuman',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/Tucuman', 'chat-help')
}, {
  value: 'America/Argentina/Ushuaia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Argentina/Ushuaia', 'chat-help')
}, {
  value: 'America/Aruba',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Aruba', 'chat-help')
}, {
  value: 'America/Asuncion',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Asuncion', 'chat-help')
}, {
  value: 'America/Atikokan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Atikokan', 'chat-help')
}, {
  value: 'America/Atka',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Atka', 'chat-help')
}, {
  value: 'America/Bahia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Bahia', 'chat-help')
}, {
  value: 'America/Bahia_Banderas',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Bahia_Banderas', 'chat-help')
}, {
  value: 'America/Barbados',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Barbados', 'chat-help')
}, {
  value: 'America/Belem',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Belem', 'chat-help')
}, {
  value: 'America/Belize',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Belize', 'chat-help')
}, {
  value: 'America/Blanc-Sablon',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Blanc-Sablon', 'chat-help')
}, {
  value: 'America/Boa_Vista',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Boa_Vista', 'chat-help')
}, {
  value: 'America/Bogota',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Bogota', 'chat-help')
}, {
  value: 'America/Boise',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Boise', 'chat-help')
}, {
  value: 'America/Buenos_Aires',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Buenos_Aires', 'chat-help')
}, {
  value: 'America/Cambridge_Bay',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Cambridge_Bay', 'chat-help')
}, {
  value: 'America/Campo_Grande',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Campo_Grande', 'chat-help')
}, {
  value: 'America/Cancun',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Cancun', 'chat-help')
}, {
  value: 'America/Caracas',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Caracas', 'chat-help')
}, {
  value: 'America/Catamarca',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Catamarca', 'chat-help')
}, {
  value: 'America/Cayenne',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Cayenne', 'chat-help')
}, {
  value: 'America/Cayman',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Cayman', 'chat-help')
}, {
  value: 'America/Chicago',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Chicago', 'chat-help')
}, {
  value: 'America/Chihuahua',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Chihuahua', 'chat-help')
}, {
  value: 'America/Coral_Harbour',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Coral_Harbour', 'chat-help')
}, {
  value: 'America/Cordoba',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Cordoba', 'chat-help')
}, {
  value: 'America/Costa_Rica',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Costa_Rica', 'chat-help')
}, {
  value: 'America/Creston',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Creston', 'chat-help')
}, {
  value: 'America/Cuiaba',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Cuiaba', 'chat-help')
}, {
  value: 'America/Curacao',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Curacao', 'chat-help')
}, {
  value: 'America/Danmarkshavn',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Danmarkshavn', 'chat-help')
}, {
  value: 'America/Dawson',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Dawson', 'chat-help')
}, {
  value: 'America/Dawson_Creek',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Dawson_Creek', 'chat-help')
}, {
  value: 'America/Denver',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Denver', 'chat-help')
}, {
  value: 'America/Detroit',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Detroit', 'chat-help')
}, {
  value: 'America/Dominica',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Dominica', 'chat-help')
}, {
  value: 'America/Edmonton',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Edmonton', 'chat-help')
}, {
  value: 'America/Eirunepe',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Eirunepe', 'chat-help')
}, {
  value: 'America/El_Salvador',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/El_Salvador', 'chat-help')
}, {
  value: 'America/Ensenada',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Ensenada', 'chat-help')
}, {
  value: 'America/Fort_Nelson',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Fort_Nelson', 'chat-help')
}, {
  value: 'America/Fort_Wayne',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Fort_Wayne', 'chat-help')
}, {
  value: 'America/Fortaleza',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Fortaleza', 'chat-help')
}, {
  value: 'America/Glace_Bay',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Glace_Bay', 'chat-help')
}, {
  value: 'America/Godthab',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Godthab', 'chat-help')
}, {
  value: 'America/Goose_Bay',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Goose_Bay', 'chat-help')
}, {
  value: 'America/Grand_Turk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Grand_Turk', 'chat-help')
}, {
  value: 'America/Grenada',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Grenada', 'chat-help')
}, {
  value: 'America/Guadeloupe',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Guadeloupe', 'chat-help')
}, {
  value: 'America/Guatemala',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Guatemala', 'chat-help')
}, {
  value: 'America/Guayaquil',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Guayaquil', 'chat-help')
}, {
  value: 'America/Guyana',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Guyana', 'chat-help')
}, {
  value: 'America/Halifax',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Halifax', 'chat-help')
}, {
  value: 'America/Havana',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Havana', 'chat-help')
}, {
  value: 'America/Hermosillo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Hermosillo', 'chat-help')
}, {
  value: 'America/Indiana/Indianapolis',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Indiana/Indianapolis', 'chat-help')
}, {
  value: 'America/Indiana/Knox',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Indiana/Knox', 'chat-help')
}, {
  value: 'America/Indiana/Marengo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Indiana/Marengo', 'chat-help')
}, {
  value: 'America/Indiana/Petersburg',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Indiana/Petersburg', 'chat-help')
}, {
  value: 'America/Indiana/Tell_City',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Indiana/Tell_City', 'chat-help')
}, {
  value: 'America/Indiana/Vevay',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Indiana/Vevay', 'chat-help')
}, {
  value: 'America/Indiana/Vincennes',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Indiana/Vincennes', 'chat-help')
}, {
  value: 'America/Indiana/Winamac',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Indiana/Winamac', 'chat-help')
}, {
  value: 'America/Indianapolis',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Indianapolis', 'chat-help')
}, {
  value: 'America/Inuvik',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Inuvik', 'chat-help')
}, {
  value: 'America/Iqaluit',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Iqaluit', 'chat-help')
}, {
  value: 'America/Jamaica',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Jamaica', 'chat-help')
}, {
  value: 'America/Jujuy',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Jujuy', 'chat-help')
}, {
  value: 'America/Juneau',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Juneau', 'chat-help')
}, {
  value: 'America/Kentucky/Louisville',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Kentucky/Louisville', 'chat-help')
}, {
  value: 'America/Kentucky/Monticello',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Kentucky/Monticello', 'chat-help')
}, {
  value: 'America/Knox_IN',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Knox_IN', 'chat-help')
}, {
  value: 'America/Kralendijk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Kralendijk', 'chat-help')
}, {
  value: 'America/La_Paz',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/La_Paz', 'chat-help')
}, {
  value: 'America/Lima',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Lima', 'chat-help')
}, {
  value: 'America/Los_Angeles',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Los_Angeles', 'chat-help')
}, {
  value: 'America/Louisville',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Louisville', 'chat-help')
}, {
  value: 'America/Lower_Princes',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Lower_Princes', 'chat-help')
}, {
  value: 'America/Maceio',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Maceio', 'chat-help')
}, {
  value: 'America/Managua',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Managua', 'chat-help')
}, {
  value: 'America/Manaus',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Manaus', 'chat-help')
}, {
  value: 'America/Marigot',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Marigot', 'chat-help')
}, {
  value: 'America/Martinique',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Martinique', 'chat-help')
}, {
  value: 'America/Matamoros',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Matamoros', 'chat-help')
}, {
  value: 'America/Mazatlan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Mazatlan', 'chat-help')
}, {
  value: 'America/Mendoza',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Mendoza', 'chat-help')
}, {
  value: 'America/Menominee',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Menominee', 'chat-help')
}, {
  value: 'America/Merida',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Merida', 'chat-help')
}, {
  value: 'America/Metlakatla',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Metlakatla', 'chat-help')
}, {
  value: 'America/Mexico_City',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Mexico_City', 'chat-help')
}, {
  value: 'America/Miquelon',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Miquelon', 'chat-help')
}, {
  value: 'America/Moncton',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Moncton', 'chat-help')
}, {
  value: 'America/Monterrey',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Monterrey', 'chat-help')
}, {
  value: 'America/Montevideo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Montevideo', 'chat-help')
}, {
  value: 'America/Montreal',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Montreal', 'chat-help')
}, {
  value: 'America/Montserrat',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Montserrat', 'chat-help')
}, {
  value: 'America/Nassau',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Nassau', 'chat-help')
}, {
  value: 'America/New_York',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/New_York', 'chat-help')
}, {
  value: 'America/Nipigon',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Nipigon', 'chat-help')
}, {
  value: 'America/Nome',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Nome', 'chat-help')
}, {
  value: 'America/Noronha',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Noronha', 'chat-help')
}, {
  value: 'America/North_Dakota/Beulah',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/North_Dakota/Beulah', 'chat-help')
}, {
  value: 'America/North_Dakota/Center',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/North_Dakota/Center', 'chat-help')
}, {
  value: 'America/North_Dakota/New_Salem',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/North_Dakota/New_Salem', 'chat-help')
}, {
  value: 'America/Ojinaga',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Ojinaga', 'chat-help')
}, {
  value: 'America/Panama',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Panama', 'chat-help')
}, {
  value: 'America/Pangnirtung',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Pangnirtung', 'chat-help')
}, {
  value: 'America/Paramaribo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Paramaribo', 'chat-help')
}, {
  value: 'America/Phoenix',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Phoenix', 'chat-help')
}, {
  value: 'America/Port-au-Prince',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Port-au-Prince', 'chat-help')
}, {
  value: 'America/Port_of_Spain',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Port_of_Spain', 'chat-help')
}, {
  value: 'America/Porto_Acre',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Porto_Acre', 'chat-help')
}, {
  value: 'America/Porto_Velho',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Porto_Velho', 'chat-help')
}, {
  value: 'America/Puerto_Rico',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Puerto_Rico', 'chat-help')
}, {
  value: 'America/Punta_Arenas',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Punta_Arenas', 'chat-help')
}, {
  value: 'America/Rainy_River',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Rainy_River', 'chat-help')
}, {
  value: 'America/Rankin_Inlet',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Rankin_Inlet', 'chat-help')
}, {
  value: 'America/Recife',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Recife', 'chat-help')
}, {
  value: 'America/Regina',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Regina', 'chat-help')
}, {
  value: 'America/Resolute',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Resolute', 'chat-help')
}, {
  value: 'America/Rio_Branco',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Rio_Branco', 'chat-help')
}, {
  value: 'America/Rosario',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Rosario', 'chat-help')
}, {
  value: 'America/Santa_Isabel',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Santa_Isabel', 'chat-help')
}, {
  value: 'America/Santarem',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Santarem', 'chat-help')
}, {
  value: 'America/Santiago',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Santiago', 'chat-help')
}, {
  value: 'America/Santo_Domingo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Santo_Domingo', 'chat-help')
}, {
  value: 'America/Sao_Paulo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Sao_Paulo', 'chat-help')
}, {
  value: 'America/Scoresbysund',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Scoresbysund', 'chat-help')
}, {
  value: 'America/Shiprock',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Shiprock', 'chat-help')
}, {
  value: 'America/Sitka',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Sitka', 'chat-help')
}, {
  value: 'America/St_Barthelemy',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/St_Barthelemy', 'chat-help')
}, {
  value: 'America/St_Johns',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/St_Johns', 'chat-help')
}, {
  value: 'America/St_Kitts',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/St_Kitts', 'chat-help')
}, {
  value: 'America/St_Lucia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/St_Lucia', 'chat-help')
}, {
  value: 'America/St_Thomas',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/St_Thomas', 'chat-help')
}, {
  value: 'America/St_Vincent',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/St_Vincent', 'chat-help')
}, {
  value: 'America/Swift_Current',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Swift_Current', 'chat-help')
}, {
  value: 'America/Tegucigalpa',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Tegucigalpa', 'chat-help')
}, {
  value: 'America/Thule',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Thule', 'chat-help')
}, {
  value: 'America/Thunder_Bay',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Thunder_Bay', 'chat-help')
}, {
  value: 'America/Tijuana',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Tijuana', 'chat-help')
}, {
  value: 'America/Toronto',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Toronto', 'chat-help')
}, {
  value: 'America/Tortola',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Tortola', 'chat-help')
}, {
  value: 'America/Vancouver',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Vancouver', 'chat-help')
}, {
  value: 'America/Virgin',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Virgin', 'chat-help')
}, {
  value: 'America/Whitehorse',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Whitehorse', 'chat-help')
}, {
  value: 'America/Winnipeg',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Winnipeg', 'chat-help')
}, {
  value: 'America/Yakutat',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Yakutat', 'chat-help')
}, {
  value: 'America/Yellowknife',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('America/Yellowknife', 'chat-help')
}, {
  value: 'Antarctica/Casey',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/Casey', 'chat-help')
}, {
  value: 'Antarctica/Davis',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/Davis', 'chat-help')
}, {
  value: 'Antarctica/DumontDUrville',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/DumontDUrville', 'chat-help')
}, {
  value: 'Antarctica/Macquarie',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/Macquarie', 'chat-help')
}, {
  value: 'Antarctica/Mawson',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/Mawson', 'chat-help')
}, {
  value: 'Antarctica/McMurdo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/McMurdo', 'chat-help')
}, {
  value: 'Antarctica/Palmer',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/Palmer', 'chat-help')
}, {
  value: 'Antarctica/Rothera',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/Rothera', 'chat-help')
}, {
  value: 'Antarctica/South_Pole',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/South_Pole', 'chat-help')
}, {
  value: 'Antarctica/Syowa',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/Syowa', 'chat-help')
}, {
  value: 'Antarctica/Troll',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/Troll', 'chat-help')
}, {
  value: 'Antarctica/Vostok',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Antarctica/Vostok', 'chat-help')
}, {
  value: 'Arctic/Longyearbyen',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Arctic/Longyearbyen', 'chat-help')
}, {
  value: 'Asia/Aden',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Aden', 'chat-help')
}, {
  value: 'Asia/Almaty',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Almaty', 'chat-help')
}, {
  value: 'Asia/Amman',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Amman', 'chat-help')
}, {
  value: 'Asia/Anadyr',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Anadyr', 'chat-help')
}, {
  value: 'Asia/Aqtau',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Aqtau', 'chat-help')
}, {
  value: 'Asia/Aqtobe',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Aqtobe', 'chat-help')
}, {
  value: 'Asia/Ashgabat',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Ashgabat', 'chat-help')
}, {
  value: 'Asia/Ashkhabad',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Ashkhabad', 'chat-help')
}, {
  value: 'Asia/Atyrau',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Atyrau', 'chat-help')
}, {
  value: 'Asia/Baghdad',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Baghdad', 'chat-help')
}, {
  value: 'Asia/Bahrain',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Bahrain', 'chat-help')
}, {
  value: 'Asia/Baku',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Baku', 'chat-help')
}, {
  value: 'Asia/Bangkok',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Bangkok', 'chat-help')
}, {
  value: 'Asia/Barnaul',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Barnaul', 'chat-help')
}, {
  value: 'Asia/Beirut',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Beirut', 'chat-help')
}, {
  value: 'Asia/Bishkek',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Bishkek', 'chat-help')
}, {
  value: 'Asia/Brunei',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Brunei', 'chat-help')
}, {
  value: 'Asia/Calcutta',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Calcutta', 'chat-help')
}, {
  value: 'Asia/Chita',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Chita', 'chat-help')
}, {
  value: 'Asia/Choibalsan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Choibalsan', 'chat-help')
}, {
  value: 'Asia/Chongqing',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Chongqing', 'chat-help')
}, {
  value: 'Asia/Chungking',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Chungking', 'chat-help')
}, {
  value: 'Asia/Colombo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Colombo', 'chat-help')
}, {
  value: 'Asia/Dacca',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Dacca', 'chat-help')
}, {
  value: 'Asia/Damascus',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Damascus', 'chat-help')
}, {
  value: 'Asia/Dhaka',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Dhaka', 'chat-help')
}, {
  value: 'Asia/Dili',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Dili', 'chat-help')
}, {
  value: 'Asia/Dubai',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Dubai', 'chat-help')
}, {
  value: 'Asia/Dushanbe',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Dushanbe', 'chat-help')
}, {
  value: 'Asia/Famagusta',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Famagusta', 'chat-help')
}, {
  value: 'Asia/Gaza',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Gaza', 'chat-help')
}, {
  value: 'Asia/Harbin',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Harbin', 'chat-help')
}, {
  value: 'Asia/Hebron',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Hebron', 'chat-help')
}, {
  value: 'Asia/Ho_Chi_Minh',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Ho_Chi_Minh', 'chat-help')
}, {
  value: 'Asia/Hong_Kong',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Hong_Kong', 'chat-help')
}, {
  value: 'Asia/Hovd',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Hovd', 'chat-help')
}, {
  value: 'Asia/Irkutsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Irkutsk', 'chat-help')
}, {
  value: 'Asia/Istanbul',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Istanbul', 'chat-help')
}, {
  value: 'Asia/Jakarta',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Jakarta', 'chat-help')
}, {
  value: 'Asia/Jayapura',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Jayapura', 'chat-help')
}, {
  value: 'Asia/Jerusalem',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Jerusalem', 'chat-help')
}, {
  value: 'Asia/Kabul',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Kabul', 'chat-help')
}, {
  value: 'Asia/Kamchatka',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Kamchatka', 'chat-help')
}, {
  value: 'Asia/Karachi',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Karachi', 'chat-help')
}, {
  value: 'Asia/Kashgar',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Kashgar', 'chat-help')
}, {
  value: 'Asia/Kathmandu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Kathmandu', 'chat-help')
}, {
  value: 'Asia/Katmandu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Katmandu', 'chat-help')
}, {
  value: 'Asia/Khandyga',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Khandyga', 'chat-help')
}, {
  value: 'Asia/Kolkata',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Kolkata', 'chat-help')
}, {
  value: 'Asia/Krasnoyarsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Krasnoyarsk', 'chat-help')
}, {
  value: 'Asia/Kuala_Lumpur',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Kuala_Lumpur', 'chat-help')
}, {
  value: 'Asia/Kuching',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Kuching', 'chat-help')
}, {
  value: 'Asia/Kuwait',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Kuwait', 'chat-help')
}, {
  value: 'Asia/Macao',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Macao', 'chat-help')
}, {
  value: 'Asia/Macau',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Macau', 'chat-help')
}, {
  value: 'Asia/Magadan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Magadan', 'chat-help')
}, {
  value: 'Asia/Makassar',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Makassar', 'chat-help')
}, {
  value: 'Asia/Manila',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Manila', 'chat-help')
}, {
  value: 'Asia/Muscat',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Muscat', 'chat-help')
}, {
  value: 'Asia/Nicosia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Nicosia', 'chat-help')
}, {
  value: 'Asia/Novokuznetsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Novokuznetsk', 'chat-help')
}, {
  value: 'Asia/Novosibirsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Novosibirsk', 'chat-help')
}, {
  value: 'Asia/Omsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Omsk', 'chat-help')
}, {
  value: 'Asia/Oral',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Oral', 'chat-help')
}, {
  value: 'Asia/Phnom_Penh',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Phnom_Penh', 'chat-help')
}, {
  value: 'Asia/Pontianak',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Pontianak', 'chat-help')
}, {
  value: 'Asia/Pyongyang',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Pyongyang', 'chat-help')
}, {
  value: 'Asia/Qatar',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Qatar', 'chat-help')
}, {
  value: 'Asia/Qyzylorda',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Qyzylorda', 'chat-help')
}, {
  value: 'Asia/Rangoon',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Rangoon', 'chat-help')
}, {
  value: 'Asia/Riyadh',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Riyadh', 'chat-help')
}, {
  value: 'Asia/Saigon',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Saigon', 'chat-help')
}, {
  value: 'Asia/Sakhalin',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Sakhalin', 'chat-help')
}, {
  value: 'Asia/Samarkand',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Samarkand', 'chat-help')
}, {
  value: 'Asia/Seoul',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Seoul', 'chat-help')
}, {
  value: 'Asia/Shanghai',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Shanghai', 'chat-help')
}, {
  value: 'Asia/Singapore',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Singapore', 'chat-help')
}, {
  value: 'Asia/Srednekolymsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Srednekolymsk', 'chat-help')
}, {
  value: 'Asia/Taipei',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Taipei', 'chat-help')
}, {
  value: 'Asia/Tashkent',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Tashkent', 'chat-help')
}, {
  value: 'Asia/Tbilisi',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Tbilisi', 'chat-help')
}, {
  value: 'Asia/Tehran',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Tehran', 'chat-help')
}, {
  value: 'Asia/Tel_Aviv',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Tel_Aviv', 'chat-help')
}, {
  value: 'Asia/Thimbu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Thimbu', 'chat-help')
}, {
  value: 'Asia/Thimphu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Thimphu', 'chat-help')
}, {
  value: 'Asia/Tokyo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Tokyo', 'chat-help')
}, {
  value: 'Asia/Tomsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Tomsk', 'chat-help')
}, {
  value: 'Asia/Ujung_Pandang',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Ujung_Pandang', 'chat-help')
}, {
  value: 'Asia/Ulaanbaatar',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Ulaanbaatar', 'chat-help')
}, {
  value: 'Asia/Ulan_Bator',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Ulan_Bator', 'chat-help')
}, {
  value: 'Asia/Urumqi',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Urumqi', 'chat-help')
}, {
  value: 'Asia/Ust-Nera',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Ust-Nera', 'chat-help')
}, {
  value: 'Asia/Vientiane',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Vientiane', 'chat-help')
}, {
  value: 'Asia/Vladivostok',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Vladivostok', 'chat-help')
}, {
  value: 'Asia/Yakutsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Yakutsk', 'chat-help')
}, {
  value: 'Asia/Yangon',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Yangon', 'chat-help')
}, {
  value: 'Asia/Yekaterinburg',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Yekaterinburg', 'chat-help')
}, {
  value: 'Asia/Yerevan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Asia/Yerevan', 'chat-help')
}, {
  value: 'Atlantic/Azores',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Azores', 'chat-help')
}, {
  value: 'Atlantic/Bermuda',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Bermuda', 'chat-help')
}, {
  value: 'Atlantic/Canary',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Canary', 'chat-help')
}, {
  value: 'Atlantic/Cape_Verde',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Cape_Verde', 'chat-help')
}, {
  value: 'Atlantic/Faeroe',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Faeroe', 'chat-help')
}, {
  value: 'Atlantic/Faroe',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Faroe', 'chat-help')
}, {
  value: 'Atlantic/Jan_Mayen',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Jan_Mayen', 'chat-help')
}, {
  value: 'Atlantic/Madeira',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Madeira', 'chat-help')
}, {
  value: 'Atlantic/Reykjavik',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Reykjavik', 'chat-help')
}, {
  value: 'Atlantic/South_Georgia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/South_Georgia', 'chat-help')
}, {
  value: 'Atlantic/St_Helena',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/St_Helena', 'chat-help')
}, {
  value: 'Atlantic/Stanley',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Atlantic/Stanley', 'chat-help')
}, {
  value: 'Australia/ACT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/ACT', 'chat-help')
}, {
  value: 'Australia/Adelaide',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Adelaide', 'chat-help')
}, {
  value: 'Australia/Brisbane',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Brisbane', 'chat-help')
}, {
  value: 'Australia/Broken_Hill',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Broken_Hill', 'chat-help')
}, {
  value: 'Australia/Canberra',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Canberra', 'chat-help')
}, {
  value: 'Australia/Currie',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Currie', 'chat-help')
}, {
  value: 'Australia/Darwin',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Darwin', 'chat-help')
}, {
  value: 'Australia/Eucla',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Eucla', 'chat-help')
}, {
  value: 'Australia/Hobart',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Hobart', 'chat-help')
}, {
  value: 'Australia/LHI',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/LHI', 'chat-help')
}, {
  value: 'Australia/Lindeman',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Lindeman', 'chat-help')
}, {
  value: 'Australia/Lord_Howe',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Lord_Howe', 'chat-help')
}, {
  value: 'Australia/Melbourne',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Melbourne', 'chat-help')
}, {
  value: 'Australia/NSW',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/NSW', 'chat-help')
}, {
  value: 'Australia/North',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/North', 'chat-help')
}, {
  value: 'Australia/Perth',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Perth', 'chat-help')
}, {
  value: 'Australia/Queensland',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Queensland', 'chat-help')
}, {
  value: 'Australia/South',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/South', 'chat-help')
}, {
  value: 'Australia/Sydney',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Sydney', 'chat-help')
}, {
  value: 'Australia/Tasmania',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Tasmania', 'chat-help')
}, {
  value: 'Australia/Victoria',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Victoria', 'chat-help')
}, {
  value: 'Australia/West',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/West', 'chat-help')
}, {
  value: 'Australia/Yancowinna',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Australia/Yancowinna', 'chat-help')
}, {
  value: 'Brazil/Acre',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Brazil/Acre', 'chat-help')
}, {
  value: 'Brazil/DeNoronha',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Brazil/DeNoronha', 'chat-help')
}, {
  value: 'Brazil/East',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Brazil/East', 'chat-help')
}, {
  value: 'Brazil/West',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Brazil/West', 'chat-help')
}, {
  value: 'CET',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('CET', 'chat-help')
}, {
  value: 'CST6CDT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('CST6CDT', 'chat-help')
}, {
  value: 'Canada/Atlantic',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Canada/Atlantic', 'chat-help')
}, {
  value: 'Canada/Central',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Canada/Central', 'chat-help')
}, {
  value: 'Canada/Eastern',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Canada/Eastern', 'chat-help')
}, {
  value: 'Canada/Mountain',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Canada/Mountain', 'chat-help')
}, {
  value: 'Canada/Newfoundland',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Canada/Newfoundland', 'chat-help')
}, {
  value: 'Canada/Pacific',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Canada/Pacific', 'chat-help')
}, {
  value: 'Canada/Saskatchewan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Canada/Saskatchewan', 'chat-help')
}, {
  value: 'Canada/Yukon',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Canada/Yukon', 'chat-help')
}, {
  value: 'Chile/Continental',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Chile/Continental', 'chat-help')
}, {
  value: 'Chile/EasterIsland',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Chile/EasterIsland', 'chat-help')
}, {
  value: 'Cuba',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Cuba', 'chat-help')
}, {
  value: 'EET',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('EET', 'chat-help')
}, {
  value: 'EST',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('EST', 'chat-help')
}, {
  value: 'EST5EDT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('EST5EDT', 'chat-help')
}, {
  value: 'Egypt',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Egypt', 'chat-help')
}, {
  value: 'Eire',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Eire', 'chat-help')
}, {
  value: 'Etc/GMT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT', 'chat-help')
}, {
  value: 'Etc/GMT+0',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+0', 'chat-help')
}, {
  value: 'Etc/GMT+1',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+1', 'chat-help')
}, {
  value: 'Etc/GMT+10',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+10', 'chat-help')
}, {
  value: 'Etc/GMT+11',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+11', 'chat-help')
}, {
  value: 'Etc/GMT+12',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+12', 'chat-help')
}, {
  value: 'Etc/GMT+2',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+2', 'chat-help')
}, {
  value: 'Etc/GMT+3',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+3', 'chat-help')
}, {
  value: 'Etc/GMT+4',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+4', 'chat-help')
}, {
  value: 'Etc/GMT+5',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+5', 'chat-help')
}, {
  value: 'Etc/GMT+6',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+6', 'chat-help')
}, {
  value: 'Etc/GMT+7',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+7', 'chat-help')
}, {
  value: 'Etc/GMT+8',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+8', 'chat-help')
}, {
  value: 'Etc/GMT+9',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT+9', 'chat-help')
}, {
  value: 'Etc/GMT-0',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-0', 'chat-help')
}, {
  value: 'Etc/GMT-1',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-1', 'chat-help')
}, {
  value: 'Etc/GMT-10',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-10', 'chat-help')
}, {
  value: 'Etc/GMT-11',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-11', 'chat-help')
}, {
  value: 'Etc/GMT-12',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-12', 'chat-help')
}, {
  value: 'Etc/GMT-13',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-13', 'chat-help')
}, {
  value: 'Etc/GMT-14',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-14', 'chat-help')
}, {
  value: 'Etc/GMT-2',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-2', 'chat-help')
}, {
  value: 'Etc/GMT-3',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-3', 'chat-help')
}, {
  value: 'Etc/GMT-4',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-4', 'chat-help')
}, {
  value: 'Etc/GMT-5',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-5', 'chat-help')
}, {
  value: 'Etc/GMT-6',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-6', 'chat-help')
}, {
  value: 'Etc/GMT-7',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-7', 'chat-help')
}, {
  value: 'Etc/GMT-8',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-8', 'chat-help')
}, {
  value: 'Etc/GMT-9',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT-9', 'chat-help')
}, {
  value: 'Etc/GMT0',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/GMT0', 'chat-help')
}, {
  value: 'Etc/Greenwich',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/Greenwich', 'chat-help')
}, {
  value: 'Etc/UCT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/UCT', 'chat-help')
}, {
  value: 'Etc/UTC',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/UTC', 'chat-help')
}, {
  value: 'Etc/Universal',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/Universal', 'chat-help')
}, {
  value: 'Etc/Zulu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Etc/Zulu', 'chat-help')
}, {
  value: 'Europe/Amsterdam',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Amsterdam', 'chat-help')
}, {
  value: 'Europe/Andorra',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Andorra', 'chat-help')
}, {
  value: 'Europe/Astrakhan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Astrakhan', 'chat-help')
}, {
  value: 'Europe/Athens',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Athens', 'chat-help')
}, {
  value: 'Europe/Belfast',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Belfast', 'chat-help')
}, {
  value: 'Europe/Belgrade',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Belgrade', 'chat-help')
}, {
  value: 'Europe/Berlin',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Berlin', 'chat-help')
}, {
  value: 'Europe/Bratislava',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Bratislava', 'chat-help')
}, {
  value: 'Europe/Brussels',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Brussels', 'chat-help')
}, {
  value: 'Europe/Bucharest',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Bucharest', 'chat-help')
}, {
  value: 'Europe/Budapest',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Budapest', 'chat-help')
}, {
  value: 'Europe/Busingen',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Busingen', 'chat-help')
}, {
  value: 'Europe/Chisinau',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Chisinau', 'chat-help')
}, {
  value: 'Europe/Copenhagen',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Copenhagen', 'chat-help')
}, {
  value: 'Europe/Dublin',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Dublin', 'chat-help')
}, {
  value: 'Europe/Gibraltar',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Gibraltar', 'chat-help')
}, {
  value: 'Europe/Guernsey',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Guernsey', 'chat-help')
}, {
  value: 'Europe/Helsinki',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Helsinki', 'chat-help')
}, {
  value: 'Europe/Isle_of_Man',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Isle_of_Man', 'chat-help')
}, {
  value: 'Europe/Istanbul',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Istanbul', 'chat-help')
}, {
  value: 'Europe/Jersey',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Jersey', 'chat-help')
}, {
  value: 'Europe/Kaliningrad',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Kaliningrad', 'chat-help')
}, {
  value: 'Europe/Kiev',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Kiev', 'chat-help')
}, {
  value: 'Europe/Kirov',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Kirov', 'chat-help')
}, {
  value: 'Europe/Lisbon',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Lisbon', 'chat-help')
}, {
  value: 'Europe/Ljubljana',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Ljubljana', 'chat-help')
}, {
  value: 'Europe/London',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/London', 'chat-help')
}, {
  value: 'Europe/Luxembourg',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Luxembourg', 'chat-help')
}, {
  value: 'Europe/Madrid',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Madrid', 'chat-help')
}, {
  value: 'Europe/Malta',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Malta', 'chat-help')
}, {
  value: 'Europe/Mariehamn',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Mariehamn', 'chat-help')
}, {
  value: 'Europe/Minsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Minsk', 'chat-help')
}, {
  value: 'Europe/Monaco',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Monaco', 'chat-help')
}, {
  value: 'Europe/Moscow',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Moscow', 'chat-help')
}, {
  value: 'Europe/Nicosia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Nicosia', 'chat-help')
}, {
  value: 'Europe/Oslo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Oslo', 'chat-help')
}, {
  value: 'Europe/Paris',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Paris', 'chat-help')
}, {
  value: 'Europe/Podgorica',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Podgorica', 'chat-help')
}, {
  value: 'Europe/Prague',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Prague', 'chat-help')
}, {
  value: 'Europe/Riga',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Riga', 'chat-help')
}, {
  value: 'Europe/Rome',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Rome', 'chat-help')
}, {
  value: 'Europe/Samara',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Samara', 'chat-help')
}, {
  value: 'Europe/San_Marino',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/San_Marino', 'chat-help')
}, {
  value: 'Europe/Sarajevo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Sarajevo', 'chat-help')
}, {
  value: 'Europe/Saratov',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Saratov', 'chat-help')
}, {
  value: 'Europe/Simferopol',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Simferopol', 'chat-help')
}, {
  value: 'Europe/Skopje',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Skopje', 'chat-help')
}, {
  value: 'Europe/Sofia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Sofia', 'chat-help')
}, {
  value: 'Europe/Stockholm',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Stockholm', 'chat-help')
}, {
  value: 'Europe/Tallinn',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Tallinn', 'chat-help')
}, {
  value: 'Europe/Tirane',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Tirane', 'chat-help')
}, {
  value: 'Europe/Tiraspol',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Tiraspol', 'chat-help')
}, {
  value: 'Europe/Ulyanovsk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Ulyanovsk', 'chat-help')
}, {
  value: 'Europe/Uzhgorod',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Uzhgorod', 'chat-help')
}, {
  value: 'Europe/Vaduz',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Vaduz', 'chat-help')
}, {
  value: 'Europe/Vatican',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Vatican', 'chat-help')
}, {
  value: 'Europe/Vienna',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Vienna', 'chat-help')
}, {
  value: 'Europe/Vilnius',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Vilnius', 'chat-help')
}, {
  value: 'Europe/Volgograd',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Volgograd', 'chat-help')
}, {
  value: 'Europe/Warsaw',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Warsaw', 'chat-help')
}, {
  value: 'Europe/Zagreb',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Zagreb', 'chat-help')
}, {
  value: 'Europe/Zaporozhye',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Zaporozhye', 'chat-help')
}, {
  value: 'Europe/Zurich',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Europe/Zurich', 'chat-help')
}, {
  value: 'GB',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('GB', 'chat-help')
}, {
  value: 'GB-Eire',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('GB-Eire', 'chat-help')
}, {
  value: 'GMT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('GMT', 'chat-help')
}, {
  value: 'GMT+0',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('GMT+0', 'chat-help')
}, {
  value: 'GMT-0',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('GMT-0', 'chat-help')
}, {
  value: 'GMT0',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('GMT0', 'chat-help')
}, {
  value: 'Greenwich',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Greenwich', 'chat-help')
}, {
  value: 'HST',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('HST', 'chat-help')
}, {
  value: 'Hongkong',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Hongkong', 'chat-help')
}, {
  value: 'Iceland',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Iceland', 'chat-help')
}, {
  value: 'Indian/Antananarivo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Antananarivo', 'chat-help')
}, {
  value: 'Indian/Chagos',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Chagos', 'chat-help')
}, {
  value: 'Indian/Christmas',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Christmas', 'chat-help')
}, {
  value: 'Indian/Cocos',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Cocos', 'chat-help')
}, {
  value: 'Indian/Comoro',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Comoro', 'chat-help')
}, {
  value: 'Indian/Kerguelen',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Kerguelen', 'chat-help')
}, {
  value: 'Indian/Mahe',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Mahe', 'chat-help')
}, {
  value: 'Indian/Maldives',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Maldives', 'chat-help')
}, {
  value: 'Indian/Mauritius',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Mauritius', 'chat-help')
}, {
  value: 'Indian/Mayotte',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Mayotte', 'chat-help')
}, {
  value: 'Indian/Reunion',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Indian/Reunion', 'chat-help')
}, {
  value: 'Iran',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Iran', 'chat-help')
}, {
  value: 'Israel',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Israel', 'chat-help')
}, {
  value: 'Jamaica',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Jamaica', 'chat-help')
}, {
  value: 'Japan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Japan', 'chat-help')
}, {
  value: 'Kwajalein',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Kwajalein', 'chat-help')
}, {
  value: 'Libya',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Libya', 'chat-help')
}, {
  value: 'MET',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('MET', 'chat-help')
}, {
  value: 'MST',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('MST', 'chat-help')
}, {
  value: 'MST7MDT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('MST7MDT', 'chat-help')
}, {
  value: 'Mexico/BajaNorte',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Mexico/BajaNorte', 'chat-help')
}, {
  value: 'Mexico/BajaSur',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Mexico/BajaSur', 'chat-help')
}, {
  value: 'Mexico/General',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Mexico/General', 'chat-help')
}, {
  value: 'NZ',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('NZ', 'chat-help')
}, {
  value: 'NZ-CHAT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('NZ-CHAT', 'chat-help')
}, {
  value: 'Navajo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Navajo', 'chat-help')
}, {
  value: 'PRC',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('PRC', 'chat-help')
}, {
  value: 'PST8PDT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('PST8PDT', 'chat-help')
}, {
  value: 'Pacific/Apia',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Apia', 'chat-help')
}, {
  value: 'Pacific/Auckland',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Auckland', 'chat-help')
}, {
  value: 'Pacific/Bougainville',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Bougainville', 'chat-help')
}, {
  value: 'Pacific/Chatham',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Chatham', 'chat-help')
}, {
  value: 'Pacific/Chuuk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Chuuk', 'chat-help')
}, {
  value: 'Pacific/Easter',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Easter', 'chat-help')
}, {
  value: 'Pacific/Efate',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Efate', 'chat-help')
}, {
  value: 'Pacific/Enderbury',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Enderbury', 'chat-help')
}, {
  value: 'Pacific/Fakaofo',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Fakaofo', 'chat-help')
}, {
  value: 'Pacific/Fiji',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Fiji', 'chat-help')
}, {
  value: 'Pacific/Funafuti',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Funafuti', 'chat-help')
}, {
  value: 'Pacific/Galapagos',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Galapagos', 'chat-help')
}, {
  value: 'Pacific/Gambier',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Gambier', 'chat-help')
}, {
  value: 'Pacific/Guadalcanal',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Guadalcanal', 'chat-help')
}, {
  value: 'Pacific/Guam',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Guam', 'chat-help')
}, {
  value: 'Pacific/Honolulu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Honolulu', 'chat-help')
}, {
  value: 'Pacific/Johnston',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Johnston', 'chat-help')
}, {
  value: 'Pacific/Kiritimati',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Kiritimati', 'chat-help')
}, {
  value: 'Pacific/Kosrae',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Kosrae', 'chat-help')
}, {
  value: 'Pacific/Kwajalein',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Kwajalein', 'chat-help')
}, {
  value: 'Pacific/Majuro',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Majuro', 'chat-help')
}, {
  value: 'Pacific/Marquesas',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Marquesas', 'chat-help')
}, {
  value: 'Pacific/Midway',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Midway', 'chat-help')
}, {
  value: 'Pacific/Nauru',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Nauru', 'chat-help')
}, {
  value: 'Pacific/Niue',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Niue', 'chat-help')
}, {
  value: 'Pacific/Norfolk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Norfolk', 'chat-help')
}, {
  value: 'Pacific/Noumea',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Noumea', 'chat-help')
}, {
  value: 'Pacific/Pago_Pago',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Pago_Pago', 'chat-help')
}, {
  value: 'Pacific/Palau',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Palau', 'chat-help')
}, {
  value: 'Pacific/Pitcairn',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Pitcairn', 'chat-help')
}, {
  value: 'Pacific/Pohnpei',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Pohnpei', 'chat-help')
}, {
  value: 'Pacific/Ponape',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Ponape', 'chat-help')
}, {
  value: 'Pacific/Port_Moresby',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Port_Moresby', 'chat-help')
}, {
  value: 'Pacific/Rarotonga',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Rarotonga', 'chat-help')
}, {
  value: 'Pacific/Saipan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Saipan', 'chat-help')
}, {
  value: 'Pacific/Samoa',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Samoa', 'chat-help')
}, {
  value: 'Pacific/Tahiti',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Tahiti', 'chat-help')
}, {
  value: 'Pacific/Tarawa',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Tarawa', 'chat-help')
}, {
  value: 'Pacific/Tongatapu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Tongatapu', 'chat-help')
}, {
  value: 'Pacific/Truk',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Truk', 'chat-help')
}, {
  value: 'Pacific/Wake',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Wake', 'chat-help')
}, {
  value: 'Pacific/Wallis',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Wallis', 'chat-help')
}, {
  value: 'Pacific/Yap',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pacific/Yap', 'chat-help')
}, {
  value: 'Poland',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Poland', 'chat-help')
}, {
  value: 'Portugal',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Portugal', 'chat-help')
}, {
  value: 'ROC',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('ROC', 'chat-help')
}, {
  value: 'ROK',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('ROK', 'chat-help')
}, {
  value: 'Singapore',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Singapore', 'chat-help')
}, {
  value: 'Turkey',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Turkey', 'chat-help')
}, {
  value: 'UCT',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('UCT', 'chat-help')
}, {
  value: 'US/Alaska',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Alaska', 'chat-help')
}, {
  value: 'US/Aleutian',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Aleutian', 'chat-help')
}, {
  value: 'US/Arizona',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Arizona', 'chat-help')
}, {
  value: 'US/Central',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Central', 'chat-help')
}, {
  value: 'US/East-Indiana',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/East-Indiana', 'chat-help')
}, {
  value: 'US/Eastern',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Eastern', 'chat-help')
}, {
  value: 'US/Hawaii',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Hawaii', 'chat-help')
}, {
  value: 'US/Indiana-Starke',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Indiana-Starke', 'chat-help')
}, {
  value: 'US/Michigan',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Michigan', 'chat-help')
}, {
  value: 'US/Mountain',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Mountain', 'chat-help')
}, {
  value: 'US/Pacific',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Pacific', 'chat-help')
}, {
  value: 'US/Pacific-New',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Pacific-New', 'chat-help')
}, {
  value: 'US/Samoa',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('US/Samoa', 'chat-help')
}, {
  value: 'UTC',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('UTC', 'chat-help')
}, {
  value: 'Universal',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Universal', 'chat-help')
}, {
  value: 'W-SU',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('W-SU', 'chat-help')
}, {
  value: 'WET',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('WET', 'chat-help')
}, {
  value: 'Zulu',
  label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Zulu', 'chat-help')
}];
function Edit(props) {
  const {
    attributes,
    setAttributes
  } = props;
  const {
    buttonSize,
    buttonType,
    borderRadius,
    text,
    info,
    title,
    online,
    offline,
    textAlignment,
    iconTarget,
    visibility,
    buttonLinkTarget,
    whatsappType,
    numberInput,
    groupInput,
    prefilledMessageInput,
    imageUrl,
    timeZone,
    mondayStart,
    mondayEnd,
    tuesdayStart,
    tuesdayEnd,
    wednesdayStart,
    wednesdayEnd,
    thursdayStart,
    thursdayEnd,
    fridayStart,
    fridayEnd,
    saturdayStart,
    saturdayEnd,
    sundayStart,
    sundayEnd,
    topPadding,
    rightPadding,
    bottomPadding,
    leftPadding
  } = attributes;
  const [filteredOptions, setFilteredOptions] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.useState)(timezones);
  function onInputChange(value) {
    setFilteredOptions(timezones.filter(timezone => timezone.label.toLowerCase().includes(value.toLowerCase())));
  }
  function onFontSizeChange(value) {
    setAttributes({
      timeZone: value
    });
  }
  const onSelectImage = image => {
    setAttributes({
      imageUrl: image.url
    });
  };
  const onChangeAlignment = newAlignment => {
    setAttributes({
      textAlignment: newAlignment
    });
  };
  const onChangeText = newText => {
    setAttributes({
      text: newText
    });
  };
  const advancedBtnInfo = newInfo => {
    setAttributes({
      info: newInfo
    });
  };
  const advancedBtnTitle = newTitle => {
    setAttributes({
      title: newTitle
    });
  };
  const advancedBtnOnlineBadge = newOnline => {
    setAttributes({
      online: newOnline
    });
  };
  const onIconTarget = onIconTargets => {
    setAttributes({
      iconTarget: onIconTargets
    });
  };
  const onButtonLinkTarget = newLinkTarget => {
    setAttributes({
      buttonLinkTarget: newLinkTarget
    });
  };
  const textClasses = classnames__WEBPACK_IMPORTED_MODULE_4___default()(`wHelpButtons-align-${textAlignment}`);
  const basicBtn = classnames__WEBPACK_IMPORTED_MODULE_4___default()(`wHelp-button-4 wHelp-btn-bg`);
  const classes = classnames__WEBPACK_IMPORTED_MODULE_4___default()(`wHelpButtons wHelp-button-4 wHelp-btn-bg`);
  const buttonSizeOptions = [{
    value: 'size-small',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Small', 'chat-help')
  }, {
    value: 'size-medium',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Medium', 'chat-help')
  }, {
    value: 'size-large',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Large', 'chat-help')
  }];
  const buttonTypeOptions = [{
    value: 'basic-button',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Basic Button', 'chat-help')
  }, {
    value: 'advance-button',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Advance Button', 'chat-help')
  }];
  const typeOfWhatsapp = [{
    value: 'number',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Number', 'chat-help')
  }, {
    value: 'group',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Group', 'chat-help')
  }];
  const borderRadiusOptions = [{
    value: 'border-squared',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Border Squared', 'chat-help')
  }, {
    value: 'wHelp-btn-rounded',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Border Rounded', 'chat-help')
  }];
  const visibilityOn = [{
    value: '',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Everywhere', 'chat-help')
  }, {
    value: 'wHelp-desktop-only',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Desktop only', 'chat-help')
  }, {
    value: 'wHelp-tablet-only',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Tablets only', 'chat-help')
  }, {
    value: 'wHelp-mobile-tablet-only',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Mobile and tablets', 'chat-help')
  }, {
    value: 'wHelp-mobile-only',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Mobile only', 'chat-help')
  }];
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.Fragment, {
    children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.InspectorControls, {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(SelectControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Button Type', 'chat-help'),
          value: buttonType,
          options: buttonTypeOptions,
          onChange: newButton => setAttributes({
            buttonType: newButton
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(SelectControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Type of Whatsapp', 'chat-help'),
          value: whatsappType,
          options: typeOfWhatsapp,
          onChange: val => setAttributes({
            whatsappType: val
          })
        })]
      })
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.InspectorControls, {
      children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('General Settings', 'chat-help'),
        initialOpen: false,
        children: [whatsappType === 'number' ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.Fragment, {
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Number', 'chat-help'),
            value: numberInput,
            onChange: val => setAttributes({
              numberInput: val
            }),
            help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Add your contact number including country code eg: +880123456789', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.TextareaControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Pre-filled Message', 'chat-help'),
            value: prefilledMessageInput,
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Hi! I have a question about your services.', 'chat-help'),
            onChange: val => setAttributes({
              prefilledMessageInput: val
            }),
            help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Write a friendly, pre-filled message users will see when they click the chat bubble. Example: “Hi! I have a question about your services.” This saves them time—and makes starting a conversation feel effortless.', 'chat-help')
          })]
        }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Group', 'chat-help'),
          value: groupInput,
          onChange: val => setAttributes({
            groupInput: val
          }),
          help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Add your contact group link', 'chat-help')
        }), buttonType === 'advance-button' ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.Fragment, {
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.MediaUpload, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Agent Image', 'chat-help'),
            onSelect: onSelectImage,
            allowedTypes: ['image'],
            render: ({
              open
            }) => /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
              onClick: open,
              style: {
                marginBottom: '20px',
                fontSize: '16px'
              },
              children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)("span", {
                style: {
                  marginRight: '5px'
                },
                className: "dashicons dashicons-cloud-upload"
              }), ' ', "Agent photo"]
            })
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Agent Info', 'chat-help'),
            value: info,
            onChange: val => setAttributes({
              info: val
            }),
            help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Write agent name & agent title', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Button Label', 'chat-help'),
            value: title,
            onChange: val => setAttributes({
              title: val
            }),
            help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Add custom button label', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Online Badge Text', 'chat-help'),
            value: online,
            onChange: val => setAttributes({
              online: val
            }),
            help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Add custom badget text when user in online.', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Offline Badge Text', 'chat-help'),
            value: offline,
            onChange: val => setAttributes({
              offline: val
            }),
            help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Add custom badget text when user in offline.', 'chat-help')
          })]
        }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Button Text', 'chat-help'),
          value: text,
          onChange: val => setAttributes({
            text: val
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ToggleControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Open link in new window', 'chat-help'),
          checked: buttonLinkTarget,
          onChange: onButtonLinkTarget
        })]
      }), buttonType === 'advance-button' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Chat Settings', 'chat-help'),
        initialOpen: false,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ComboboxControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Timezone', 'chat-help'),
          value: timeZone,
          options: filteredOptions,
          onChange: onFontSizeChange,
          onInputChange: onInputChange,
          help: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('When using the date and time from the user browser you can transform it to your current timezone (in case your user is in a different timezone)', 'chat-help')
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
          title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Monthday', 'chat-help'),
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Start Time', 'chat-help'),
            value: mondayStart,
            onChange: val => setAttributes({
              mondayStart: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('00:00', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('End Time', 'chat-help'),
            value: mondayEnd,
            onChange: val => setAttributes({
              mondayEnd: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('24:00', 'chat-help')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
          title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Tuesday', 'chat-help'),
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Start Time', 'chat-help'),
            value: tuesdayStart,
            onChange: val => setAttributes({
              tuesdayStart: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('00:00', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('End Time', 'chat-help'),
            value: tuesdayEnd,
            onChange: val => setAttributes({
              tuesdayEnd: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('24:00', 'chat-help')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
          title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Wednesday', 'chat-help'),
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Start Time', 'chat-help'),
            value: wednesdayStart,
            onChange: val => setAttributes({
              wednesdayStart: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('00:00', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('End Time', 'chat-help'),
            value: wednesdayEnd,
            onChange: val => setAttributes({
              wednesdayEnd: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('24:00', 'chat-help')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
          title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Thursday', 'chat-help'),
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Start Time', 'chat-help'),
            value: thursdayStart,
            onChange: val => setAttributes({
              thursdayStart: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('00:00', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('End Time', 'chat-help'),
            value: thursdayEnd,
            onChange: val => setAttributes({
              thursdayEnd: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('24:00', 'chat-help')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
          title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Friday', 'chat-help'),
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Start Time', 'chat-help'),
            value: fridayStart,
            onChange: val => setAttributes({
              fridayStart: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('00:00', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('End Time', 'chat-help'),
            value: fridayEnd,
            onChange: val => setAttributes({
              fridayEnd: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('24:00', 'chat-help')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
          title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Saturday', 'chat-help'),
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Start Time', 'chat-help'),
            value: saturdayStart,
            onChange: val => setAttributes({
              saturdayStart: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('00:00', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('End Time', 'chat-help'),
            value: saturdayEnd,
            onChange: val => setAttributes({
              saturdayEnd: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('24:00', 'chat-help')
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
          title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Sunday', 'chat-help'),
          initialOpen: false,
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Start Time', 'chat-help'),
            value: sundayStart,
            onChange: val => setAttributes({
              sundayStart: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('00:00', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(TextControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('End Time', 'chat-help'),
            value: sundayEnd,
            onChange: val => setAttributes({
              sundayEnd: val
            }),
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('24:00', 'chat-help')
          })]
        })]
      }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Button Style', 'chat-help'),
        initialOpen: false,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(SelectControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Visibility on', 'chat-help'),
          value: visibility,
          options: visibilityOn,
          onChange: newSize => setAttributes({
            visibility: newSize
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(SelectControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Button Size', 'chat-help'),
          value: buttonSize,
          options: buttonSizeOptions,
          onChange: newSize => setAttributes({
            buttonSize: newSize
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(SelectControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Border Radius', 'chat-help'),
          value: borderRadius,
          options: borderRadiusOptions,
          onChange: newSize => setAttributes({
            borderRadius: newSize
          })
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalSpacer, {
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalHeading, {
            children: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Padding', 'chat-help')
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(RangeControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Top', 'chat-help'),
            value: topPadding,
            onChange: paddings => {
              setAttributes({
                topPadding: paddings
              });
            },
            min: 5,
            max: 100
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(RangeControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Right', 'chat-help'),
            value: rightPadding,
            onChange: paddings => {
              setAttributes({
                rightPadding: paddings
              });
            },
            min: 5,
            max: 100
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(RangeControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Bottom', 'chat-help'),
            value: bottomPadding,
            onChange: paddings => {
              setAttributes({
                bottomPadding: paddings
              });
            },
            min: 5,
            max: 100
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(RangeControl, {
            label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Left', 'chat-help'),
            value: leftPadding,
            onChange: paddings => {
              setAttributes({
                leftPadding: paddings
              });
            },
            min: 5,
            max: 100
          })]
        })]
      })]
    }), buttonType === 'basic-button' && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.InspectorControls, {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.PanelBody, {
        title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Icon', 'chat-help'),
        initialOpen: false,
        children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ToggleControl, {
          label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Add Icon', 'chat-help'),
          checked: iconTarget,
          onChange: onIconTarget
        })
      })
    }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.BlockControls, {
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.AlignmentToolbar, {
        value: textAlignment,
        onChange: onChangeAlignment
      })
    }), buttonType === 'basic-button' ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)("div", {
      className: `button-wrapper whelp-editor ${textClasses}`,
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)("a", {
        ...(0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.useBlockProps)({
          className: `${basicBtn} ${buttonSize} ${borderRadius} ${visibility}`
        }),
        style: {
          '--padding': `${topPadding}px ${rightPadding}px ${bottomPadding}px ${leftPadding}px`
        },
        children: [iconTarget && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)("span", {
          className: "dashicons dashicons-whatsapp"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText, {
          onChange: onChangeText,
          value: text,
          placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('How can I help you?', 'chat-help'),
          tagName: "span",
          allowedFormats: []
        })]
      })
    }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)("div", {
      className: `button-wrapper whelp-editor ${textClasses}`,
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)("div", {
        ...(0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.useBlockProps)({
          className: `avatar-active ${classes} ${buttonSize} ${borderRadius} ${visibility}`
        }),
        style: {
          '--padding': `${topPadding}px ${rightPadding}px ${bottomPadding}px ${leftPadding}px`
        },
        "data-btnavailablety": `{ "monday":"${mondayStart}-${mondayEnd}", "tuesday":"${tuesdayStart}-${tuesdayEnd}", "wednesday":"${wednesdayStart}-${wednesdayEnd}", "thursday":"${thursdayStart}-${thursdayEnd}", "friday":"${fridayStart}-${fridayEnd}", "saturday":"${saturdayStart}-${saturdayEnd}", "sunday":"${sundayStart}-${sundayEnd}" }`,
        "data-timezone": timeZone,
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)("img", {
          src: imageUrl ? imageUrl : agentImage,
          alt: "agent"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsxs)("div", {
          className: "info-wrapper",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText, {
            onChange: advancedBtnInfo,
            value: info,
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Robert / Sales Support', 'chat-help'),
            tagName: "p",
            allowedFormats: [],
            className: "info"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText, {
            onChange: advancedBtnTitle,
            value: title,
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('How can I help you?', 'chat-help'),
            tagName: "p",
            allowedFormats: [],
            className: "title"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText, {
            onChange: advancedBtnOnlineBadge,
            value: online,
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('I am online', 'chat-help'),
            tagName: "p",
            allowedFormats: [],
            className: "online"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_6__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText, {
            onChange: advancedBtnOnlineBadge,
            value: offline,
            placeholder: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)("I'm not available", 'chat-help'),
            tagName: "p",
            allowedFormats: [],
            className: "offline"
          })]
        })]
      })
    })]
  });
}

/***/ }),

/***/ "./src/editor.scss":
/*!*************************!*\
  !*** ./src/editor.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/images/user.jpg":
/*!*****************************!*\
  !*** ./src/images/user.jpg ***!
  \*****************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";
module.exports = __webpack_require__.p + "images/user.65223f50.jpg";

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../block.json */ "./block.json");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./src/save.js");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");





(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_1__.name, {
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"]
});

/***/ }),

/***/ "./src/save.js":
/*!*********************!*\
  !*** ./src/save.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ save)
/* harmony export */ });
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! react/jsx-runtime */ "react/jsx-runtime");
/* harmony import */ var react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__);




const agentImage = __webpack_require__(/*! ./images/user.jpg */ "./src/images/user.jpg");
function save({
  attributes
}) {
  const {
    buttonSize,
    borderRadius,
    buttonType,
    text,
    info,
    title,
    online,
    offline,
    textAlignment,
    buttonLinkTarget,
    visibility,
    border,
    iconTarget,
    imageUrl,
    whatsappType,
    numberInput,
    groupInput,
    prefilledMessageInput,
    timeZone,
    mondayStart,
    mondayEnd,
    tuesdayStart,
    tuesdayEnd,
    wednesdayStart,
    wednesdayEnd,
    thursdayStart,
    thursdayEnd,
    fridayStart,
    fridayEnd,
    saturdayStart,
    saturdayEnd,
    sundayStart,
    sundayEnd,
    topPadding,
    rightPadding,
    bottomPadding,
    leftPadding
  } = attributes;
  const textClasses = classnames__WEBPACK_IMPORTED_MODULE_1___default()(`wHelpButtons-align-${textAlignment}`);
  const basicBtn = classnames__WEBPACK_IMPORTED_MODULE_1___default()(`chat_help_analytics wHelp-button-4 wHelp-btn-bg`);
  const classes = classnames__WEBPACK_IMPORTED_MODULE_1___default()(`wHelpButtons wHelp-button-4 wHelp-btn-bg`);
  return /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.Fragment, {
    children: buttonType === 'basic-button' ? /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
      className: `button-wrapper ${textClasses}`,
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("a", {
        ..._wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.useBlockProps.save({
          className: `${basicBtn} ${buttonSize} ${borderRadius} ${visibility} ${border}`
        }),
        style: {
          '--padding': `${topPadding}px ${rightPadding}px ${bottomPadding}px ${leftPadding}px`
        },
        ...(whatsappType === 'number' ? {
          'data-number': numberInput
        } : {
          'data-group': groupInput
        }),
        href: whatsappType === 'number' ? `https://wa.me/${numberInput}?text=${prefilledMessageInput}` : `${groupInput}`,
        rel: "noopener noreferrer",
        target: buttonLinkTarget ? '_blank' : '_self',
        children: [iconTarget && /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("span", {
          className: "dashicons dashicons-whatsapp"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText.Content, {
          tagName: "span",
          value: text
        })]
      })
    }) : /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("div", {
      className: `button-wrapper ${textClasses}`,
      children: /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
        ..._wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.useBlockProps.save({
          className: `${classes} ${buttonSize} ${borderRadius} ${visibility}`
        }),
        style: {
          '--padding': `${topPadding}px ${rightPadding}px ${bottomPadding}px ${leftPadding}px`
        },
        "data-btnavailablety": `{ "monday":"${mondayStart}-${mondayEnd}", "tuesday":"${tuesdayStart}-${tuesdayEnd}", "wednesday":"${wednesdayStart}-${wednesdayEnd}", "thursday":"${thursdayStart}-${thursdayEnd}", "friday":"${fridayStart}-${fridayEnd}", "saturday":"${saturdayStart}-${saturdayEnd}", "sunday":"${sundayStart}-${sundayEnd}" }`,
        "data-timezone": timeZone,
        ...(whatsappType === 'number' ? {
          'data-number': numberInput
        } : {
          'data-group': groupInput
        }),
        children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("img", {
          src: imageUrl ? imageUrl : agentImage,
          alt: "agent"
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsxs)("div", {
          className: "info-wrapper",
          children: [/*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText.Content, {
            value: info,
            tagName: "p",
            className: "info"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText.Content, {
            value: title,
            tagName: "p",
            className: "title"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText.Content, {
            value: online,
            tagName: "p",
            className: "online"
          }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_0__.RichText.Content, {
            value: offline,
            tagName: "p",
            className: "offline"
          })]
        }), /*#__PURE__*/(0,react_jsx_runtime__WEBPACK_IMPORTED_MODULE_3__.jsx)("a", {
          href: whatsappType === 'number' ? `https://wa.me/${numberInput}?text=${prefilledMessageInput}` : `${groupInput}`,
          rel: "noopener noreferrer",
          target: buttonLinkTarget ? '_blank' : '_self'
        })]
      })
    })
  });
}

/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "react/jsx-runtime":
/*!**********************************!*\
  !*** external "ReactJSXRuntime" ***!
  \**********************************/
/***/ ((module) => {

"use strict";
module.exports = window["ReactJSXRuntime"];

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
/******/ 	/* webpack/runtime/global */
/******/ 	(() => {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
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
/******/ 	/* webpack/runtime/publicPath */
/******/ 	(() => {
/******/ 		var scriptUrl;
/******/ 		if (__webpack_require__.g.importScripts) scriptUrl = __webpack_require__.g.location + "";
/******/ 		var document = __webpack_require__.g.document;
/******/ 		if (!scriptUrl && document) {
/******/ 			if (document.currentScript && document.currentScript.tagName.toUpperCase() === 'SCRIPT')
/******/ 				scriptUrl = document.currentScript.src;
/******/ 			if (!scriptUrl) {
/******/ 				var scripts = document.getElementsByTagName("script");
/******/ 				if(scripts.length) {
/******/ 					var i = scripts.length - 1;
/******/ 					while (i > -1 && (!scriptUrl || !/^http(s?):/.test(scriptUrl))) scriptUrl = scripts[i--].src;
/******/ 				}
/******/ 			}
/******/ 		}
/******/ 		// When supporting browsers where an automatic publicPath is not supported you must specify an output.publicPath manually via configuration
/******/ 		// or pass an empty string ("") and set the __webpack_public_path__ variable from your code to use your own logic.
/******/ 		if (!scriptUrl) throw new Error("Automatic publicPath is not supported in this browser");
/******/ 		scriptUrl = scriptUrl.replace(/^blob:/, "").replace(/#.*$/, "").replace(/\?.*$/, "").replace(/\/[^\/]+$/, "/");
/******/ 		__webpack_require__.p = scriptUrl;
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
/******/ 			"index": 0,
/******/ 			"./style-index": 0
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
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunkwhatsapp_button"] = globalThis["webpackChunkwhatsapp_button"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map