export const request = ({ url, type, token, headers, data }) => {
  const requestOptions = {
    method: type || 'GET',
    headers: {
      'Authorization': token || '',
      'Content-Type': 'application/json',
      ...headers
    },
    body: JSON.stringify(data)
  };

  return fetch(url, requestOptions)
    .then(async response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      if (response.status === 204) return true;
      // console.log(await response.text());
      return await response.json();
    })
    .catch(error => {
      if (error.message === 'Failed to fetch') {
        alert('Sem conexão!', 'error');
      }
      console.log(error);
      throw error;
    });
};