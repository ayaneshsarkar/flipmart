const { cssNumber } = require("jquery");

// Get Modal Element
var modalSignUp = document.getElementById('modalSignUp');
var modalSignIn = document.getElementById('modalSignIn');

// Get Modal Button
var modalBtnSignUp = document.getElementById('modalBtnSignUp');
var modalBtnSignIn = document.getElementById('modalBtnSignIn');

// Get Close Button
var closeBtn = document.getElementsByClassName('closeBtn')[0];
var closeBtnSignUp = document.getElementsByClassName('closeBtnSignUp')[0];
var closeBtnSignIn = document.getElementsByClassName('closeBtnSignIn')[0];

// Redirect Login Element
var signInModal = document.getElementsByClassName('signInModal')[0];

// Redirect Register Element
var signUpModal = document.getElementsByClassName('registerModal')[0];


// Listen For Click
if(modalBtnSignUp) {
  modalBtnSignUp.addEventListener('click', openModal);
}

if(modalBtnSignIn) {
  modalBtnSignIn.addEventListener('click', openModalSignIn);
}

// Listen For Close
//closeBtn.addEventListener('click', closeModal);
// closeBtnSignUp.addEventListener('click', closeBtnSignUp);
// closeBtnSignIn.addEventListener('click', closeBtnSignIn);

// Listen For Click Outside
window.addEventListener('click', clickOutSide);


// SignUp Click
function openModal() {
  modalSignUp.style.display = 'block';
}

// Register Redirect
if(signUpModal) {
  modalSignUp.style.display = 'block';
}


// Login Redirect
if (signInModal) {
  modalSignIn.style.display = 'block';
}



//SignInClick
function openModalSignIn() {
  modalSignIn.style.display = 'block';
}

// Close Button

$('.closeBtn').click(function() {
  $('#modalSignUp').hide();
  $('#modalSignIn').hide();
  if(signUpModal) {
    modalSignUp.classList.remove('registerModal');
  }
  if (signInModal) {
    modalSignIn.classList.remove('signInModal');
  }
});


// Outsiewindow Click
function clickOutSide(e) {
  if(e.target == modalSignUp) {
    modalSignUp.style.display = 'none';
    if(signUpModal) {
      modalSignUp.classList.remove('registerModal');
    }
  }

  if(e.target == modalSignIn) {
    modalSignIn.style.display = 'none';
    if (signInModal) {
      modalSignIn.classList.remove('signInModal');
    }
  }
}


const cross = document.getElementById('contactCross');
const contact = document.getElementById('contactSuccess');

if(cross) {
    contactCross.addEventListener('click', closeDisplay);
}

function closeDisplay() {
  contact.style.display = 'none';
}

const categoryAll = document.getElementById('categoryAll');
const categoryWomen = document.getElementById('categoryWomen');
const categoryMen = document.getElementById('categoryMen');
const categoryKids = document.getElementById('categoryKids');

const categoryForm = document.getElementById('categoryForm');
const categoryResult = document.getElementById('categoryResult');

categoryAll.addEventListener('click', function() {
  categoryResult.value = 'all';
  categoryForm.submit();
});

categoryWomen.addEventListener('click', function() {
  categoryResult.value = 'women';
  categoryForm.submit();
});

categoryMen.addEventListener('click', function() {
  categoryResult.value = 'men';
  categoryForm.submit();
});

categoryKids.addEventListener('click', function() {
  categoryResult.value = 'kids';
  categoryForm.submit();
});


const account = document.getElementById('account');
const accountDropdown = document.querySelector('.header-account-dropdown');

if(account && accountDropdown) {
  account.addEventListener('click', function() {
    accountDropdown.classList.toggle('show-header-account-dropdown');
  });
}


const logoutText = document.getElementById('logoutText');
const logoutForm = document.getElementById('logoutForm');

if(logoutText && logoutForm) {
  logoutText.addEventListener('click', function() {
    logoutForm.submit();
  });
}