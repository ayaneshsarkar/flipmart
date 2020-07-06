import axios from 'axios';

const cartButton = document.querySelectorAll('.ajaxCart');
const cartDropdown = document.getElementById('cartDropdown');
const cartDropdownItem = document.querySelectorAll('.cartDropdownItem');
const cartDropdownItemAjax = document.querySelectorAll('.cartDropdownItemAjax');

const cartImageCross = document.querySelectorAll('.cartImage');

const csrfMeta = document.getElementsByTagName("META")[2].content;

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
                  <a href="#" class="cartImage">
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

  $('.cartImage').on('click', '.header-cart-item-img', cartDelete);

    
  async function cartDelete(e) {

    e.preventDefault();

    const cartId = this.getElementsByTagName('input')[0].value;

    const mainParent = this.parentElement.parentElement.parentElement;
    console.log(mainParent);

    const response = await axios.post('/cartdelete', {
      cartId: cartId
    });

    const data = response.data;

    console.log(data);
    document.getElementById('cartTotal').innerHTML = `Total: $ ${data.total}`;
    mainParent.style.opacity = '0';
    mainParent.style.height = '0';

  }

});



