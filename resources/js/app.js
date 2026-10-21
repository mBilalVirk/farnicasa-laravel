import './bootstrap';
document.addEventListener('DOMContentLoaded', () => {
  const menu = document.querySelector('[data-mobile-menu]');
  document.querySelectorAll('[data-toggle-menu]').forEach(button => button.addEventListener('click', () => {
    if (menu) { const isHidden = menu.classList.toggle('hidden'); button.setAttribute('aria-expanded', String(!isHidden)); }
  }));
  document.querySelectorAll('[data-confirm]').forEach(form => form.addEventListener('submit', event => {
    if (!window.confirm(form.dataset.confirm)) event.preventDefault();
  }));
  document.querySelectorAll('[data-qty-control]').forEach(container => {
    const input = container.querySelector('input[type=number]');
    container.querySelectorAll('[data-step]').forEach(button => button.addEventListener('click', () => {
      const min = Number(input.min || 1), max = Number(input.max || 99);
      input.value = String(Math.max(min, Math.min(max, Number(input.value || 1) + Number(button.dataset.step))));
    }));
  });
});
