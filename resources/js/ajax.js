import axios from 'axios';
import swal from 'sweetalert';
import { manageMultipleCart } from './components/product';

const addToCart = document.getElementById('addToCart');
const cartResults = document.getElementById('cartResults');
const cartCount = document.getElementById('cartCount');
const cartTotal = document.getElementById('cartTotal');

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

        if(cartCount) cartCount.innerHTML = res.data.cartCount;

        if(cartTotal) {
          cartTotal.innerHTML = '';
          cartTotal.innerHTML = `Total: $${parseFloat(res.data.cartTotal)}`;
        }
      }

    } catch(err) {
      console.log(err);
    }
  });
}