import { SHOPIFY_URL, proxy } from '../config';
import { fetchShopify } from './fetchHelper';

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