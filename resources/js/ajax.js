import axios from 'axios';
import swal from 'sweetalert';
import { manageMultipleCart, deleteCart, formatNumber } from './components/product';
import { chargeApplication } from './components/order';

const addToCart = document.getElementById('addToCart');

const cartResults = document.getElementById('cartResults');
const cartResultsMb = document.getElementById('cartResultsMb');

const cartCount = document.getElementById('cartCount');
const cartCountMb = document.getElementById('cartCountMb');

const cartTotal = document.getElementById('cartTotal');
const cartTotalMb = document.getElementById('cartTotalMb');

const cartDropdown = document.getElementById('cartDropdown');

const cartDropdownMb = document.getElementById('cartDropdownMb');

const cartMinus = document.querySelectorAll('.cart-minus');
const cartPlus = document.querySelectorAll('.cart-plus');
const mainCartImage = document.querySelectorAll('.singleCartImage');
const cartTable = document.getElementById('cartTable');
const checkoutButton = document.getElementById('checkoutOrderButton');

// Update Cart
if(addToCart) {
  addToCart.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    // Swal Notification
    swal({
      icon: 'success',
      title: 'Add to the Cart!',
      text: `${addToCart.getAttribute('data-title')} has been added to the cart.`
    })

    try {
      // Assigning the FormData
      const formData = new FormData(addToCart);

      // Sending the Data
      const res = await axios.post('/storecart', formData);
      
      // Injecting Cart Data To DOM
      if(res.data.status) {
        if(cartResults) 
        manageMultipleCart(cartResults, res.data.cart.cartData, res.data.cart.shopifyData);

        if(cartResultsMb)
        manageMultipleCart(cartResultsMb, 
          res.data.cart.cartData, 
          res.data.cart.shopifyData, 
          true
        );

        if(cartCount) cartCount.innerHTML = res.data.cartCount;
        if(cartCountMb) cartCountMb.innerHTML = res.data.cartCount;

        if(cartTotal) {
          cartTotal.innerHTML = '';
          cartTotal.innerHTML = `Total: $${parseFloat(res.data.cartTotal)}`;
        }

        if(cartTotalMb) {
          cartTotalMb.innerHTML = '';
          cartTotalMb.innerHTML = `Total: $${parseFloat(res.data.cartTotal)}`;
        }
      }

    } catch(err) {
      console.log(err);
    }
  });
}

// Delete Cart
if(cartDropdown) {
  cartDropdown.addEventListener('click', async (e) => {
    if(e.target.className === 'header-cart-item-img') {
      const img = e.target;
      const cartId = img.getAttribute('data-cart') || null;
      const cartIdClass = 'cart-' + cartId;
      const cartIdClassMb = 'cart-' + cartId + 'Mb';
      const cartElement = document.getElementById(cartIdClass);
      const cartElementMb = document.getElementById(cartIdClassMb);

      // Delete Cart
      const data = await deleteCart(cartId);

      if(data.status) {
        // Update Cart
        if(cartCount) cartCount.innerHTML = data.cartCount;
        if(cartCountMb) cartCountMb.innerHTML = data.cartCount;

        if(cartTotal) {
          cartTotal.innerHTML = `Total: $${parseFloat(data.cartTotal)}`;
        }

        if(cartTotalMb) {
          cartTotalMb.innerHTML = `Total: $${parseFloat(data.cartTotal)}`;
        }

        // Update DOM
        if(data.cartCount) {
          if(data.status && cartElement) cartElement.remove();
          if(data.status && cartElementMb) cartElementMb.remove();
        } else {
          cartResults.innerHTML = '<p>Nothing Here</p>';
          cartResultsMb.innerHTML = '<p>Nothing Here</p>';
        }
      }
    }
  });
}

// Delete Cart Mobile
if(cartDropdownMb) {
  cartDropdownMb.addEventListener('click', async (e) => {
    if(e.target.className === 'header-cart-item-img') {
      const img = e.target;
      const cartId = img.getAttribute('data-cart') || null;
      const cartIdClass = 'cart-' + cartId;
      const cartIdClassMb = 'cart-' + cartId + 'Mb';
      const cartElement = document.getElementById(cartIdClass);
      const cartElementMb = document.getElementById(cartIdClassMb);

      // Delete Cart
      const data = await deleteCart(cartId);

      if(data.status) {
        // Update Cart
        if(cartCount) cartCount.innerHTML = data.cartCount;
        if(cartCountMb) cartCountMb.innerHTML = data.cartCount;

        if(cartTotal) {
          cartTotal.innerHTML = `Total: $${parseFloat(data.cartTotal)}`;
        }

        if(cartTotalMb) {
          cartTotalMb.innerHTML = `Total: $${parseFloat(data.cartTotal)}`;
        }

        // Update DOM
        if(data.cartCount) {
          if(data.status && cartElement) cartElement.remove();
          if(data.status && cartElementMb) cartElementMb.remove();
        } else {
          cartResults.innerHTML = '<p>Nothing Here</p>';
          cartResultsMb.innerHTML = '<p>Nothing Here</p>';
        }
      }
    }
  });
}

// Update Cart Quantity
if(cartMinus) {
  cartMinus.forEach(minus => {
    minus.addEventListener('click', async () => {
      const cartForm = minus.form;
      const productId = minus.getAttribute('data-product') || null;
      const shopifyId = minus.getAttribute('data-shopify') || null;

      if(cartForm) {
        const formData = new FormData(cartForm);
        formData.append('productId', productId);
        formData.append('shopifyId', shopifyId);
        formData.append('quantityType', 'minus');

        const res = await axios.post('/updatecart', formData);
        
        if(res.data.status) {
          const singleCartTotal = document.getElementById(`cart-total-${shopifyId}`);

          if(singleCartTotal)
          singleCartTotal.textContent = formatNumber('en-US', 'USD', res.data.total);

          if(cartTotal) cartTotal.textContent = formatNumber('en-US', 'USD', res.data.cartTotal);
        }
      }
    });
  });
}

if(cartPlus) {
  cartPlus.forEach(plus => {
    plus.addEventListener('click', async () => {
      const cartForm = plus.form;
      const productId = plus.getAttribute('data-product') || null;
      const shopifyId = plus.getAttribute('data-shopify') || null;

      if(cartForm) {
        const formData = new FormData(cartForm);
        formData.append('productId', productId);
        formData.append('shopifyId', shopifyId);
        formData.append('quantityType', 'plus');

        const res = await axios.post('/updatecart', formData);
        
        if(res.data.status) {
          const singleCartTotal = document.getElementById(`cart-total-${shopifyId}`);

          if(singleCartTotal)
          singleCartTotal.textContent = formatNumber('en-US', 'USD', res.data.total);

          if(cartTotal) cartTotal.textContent = formatNumber('en-US', 'USD', res.data.cartTotal);
        }
      }
    });
  });
}

// Delete Main Cart
if(mainCartImage) {
  mainCartImage.forEach(img => {
    img.addEventListener('click', async () => {
      const cartId = img.getAttribute('data-cart') || null;
      const cartIdClass = 'cart-' + cartId;
      const cartElement = document.getElementById(cartIdClass);

      // Delete Cart
      const data = await deleteCart(cartId);

      if(data.status) {
        if(cartElement) cartElement.remove();
        if(cartTotal) cartTotal.textContent = formatNumber('en-US', 'USD', data.cartTotal);

        if(data.cartCount === 0) {
          if(cartTable) cartTable.remove();

          if(document.getElementById('noProduct')) {
            document.getElementById('noProduct').style.display = 'block';
          }
        }
      }
    });
  })
}

// Order
if(checkoutButton) {
  checkoutButton.addEventListener('click', async () => {
    checkoutButton.setAttribute('disabled', 'true');
    checkoutButton.textContent = 'Processing...';

    swal({
      title: 'Order Processed!',
      text: 'Order has been processed, please wait, do not press back or refresh.',
    });

    const res = await axios.get('/authorize-user');
    
    if(res.data === 1) {
      const charge = await chargeApplication();

      if(charge && charge.order) {
        window.location.href = '/orders';
      }
    }
  });
}