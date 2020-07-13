import axios from 'axios';

const cartButton = document.querySelectorAll('.ajaxCart');
const cartDropdown = document.getElementById('cartDropdown');
const cartDropdownItem = document.querySelectorAll('.cartDropdownItem');

const cartImageCross = document.querySelectorAll('.cartImage');

const singleCartImageCross = document.querySelectorAll('.singleCartImage');

const csrfMeta = document.getElementsByTagName("META")[2].content;

function myFunction() {
  console.log('yes');
}

cartButton.forEach(cartButton => {

  cartButton.addEventListener('click', function(e){

    e.preventDefault();
  
    const productSlug = this.nextElementSibling.value;
    
    $.ajax({

      headers: {
        'X-CSRF-TOKEN': csrfMeta
      },

      type: 'post',
      data: {
        productSlug: productSlug
      },
      dataType: 'json',
      url: `/cart`,

      success: function(data) {
        const product = data.product;

        document.getElementById('cartTotal').innerHTML = `Total: $ ${data.total}`;
        //console.log(product, data.url);

        if(cartDropdown) {
          cartDropdownItem.forEach(item => {
            $('.cartDropdownItem').remove();
          });

          product.forEach(prod => {

            cartDropdown.insertAdjacentHTML("afterbegin", 
              `
              <ul class="header-cart-wrapitem cartDropdownItem">
                <li class="header-cart-item">
                  <a href="#" onclick="javascript:cartDelete(this); return false;" class="cartImage">
                    <div class="header-cart-item-img">
                      <img src="${data.url}/storage/myimages/${prod.name}${prod.userId}/${prod.main_image}" alt="${prod.title}">
                      <input type="hidden" name="cartId" id="cartId" value="${prod.cartId}">
                    </div>
                  </a>

                  <div class="header-cart-item-txt">
                    <a href="#" class="header-cart-item-name">
                      ${prod.title}
                    </a>
            
                    <span class="header-cart-item-info">
                      ${prod.quantity} x ${prod.cartPrice}
                    </span>
                  </div>
                </li>
              </ul>
              
              `
            );

          });

        }
      }

    });

  });

});

cartImageCross.forEach(cartImage => {

  $(cartImage).on("click", async function(e) {

    e.preventDefault();

    const cartId = this.getElementsByTagName('input')[0].value;

    const mainParent = this.parentElement.parentElement;

    const response = await axios.post('/cartdelete', {
      cartId: cartId
    });

    const data = response.data;

    document.getElementById('cartTotal').innerHTML = `Total: $ ${data.total}`;
    mainParent.style.opacity = '0';
    mainParent.style.height = '0';

  });

});

if(singleCartImageCross) {

  singleCartImageCross.forEach(singleImage => {

    singleImage.addEventListener('click', async function(e) {
  
      e.preventDefault();
  
      const cartId = this.getElementsByTagName('input')[0].value;
  
      const mainParent = this.parentElement.parentElement;
  
      const response = await axios.post('/cartdelete', {
        cartId: cartId
      });
  
      const data = response.data;
  
      document.getElementById('singleCartTotal').textContent = `$${data.total}.00`;
  
      

      const quantityInput =  this.parentElement.nextElementSibling.nextElementSibling.nextElementSibling.firstElementChild.getElementsByTagName('input')[0];


      quantityInput.remove();

      mainParent.remove();
  
      if(data.count == 0) {
        document.getElementById('updateButton').style.display = 'none';
        document.getElementById('cartTable').style.display = 'none';
        document.getElementById('noProduct').style.display = 'block';
        document.getElementById('checkoutButton').style.display = 'none';
      }
  
    });
  
  });

}






if(document.getElementById('singleCartButton')) {
  const singleCartButton = document.getElementById('singleCartButton')

  singleCartButton.addEventListener("click", cartFunction);

  async function cartFunction(e) {
    e.preventDefault();

    const singleProductSlug = document.getElementById('singleProductSlug').value;
    const singleProductQuantity = document.getElementById('singleProductQuantity').value;
    const singleProductSize = document.getElementById('singleProductSize').value;

    const productData = {
      productSlug: singleProductSlug,
      productQuantity: singleProductQuantity,
      productSize: singleProductSize
    };

    const response = await axios.post('/mycart', productData);
    const data = response.data;

    console.log(data.url);

    window.location.href = data.url;

  }
}

