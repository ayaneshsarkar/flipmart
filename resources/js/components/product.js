import { SHOPIFY_URL, proxy } from '../config';
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

export const deleteCart = async (cartId = 0) => {
  const res = await fetchShopify('GET', `/deletecart/?id=${cartId}`);
  const data = await res.json();
  return data;
}

export const formatNumber = (format, currency, number) => {
  const formattedNumber = new Intl.NumberFormat(format, { style: 'currency', currency: currency }).format(number);

  return formattedNumber;
}