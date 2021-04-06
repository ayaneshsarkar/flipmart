import { SHOPIFY_URL, proxy } from '../config';
import { fetchShopify } from './fetchHelper';

// Cart HTML
const insertCartHTML = (data, productData) => {
  const html = 
  `
  <li class="header-cart-item">
    <a class="cartImage">
      <div class="header-cart-item-img">
        <img src="${data.image.src}" alt="${data.title}">
        <input type="hidden" name="cartId" id="cartId" value="">
      </div>
    </a>

    <div class="header-cart-item-txt">
      <a href="#" class="header-cart-item-name">
        ${data.title}
      </a>

      <span class="header-cart-item-info">
        ${productData.quantity} x $${productData.price}
      </span>
    </div>
  </li>
  `;

  return html;
}

export const deleteProductImage = async (productId, imageId) => {
  try {
    const res = await fetchShopify(
      'DELETE', `${proxy}${SHOPIFY_URL}/products/${productId}/images/${imageId}.json`
    );
    
    return await res.status;

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