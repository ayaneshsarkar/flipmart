const { cssNumber } = require("jquery");
$(document).ready(function() {  
  $('.hamberger').click(function() {
    $('.wrapper').toggleClass('active');
  });

  $('#toggleMenu').click(function() {
    $('.dropdown_mobile').toggleClass('toggled');
  });

});

const mainInput = document.getElementById('productFile');
const mainButton = document.getElementById('productButton');
const mainText = document.getElementById('productText');

const filebox = document.getElementById('filebox');

mainButton.addEventListener('click', () => {
  mainInput.click();

  filebox.style.border = '1px solid #333';
  filebox.style.transition = 'all 0.3s linear';
});

mainInput.addEventListener('change', () => {
  if(mainInput.value) {
    mainText.innerHTML = mainInput.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
  } else {
    mainText.innerHTML = 'CHOOSE MAIN FILE [NO FILE CHOSEN YET]';
  }
});

const input = document.getElementById('productFiles');
const button = document.getElementById('productButtons');
const text = document.getElementById('productTexts');

const fileboxes = document.getElementById('fileboxes');

button.addEventListener('click', () => {
  input.click();

  fileboxes.style.border = '1px solid #333';
  fileboxes.style.transition = 'all 0.3s linear';
});

input.addEventListener('change', () => {

  const fileLength = input.files.length;
  let files = input.files;
  const fileList = [];

  if(fileLength) {
    Array.prototype.map.call(files, (file) => fileList.push(file));
    const fileNameList = fileList.map(file => file.name);

    text.innerHTML = fileNameList.join(', ');
  } else {
    text.innerHTML = 'Choose Files [No File(s) Chosen Yet]';
  }

});

// const focusedNumberInput =  document.getElementById('size').focus();

// if(focusedNumberInput) {
//   document.querySelectorAll('.product__inputbox_number').style.border = '1px solid $textColor !important';
// }