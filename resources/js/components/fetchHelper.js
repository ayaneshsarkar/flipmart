import { SHOPIFY_ACCESS_TOKEN } from '../config';

export const fetchShopify = async (method, host, body) => {
  const fetchObject = {
    method,
    headers: new Headers({
      'Content-Type': 'application/json',
      'X-Shopify-Access-Token': SHOPIFY_ACCESS_TOKEN
    })
  };

  if(method !== 'GET') {
    fetchObject.body = body ? JSON.stringify(body) : null;
  }

  return await fetch(host, fetchObject);
}