import './bootstrap';
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-toast]').forEach(toast => {
    const duration = Number(toast.dataset.duration) || 6000;
    const progress = toast.querySelector('.toast__progress');
    let timeout;

    if (progress) progress.style.animationDuration = `${duration}ms`;

    const dismiss = () => {
      window.clearTimeout(timeout);
      toast.classList.remove('is-visible');
      toast.classList.add('is-leaving');
      toast.addEventListener('transitionend', () => toast.remove(), { once: true });
      window.setTimeout(() => toast.remove(), 400);
    };
    const startTimer = () => {
      window.clearTimeout(timeout);
      timeout = window.setTimeout(dismiss, duration);
    };

    toast.querySelector('[data-toast-dismiss]')?.addEventListener('click', dismiss);
    toast.addEventListener('mouseenter', () => window.clearTimeout(timeout));
    toast.addEventListener('mouseleave', startTimer);
    window.requestAnimationFrame(() => toast.classList.add('is-visible'));
    startTimer();
  });

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
