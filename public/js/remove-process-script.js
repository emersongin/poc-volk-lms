import { request } from './helpers.js';

const removeProcessModal = async processId => {
  if (!confirm(`deseja realmente apagar o processo de código: ${processId}`)) return;
  const removed = await request({
    type: 'POST',
    url: 'http://localhost/processos/remover',
    data: {
      processId
    }
  });

  if (removed) window.location.href = window.location.href;
}

window.removeProcessModal = removeProcessModal;