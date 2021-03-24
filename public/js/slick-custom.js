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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/slick-custom.js":
/*!**************************************!*\
  !*** ./resources/js/slick-custom.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  // USE STRICT
  "use strict";
  /*[ Slick1 ]
  ===========================================================*/

  var itemSlick1 = $('.slick1').find('.item-slick1');
  var action1 = [];
  var action2 = [];
  var action3 = [];
  var cap1Slide1 = [];
  var cap2Slide1 = [];
  var btnSlide1 = [];

  for (var i = 0; i < itemSlick1.length; i++) {
    cap1Slide1[i] = $(itemSlick1[i]).find('.caption1-slide1');
    cap2Slide1[i] = $(itemSlick1[i]).find('.caption2-slide1');
    btnSlide1[i] = $(itemSlick1[i]).find('.wrap-btn-slide1');
  }

  $('.slick1').on('init', function () {
    action1[0] = setTimeout(function () {
      $(cap1Slide1[0]).addClass($(cap1Slide1[0]).data('appear') + ' visible-true');
    }, 200);
    action2[0] = setTimeout(function () {
      $(cap2Slide1[0]).addClass($(cap2Slide1[0]).data('appear') + ' visible-true');
    }, 1000);
    action3[0] = setTimeout(function () {
      $(btnSlide1[0]).addClass($(btnSlide1)[0].data('appear') + ' visible-true');
    }, 1800);
  });
  $('.slick1').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    dots: false,
    appendDots: $('.wrap-slick1-dots'),
    dotsClass: 'slick1-dots',
    infinite: true,
    autoplay: true,
    autoplaySpeed: 6000,
    arrows: true,
    appendArrows: $('.wrap-slick1'),
    prevArrow: '<button class="arrow-slick1 prev-slick1"><i class="fa  fa-angle-left" aria-hidden="true"></i></button>',
    nextArrow: '<button class="arrow-slick1 next-slick1"><i class="fa  fa-angle-right" aria-hidden="true"></i></button>'
  });
  $('.slick1').on('afterChange', function (event, slick, currentSlide) {
    for (var i = 0; i < itemSlick1.length; i++) {
      clearTimeout(action1[i]);
      clearTimeout(action2[i]);
      clearTimeout(action3[i]);
      $(cap1Slide1[i]).removeClass($(cap1Slide1[i]).data('appear') + ' visible-true');
      $(cap2Slide1[i]).removeClass($(cap2Slide1[i]).data('appear') + ' visible-true');
      $(btnSlide1[i]).removeClass($(btnSlide1[i]).data('appear') + ' visible-true');
    }

    action1[currentSlide] = setTimeout(function () {
      $(cap1Slide1[currentSlide]).addClass($(cap1Slide1[currentSlide]).data('appear') + ' visible-true');
    }, 200);
    action2[currentSlide] = setTimeout(function () {
      $(cap2Slide1[currentSlide]).addClass($(cap2Slide1[currentSlide]).data('appear') + ' visible-true');
    }, 1000);
    action3[currentSlide] = setTimeout(function () {
      $(btnSlide1[currentSlide]).addClass($(btnSlide1)[currentSlide].data('appear') + ' visible-true');
    }, 1800);
  });
  /*[ Slick2 ]
  ===========================================================*/

  $('.slick2').slick({
    slidesToShow: 4,
    slidesToScroll: 4,
    infinite: true,
    autoplay: false,
    autoplaySpeed: 6000,
    arrows: true,
    appendArrows: $('.wrap-slick2'),
    prevArrow: '<button class="arrow-slick2 prev-slick2"><i class="fa  fa-angle-left" aria-hidden="true"></i></button>',
    nextArrow: '<button class="arrow-slick2 next-slick2"><i class="fa  fa-angle-right" aria-hidden="true"></i></button>',
    responsive: [{
      breakpoint: 1200,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4
      }
    }, {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3
      }
    }, {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }, {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  });
  /*[ Slick3 ]
  ===========================================================*/

  $('.slick3').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    fade: true,
    dots: true,
    appendDots: $('.wrap-slick3-dots'),
    dotsClass: 'slick3-dots',
    infinite: true,
    autoplay: false,
    autoplaySpeed: 6000,
    arrows: false,
    customPaging: function customPaging(slick, index) {
      var portrait = $(slick.$slides[index]).data('thumb');
      return '<img src=" ' + portrait + ' "/><div class="slick3-dot-overlay"></div>';
    }
  });
})(jQuery);

/***/ }),

/***/ 3:
/*!********************************************!*\
  !*** multi ./resources/js/slick-custom.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Apps\xampp\htdocs\flipmart\resources\js\slick-custom.js */"./resources/js/slick-custom.js");


/***/ })

/******/ });