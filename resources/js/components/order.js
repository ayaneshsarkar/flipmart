import { fetchShopify } from './fetchHelper';

export const getCartTotal = async () => {
  const res = await fetchShopify('GET','/get-cart-total', null);
  const data = await res.json();

  return data;
}

export const chargeApplication = async () => {
  const order = await fetchShopify('GET', '/create-order', {});
  const data = await order.json();

  return data;
}