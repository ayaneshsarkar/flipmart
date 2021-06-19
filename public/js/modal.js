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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/modal.js":
/*!*******************************!*\
  !*** ./resources/js/modal.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

// Get Modal Element
var modalSignUp = document.getElementById('modalSignUp');
var modalSignIn = document.getElementById('modalSignIn'); // Get Modal Button

var modalBtnSignUp = document.getElementById('modalBtnSignUp');
var modalBtnSignIn = document.getElementById('modalBtnSignIn');
var mobileModalBtnSignUp = document.getElementById('modalBtnSignUpMb');
var mobileModalBtnSignIn = document.getElementById('modalBtnSignInMb'); // Get Close Button

var closeBtn = document.getElementsByClassName('closeBtn')[0];
var closeBtnSignUp = document.getElementsByClassName('closeBtnSignUp')[0];
var closeBtnSignIn = document.getElementsByClassName('closeBtnSignIn')[0]; // Redirect Login Element

var signInModal = document.getElementsByClassName('signInModal')[0]; // Redirect Register Element

var signUpModal = document.getElementsByClassName('registerModal')[0]; // Listen For Click

if (modalBtnSignUp) {
  modalBtnSignUp.addEventListener('click', openModal);
}

if (modalBtnSignIn) {
  modalBtnSignIn.addEventListener('click', openModalSignIn);
}

if (mobileModalBtnSignUp) {
  mobileModalBtnSignUp.addEventListener('click', openModal);
}

if (mobileModalBtnSignIn) {
  mobileModalBtnSignIn.addEventListener('click', openModalSignIn);
} // Listen For Click Outside


window.addEventListener('click', clickOutSide); // SignUp Click

function openModal() {
  modalSignUp.style.display = 'block';
} // Register Redirect


if (signUpModal) {
  modalSignUp.style.display = 'block';
} // Login Redirect


if (signInModal) {
  modalSignIn.style.display = 'block';
} //SignInClick


function openModalSignIn() {
  modalSignIn.style.display = 'block';
} // Close Button


$('.closeBtn').click(function () {
  $('#modalSignUp').hide();
  $('#modalSignIn').hide();

  if (signUpModal) {
    modalSignUp.classList.remove('registerModal');
  }

  if (signInModal) {
    modalSignIn.classList.remove('signInModal');
  }
}); // Outsiewindow Click

function clickOutSide(e) {
  if (e.target == modalSignUp) {
    modalSignUp.style.display = 'none';

    if (signUpModal) {
      modalSignUp.classList.remove('registerModal');
    }
  }

  if (e.target == modalSignIn) {
    modalSignIn.style.display = 'none';

    if (signInModal) {
      modalSignIn.classList.remove('signInModal');
    }
  }
}

var cross = document.getElementById('contactCross');
var contact = document.getElementById('contactSuccess');

if (cross) {
  contactCross.addEventListener('click', closeDisplay);
}

function closeDisplay() {
  contact.style.display = 'none';
}

var categoryAll = document.getElementById('categoryAll');
var categoryWomen = document.getElementById('categoryWomen');
var categoryMen = document.getElementById('categoryMen');
var categoryKids = document.getElementById('categoryKids');
var categoryForm = document.getElementById('categoryForm');
var categoryResult = document.getElementById('categoryResult');
categoryAll.addEventListener('click', function () {
  categoryResult.value = 'all';
  categoryForm.submit();
});
categoryWomen.addEventListener('click', function () {
  categoryResult.value = 'women';
  categoryForm.submit();
});
categoryMen.addEventListener('click', function () {
  categoryResult.value = 'men';
  categoryForm.submit();
});
categoryKids.addEventListener('click', function () {
  categoryResult.value = 'kids';
  categoryForm.submit();
});
var account = document.getElementById('account');
var accountDropdown = document.querySelector('.header-account-dropdown');
var singleProductSlug = document.getElementById('singleProductSlug');

if (account && accountDropdown) {
  accountDropdown.addEventListener('click', function () {
    accountDropdown.classList.toggle('show-header-account-dropdown');
  });
}

if (singleProductSlug) {
  account.addEventListener('click', function () {
    accountDropdown.classList.toggle('show-header-account-dropdown');
  });
}

var logoutText = document.getElementById('logoutText');
var logoutForm = document.getElementById('logoutForm');

if (logoutText && logoutForm) {
  logoutText.addEventListener('click', function () {
    logoutForm.submit();
  });
}

if (document.querySelector('.modalCross')) {
  document.querySelector('.modalCross').addEventListener('click', function () {
    document.querySelector('.modalSession').style.display = 'none';
  });
}

/***/ }),

/***/ 5:
/*!*************************************!*\
  !*** multi ./resources/js/modal.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Apps\xampp\htdocs\flipmart\resources\js\modal.js */"./resources/js/modal.js");


/***/ })

/******/ });