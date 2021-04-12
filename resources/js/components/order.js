import { fetchShopify } from './fetchHelper';

export const getCartTotal = async () => {
  const res = await fetchShopify('GET','/get-cart-total', null);
  const data = await res.json();

  return data;
}

export const chargeApplication = async () => {
  const total = await getCartTotal();
  const charge = await fetchShopify('GET', `/create-charge/${total}`, null);
  const data = await charge.json();

  return data;
}