import swal from 'sweetalert';
import { fetchShopify } from './fetchHelper';

// Cart HTML
const insertCartHTML = (data, productData) => {
  const html = 
  `
  <li class="header-cart-item" id="cart-${productData.cartId}">
    <a class="cartImage">
      <div class="header-cart-item-img" data-cart="${productData.cartId}">
        <img src="${data.image.src}" alt="${data.title}">
      </div>
    </a>

    <div class="header-cart-item-txt">
      <a href="/shop/${data.id}" class="header-cart-item-name">
        ${data.title}
      </a>

      <span class="header-cart-item-info">
        ${productData.quantity} x $${data.variants[0].price}
      </span>
    </div>
  </li>
  `;

  return html;
}

export const deleteProductImage = async (productId, imageId) => {
  try {
    const res = await fetchShopify(
      'GET', `/deleteproductimagejs?productId=${productId}&imageId=${imageId}`
    );

    const data = await res.json();
    
    if(data && data.status === 404) {
      swal({
        title: 'Error 404',
        text: 'Main Image Cannot be Deleted, you can always change it.'
      });
    }
    
    return data.status;

  } catch(err) {
    console.log(err);
  }
}

export const manageCart = (cartElement, data, productData) => {
  cartElement.innerHTML = '';
  cartElement.insertAdjacentHTML('beforeend', insertCartHTML(data, productData));
}

export const manageMultipleCart = (cartElement, cartData, shopifyData) => {
  cartElement.innerHTML = '';

  const cartArray = [];

  cartData.map(data => {
    const shopify = shopifyData.find(sd => sd.id === data.shopify_id);
    cartArray.push(insertCartHTML(shopify, data));
  });

  cartElement.insertAdjacentHTML('beforeend', cartArray.join(''));
}

export const deleteCart = async (cartId = 0) => {
  const res = await fetchShopify('GET', `/deletecart/?id=${cartId}`);
  const data = await res.json();
  return data;
}

export const formatNumber = (format, currency, number) => {
  const formattedNumber = new Intl.NumberFormat(format, { style: 'currency', currency: currency }).format(number);

  return formattedNumber;
}