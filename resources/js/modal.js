const { cssNumber } = require("jquery");

// Get Modal Element
var modal = document.getElementById('modal');

// Get Modal Button
var modalBtnSignUp = document.getElementById('modalSignUp');
var modalBtnSignIn = document.getElementById('modalSignIn');

// Get Close Button
var closeBtn = document.getElementsByClassName('closeBtn')[0];

// Redirect Login Element
var signInModal = document.getElementsByClassName('signInModal')[0];

// Redirect Register Element
var signUpModal = document.getElementsByClassName('registerModal')[0];

// Name and Confirm Password Inputs
var nameInput = document.getElementById('name');
var confirmPasswordInput = document.getElementById('confirm_password');


//Name HTML
var name = `<div id="name" class="bo4 of-hidden m-b-30 size15 m-b-5">
<input type="text" class="sizefull s-text-7 p-r-20 p-l-20 modal-input{{ ($errors->has('name')) ? '-danger' : '' }}" 
placeholder="Name" name="name">
</div>`;

//Confirm Password HTML
var confirmPassword = `
<div id="confirm_password" class="bo4 of-hidden size15 m-b-30 modal-input-body">
<input type="password" class="sizefull s-text-7 p-r-20 p-l-20 modal-input" 
placeholder="Confirm Password" name="confirm_password">
</div>
`;

// Verification
var nameInputVer = true;

// Listen For Click
modalBtnSignUp.addEventListener('click', openModal);
modalBtnSignIn.addEventListener('click', openModalSignIn);

// Listen For Close
closeBtn.addEventListener('click', closeModal);

// Listen For Click Outside
window.addEventListener('click', clickOutSide);


// SignUp Click
function openModal() {
  modal.style.display = 'block';
  document.getElementById("modalTitle").innerHTML = "SIGN UP";

  if(nameInputVer == false) {
    nameInputVer = true;
    document.getElementById('modalTitle').insertAdjacentHTML("afterend", name);
    document.getElementById('password').insertAdjacentHTML("afterend", confirmPassword);
  }

  document.getElementById('modalButton').innerHTML = "SIGN UP";
  console.log(nameInputVer);
}

// Register Redirect
if(signUpModal) {
  modal.style.display = 'block';
  document.getElementById("modalTitle").innerHTML = "SIGN UP";

  if(nameInputVer == false) {
    nameInputVer = true;
    document.getElementById('modalTitle').insertAdjacentHTML("afterend", name);
    document.getElementById('password').insertAdjacentHTML("afterend", confirmPassword);
  }

  document.getElementById('modalButton').innerHTML = "SIGN UP";
}


// Login Redirect
if (signInModal) {
  modal.style.display = 'block';

  document.getElementById("modalTitle").innerHTML = "SIGN IN";

  if(nameInputVer == true) {
    $('#name').remove();
    $('#confirm_password').remove();
  }
  
  nameInputVer = false;

  document.getElementById('modalButton').innerHTML = "SIGN IN";
}



//SignInClick
function openModalSignIn() {
  modal.style.display = 'block';

  document.getElementById("modalTitle").innerHTML = "SIGN IN";

  if(nameInputVer == true) {
    $('#name').remove();
    $('#confirm_password').remove();
  }
  
  nameInputVer = false;

  document.getElementById('modalButton').innerHTML = "SIGN IN";
}


// CloseIcon Click
function closeModal() {
  modal.style.display = 'none';
  if (signInModal) {
    modal.classList.remove('signInModal');
  }
  if(signUpModal) {
    modal.classList.remove('registerModal');
  }
}

// Outsiewindow Click
function clickOutSide(e) {
  if(e.target == modal) {
    modal.style.display = 'none';
    if (signInModal) {
      modal.classList.remove('signInModal');
    }
    if(signUpModal) {
      modal.classList.remove('registerModal');
    }
  }  
}
