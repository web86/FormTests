(() => {
  const modal = document.querySelector('#modal');
  document.querySelector('#open-modal')?.addEventListener('click', () => { modal.hidden = false; });
  document.querySelector('.modal-close')?.addEventListener('click', () => { modal.hidden = true; });
  document.querySelector('#accept-cookies')?.addEventListener('click', () => document.querySelector('#cookie-banner')?.remove());
  document.querySelector('#promo-close')?.addEventListener('click', () => { document.querySelector('#promo').hidden = true; });

  document.addEventListener('submit', async (event) => {
    const form = event.target.closest('form[data-ajax="1"]');
    if (!form) return;
    event.preventDefault();
    const status = form.querySelector('.form-status');
    status.textContent = 'Sending…';
    try {
      const response = await fetch(form.dataset.endpoint, {
        method: 'POST',
        body: new FormData(form),
        headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
      });
      const data = await response.json().catch(() => ({}));
      if (!response.ok || data.success !== true) throw new Error(data.error || `HTTP_${response.status}`);
      status.className = 'form-status success-message';
      status.textContent = form.dataset.success || data.message || 'Success';
      form.querySelector('button[type="submit"]')?.setAttribute('disabled','disabled');
    } catch (error) {
      status.className = 'form-status error-message';
      status.textContent = 'Submission failed';
      console.error('TEST_SUBMIT_ERROR', error);
    }
  });
})();
