import swal from 'sweetalert';
import axios from 'axios';

const addToCart = document.getElementById('addToCart');

if(addToCart) {
  addToCart.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {
      // Assigning the FormData
      const formData = new FormData(addToCart);

      // Sending the Data
      const res = await axios.post('/storecart', formData);
      console.log(res.data);

    } catch(err) {
      console.log(err);
    }
  });
}