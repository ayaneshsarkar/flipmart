import axios from 'axios';
import swal from 'sweetalert';
import { manageCart } from './components/product';

const addToCart = document.getElementById('addToCart');
const cartResults = document.getElementById('cartResults');
const cartCount = document.getElementById('cartCount');
const cartTotal = document.getElementById('cartTotal');

if(addToCart) {
  addToCart.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {
      // Assigning the FormData
      const formData = new FormData(addToCart);

      // Sending the Data
      const res = await axios.post('/storecart', formData);
      
      // Injecting Cart Data To DOM
      if(res.data.status) {
        if(cartResults) manageCart(cartResults, res.data.shopifyData, res.data.productData);
        if(cartCount) cartCount.innerHTML = res.data.cartCount
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