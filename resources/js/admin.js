import swal from 'sweetalert';
import { deleteProductImage } from './components/product';

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

if(mainButton) {
  mainButton.addEventListener('click', () => {
    mainInput.click();
  
    filebox.style.border = '1px solid #212121';
    filebox.style.transition = 'all 0.3s linear';
  });
}

if(mainInput) {
  mainInput.addEventListener('change', () => {
    if(mainInput.value) {
      // mainText.innerHTML = mainInput.value.match(/[\/\\]([\w\d\s\.\-\(\)]+)$/);
      mainText.innerHTML = mainInput.files[0]['name'];
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

if(document.getElementById('adminCross')) {
  document.getElementById('adminCross').addEventListener('click', function() {
    document.querySelector('.adminSession').style.display = 'none';
  });
}

if(document.getElementById('orderSession')) {
  document.getElementById('orderSessionCross').addEventListener('click', function() {
    this.parentElement.parentElement.style.display = 'none';
    
  })
}

const productImageCross = document.querySelectorAll('.productImageCross');

if(productImageCross) {
  productImageCross.forEach(cross => {
    cross.addEventListener('click', async () => {
      const productId = cross.getAttribute('data-product') || null;
      const imageId = cross.getAttribute('data-image') || null;
      const id = document.getElementById(imageId);

      const status = await deleteProductImage(productId, imageId);

      if(status === 200 && id) {
        id.remove();
      }
    });
  })
}

const alerts = document.querySelectorAll('.alertswal');

if(alerts) {
  alerts.forEach(alert => {
    alert.addEventListener('click', (e) => {
      e.preventDefault();

      swal({
        title: "Are you sure?",
        icon: "warning",
        buttons: ['Cancel', 'Yes'],
      })
      .then((willDelete) => {
        if (willDelete) {
          const link = alert.getAttribute('href');
          window.location.href = link;
        }
      });
    })
  });
}