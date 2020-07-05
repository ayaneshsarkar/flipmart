const cartButton = document.querySelectorAll('.ajaxCart');
const cartDropdown = document.getElementById('cartDropdown');
const cartDropdownItem = document.querySelectorAll('.cartDropdownItem');
const cartDropdownItemAjax = document.querySelectorAll('.cartDropdownItemAjax');

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
        console.log(product);

        if(cartDropdown) {
          cartDropdownItem.forEach(item => {
            $('.cartDropdownItem').remove();
          });

          product.forEach(prod => {

            cartDropdown.insertAdjacentHTML("afterbegin", 
              `
              <ul class="header-cart-wrapitem cartDropdownItem">
                <li class="header-cart-item">
                  <div class="header-cart-item-img">
                    <img src="images/item-cart-01.jpg" alt="IMG">
                  </div>
            
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

