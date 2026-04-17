document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.mat-accordion-trigger').forEach(function (trigger) {
    trigger.addEventListener('click', function () {
      var body    = document.getElementById(trigger.dataset.target);
      var chevron = trigger.querySelector('.mat-accordion-chevron');
      var isOpen  = body.classList.contains('open');
      body.classList.toggle('open', !isOpen);
      chevron.style.transform = isOpen ? '' : 'rotate(90deg)';
      chevron.style.color     = isOpen ? '' : '#F5C518';
    });
  });
});
