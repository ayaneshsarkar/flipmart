export const fetchShopify = async (method, host, body) => {
  const fetchObject = {
    method,
    headers: new Headers({
      'Content-Type': 'application/json',
    })
  };

  if(method !== 'GET') {
    fetchObject.body = body ? JSON.stringify(body) : null;
  }

  return await fetch(host, fetchObject);
}