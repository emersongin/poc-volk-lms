import { request } from './helpers.js';

const integrateProcessModal = async processId => {
  const button = document.querySelector('.btn-integration');

  if (!confirm(`Deseja realmente apagar o processo de código: ${processId}?`)) return;

  button.classList.add('bg-body-secondary');
  button.disabled = true;

  const integrated = await request({
    type: 'POST',
    url: 'http://localhost/processos/integracao',
    data: {
      processId
    }
  });

  if (integrated.message == 'ok') {
    alert('Intregração realizada com sucesso!');
    window.location.href = window.location.href;
  } else {
    alert('Não foi possível realizar a integração!');
  }

  button.classList.remove('bg-body-secondary');
  button.disabled = false;
}

window.integrateProcessModal = integrateProcessModal;