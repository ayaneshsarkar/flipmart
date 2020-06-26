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

mainButton.addEventListener('click', () => {
  mainInput.click();
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

button.addEventListener('click', () => {
  input.click();
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