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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/main.js":
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($) {
  "use strict";
  /*[ Load page ]
  ===========================================================*/

  $(".animsition").animsition({
    inClass: 'fade-in',
    outClass: 'fade-out',
    inDuration: 1500,
    outDuration: 800,
    linkElement: '.animsition-link',
    loading: true,
    loadingParentElement: 'html',
    loadingClass: 'animsition-loading-1',
    loadingInner: '<div data-loader="ball-scale"></div>',
    timeout: false,
    timeoutCountdown: 5000,
    onLoadEvent: true,
    browser: ['animation-duration', '-webkit-animation-duration'],
    overlay: false,
    overlayClass: 'animsition-overlay-slide',
    overlayParentElement: 'html',
    transition: function transition(url) {
      window.location.href = url;
    }
  });
  /*[ Back to top ]
  ===========================================================*/

  var windowH = $(window).height() / 2;
  $(window).on('scroll', function () {
    if ($(this).scrollTop() > windowH) {
      $("#myBtn").css('display', 'flex');
    } else {
      $("#myBtn").css('display', 'none');
    }
  });
  $('#myBtn').on("click", function () {
    $('html, body').animate({
      scrollTop: 0
    }, 300);
  });
  /*[ Show header dropdown ]
  ===========================================================*/

  $('.js-show-header-dropdown').on('click', function () {
    $(this).parent().find('.header-dropdown');
  });
  var menu = $('.js-show-header-dropdown');
  var sub_menu_is_showed = -1;

  for (var i = 0; i < menu.length; i++) {
    $(menu[i]).on('click', function () {
      if (jQuery.inArray(this, menu) == sub_menu_is_showed) {
        $(this).parent().find('.header-dropdown').toggleClass('show-header-dropdown');
        sub_menu_is_showed = -1;
      } else {
        for (var i = 0; i < menu.length; i++) {
          $(menu[i]).parent().find('.header-dropdown').removeClass("show-header-dropdown");
        }

        $(this).parent().find('.header-dropdown').toggleClass('show-header-dropdown');
        sub_menu_is_showed = jQuery.inArray(this, menu);
      }
    });
  }

  $(".js-show-header-dropdown, .header-dropdown").click(function (event) {
    event.stopPropagation();
  });
  $(window).on("click", function () {
    for (var i = 0; i < menu.length; i++) {
      $(menu[i]).parent().find('.header-dropdown').removeClass("show-header-dropdown");
    }

    sub_menu_is_showed = -1;
  });
  /*[ Fixed Header ]
  ===========================================================*/

  var posWrapHeader = $('.topbar').height();
  var header = $('.container-menu-header');
  $(window).on('scroll', function () {
    if ($(this).scrollTop() >= posWrapHeader) {
      $('.header1').addClass('fixed-header');
      $(header).css('top', -posWrapHeader);
    } else {
      var x = -$(this).scrollTop();
      $(header).css('top', x);
      $('.header1').removeClass('fixed-header');
    }

    if ($(this).scrollTop() >= 200 && $(window).width() > 992) {
      $('.fixed-header2').addClass('show-fixed-header2');
      $('.header2').css('visibility', 'hidden');
      $('.header2').find('.header-dropdown').removeClass("show-header-dropdown");
    } else {
      $('.fixed-header2').removeClass('show-fixed-header2');
      $('.header2').css('visibility', 'visible');
      $('.fixed-header2').find('.header-dropdown').removeClass("show-header-dropdown");
    }
  });
  /*[ Show menu mobile ]
  ===========================================================*/

  $('.btn-show-menu-mobile').on('click', function () {
    $(this).toggleClass('is-active');
    $('.wrap-side-menu').slideToggle();
  });
  var arrowMainMenu = $('.arrow-main-menu');

  for (var i = 0; i < arrowMainMenu.length; i++) {
    $(arrowMainMenu[i]).on('click', function () {
      $(this).parent().find('.sub-menu').slideToggle();
      $(this).toggleClass('turn-arrow');
    });
  }

  $(window).resize(function () {
    if ($(window).width() >= 992) {
      if ($('.wrap-side-menu').css('display') == 'block') {
        $('.wrap-side-menu').css('display', 'none');
        $('.btn-show-menu-mobile').toggleClass('is-active');
      }

      if ($('.sub-menu').css('display') == 'block') {
        $('.sub-menu').css('display', 'none');
        $('.arrow-main-menu').removeClass('turn-arrow');
      }
    }
  });
  /*[ remove top noti ]
  ===========================================================*/

  $('.btn-romove-top-noti').on('click', function () {
    $(this).parent().remove();
  });
  /*[ Block2 button wishlist ]
  ===========================================================*/

  $('.block2-btn-addwishlist').on('click', function (e) {
    e.preventDefault();
    $(this).addClass('block2-btn-towishlist');
    $(this).removeClass('block2-btn-addwishlist');
    $(this).off('click');
  });
  /*[ +/- num product ]
  ===========================================================*/

  $('.btn-num-product-down').on('click', function (e) {
    e.preventDefault();
    var numProduct = Number($(this).next().val());
    if (numProduct > 1) $(this).next().val(numProduct - 1);
  });
  $('.btn-num-product-up').on('click', function (e) {
    e.preventDefault();
    var numProduct = Number($(this).prev().val());
    $(this).prev().val(numProduct + 1);
  });
  /*[ Show content Product detail ]
  ===========================================================*/

  $('.active-dropdown-content .js-toggle-dropdown-content').toggleClass('show-dropdown-content');
  $('.active-dropdown-content .dropdown-content').slideToggle('fast');
  $('.js-toggle-dropdown-content').on('click', function () {
    $(this).toggleClass('show-dropdown-content');
    $(this).parent().find('.dropdown-content').slideToggle('fast');
  });
  /*[ Play video 01]
  ===========================================================*/

  var srcOld = $('.video-mo-01').children('iframe').attr('src');
  $('[data-target="#modal-video-01"]').on('click', function () {
    $('.video-mo-01').children('iframe')[0].src += "&autoplay=1";
    setTimeout(function () {
      $('.video-mo-01').css('opacity', '1');
    }, 300);
  });
  $('[data-dismiss="modal"]').on('click', function () {
    $('.video-mo-01').children('iframe')[0].src = srcOld;
    $('.video-mo-01').css('opacity', '0');
  });
})(jQuery);

/***/ }),

/***/ 1:
/*!************************************!*\
  !*** multi ./resources/js/main.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/flipmart/resources/js/main.js */"./resources/js/main.js");


/***/ })

/******/ });