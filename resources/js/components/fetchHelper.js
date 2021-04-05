import { SHOPIFY_ACCESS_TOKEN } from '../config';

export const fetchShopify = async (method, host, body) => {
  return (
    await fetch(host, {
      method,
      headers: new Headers({
        'Content-Type': 'application/json',
        'X-Shopify-Access-Token': SHOPIFY_ACCESS_TOKEN
      }),
      body: body ? JSON.stringify(body) : null
    })
  );
}