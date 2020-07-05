const { cssNumber } = require("jquery");
$(document).ready(function() {  
  $('.hamberger').click(function() {
    $('.wrapper').toggleClass('active');
  });

  $('#toggleMenu').click(function() {
    $('.dropdown_mobile').toggleClass('toggled');
  });

  $('#categoryOptions').click(function() {
    $('#categoryOptions ~ .product__inputbox_option.optionbox').toggleClass('select');
    $('#categoryoptions > #categoryText').toggleClass('textColor');
    $('#categoryOptions > .icon > .select_arrow').toggleClass('rotateArrow');
  });

  $('#categoryOptions ~ .product__inputbox_option.optionbox').click(function() {
    $('#categoryOptions ~ .product__inputbox_option.optionbox').removeClass('select');
    $('#categoryOptions > .icon > .select_arrow').toggleClass('rotateArrow');
    var selectedText = $(this).text();
    $('#categoryText').text(selectedText);
    $('#categoryInput').val(selectedText);
  });



  $('#typeOptions').click(function() {
    $('#typeOptions ~ .product__inputbox_option.optionbox').toggleClass('select');
    $('#typeoptions > #typeText').toggleClass('textColor');
    $('#typeOptions > .icon > .select_arrow').toggleClass('rotateArrow');
  });

  $('#typeOptions ~ .product__inputbox_option.optionbox').click(function() {
    $('#typeOptions ~ .product__inputbox_option.optionbox').removeClass('select');
    $('#typeOptions > .icon > .select_arrow').toggleClass('rotateArrow');
    var selectedText = $(this).text();
    $('#typeText').text(selectedText);
    $('#typeInput').val(selectedText);
  });



  $('#brandOptions').click(function() {
    $('#brandOptions ~ .product__inputbox_option.optionbox').toggleClass('select');
    $('#brandoptions > #brandText').toggleClass('textColor');
    $('#brandOptions > .icon > .select_arrow').toggleClass('rotateArrow');
  });

  $('#brandOptions ~ .product__inputbox_option.optionbox').click(function() {
    $('#brandOptions ~ .product__inputbox_option.optionbox').removeClass('select');
    $('#brandOptions > .icon > .select_arrow').toggleClass('rotateArrow');
    var selectedText = $(this).text();
    $('#brandText').text(selectedText);
    $('#brandInput').val(selectedText);
  });
  

  if(document.getElementById('categoryText')) {
    const categoryText = document.getElementById('categoryText').innerHTML;
    if(!categoryText.match(/Choose.*/)) {
      $('#categoryInput').val($('#categoryText').text());
    }
  }

  if(document.getElementById('typeText')) {
    const typeText = document.getElementById('typeText').innerHTML;
    if(!typeText.match(/Choose.*/)) {
      $('#typeInput').val($('#typeText').text());
    }
  }

  if(document.getElementById('brandText')) {
    const brandText = document.getElementById('brandText').innerHTML;
    if(!brandText.match(/Choose.*/)) {
      $('#brandInput').val($('#brandText').text());
    }
  }

});

const mainInput = document.getElementById('productFile');
const mainButton = document.getElementById('productButton');
const mainText = document.getElementById('productText');

const filebox = document.getElementById('filebox');

if(mainButton) {
  mainButton.addEventListener('click', () => {
    mainInput.click();
  
    filebox.style.border = '1px solid #333';
    filebox.style.transition = 'all 0.3s linear';
  });
}

if(mainInput) {
  mainInput.addEventListener('change', () => {
    if(mainInput.value) {
      mainText.innerHTML = mainInput.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/)[1];
    } else {
      mainText.innerHTML = 'CHOOSE MAIN FILE [NO FILE CHOSEN YET]';
    }
  });
}

const input = document.getElementById('productFiles');
const button = document.getElementById('productButtons');
const text = document.getElementById('productTexts');

const fileboxes = document.getElementById('fileboxes');

if(button) {
  button.addEventListener('click', () => {
    input.click();
  
    fileboxes.style.border = '1px solid #333';
    fileboxes.style.transition = 'all 0.3s linear';
  });
}

if(input) {
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
}

// const focusedNumberInput =  document.getElementById('size').focus();

// if(focusedNumberInput) {
//   document.querySelectorAll('.product__inputbox_number').style.border = '1px solid $textColor !important';
// }

if(document.getElementById('adminCross')) {
  document.getElementById('adminCross').addEventListener('click', function() {
    document.querySelector('.adminSession').style.display = 'none';
  });
}





