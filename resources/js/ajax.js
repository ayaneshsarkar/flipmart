const cartButton = document.getElementById('ajaxCart');
const productSlug = document.getElementById('productSlug');


cartButton.addEventListener('click', function() {

  const xmlHttp = new XMLHttpRequest();
  xmlHttp.onreadystatechange = function() {
    if(this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  }

  xmlHttp.open("POST", "/cart");
  xmlHttp.send(productSlug);

});