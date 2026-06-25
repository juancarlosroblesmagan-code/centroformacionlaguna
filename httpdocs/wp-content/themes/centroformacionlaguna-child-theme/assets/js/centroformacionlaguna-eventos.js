/**
 * Filtros de modalidad en la landing de eventos.
 */
(function () {
	'use strict';

	var nav = document.querySelector('.centroformacionlaguna-eventos-filters');
	if (!nav) {
		return;
	}

	var buttons = nav.querySelectorAll('button[data-filter]');
	var cards = document.querySelectorAll('.centroformacionlaguna-event-card');

	function applyFilter(mode) {
		buttons.forEach(function (btn) {
			btn.classList.toggle('is-active', btn.getAttribute('data-filter') === mode);
		});

		cards.forEach(function (card) {
			var tags = card.getAttribute('data-tags') || '';
			var show =
				mode === 'all' ||
				card.getAttribute('data-mode') === mode ||
				(mode === 'empresas' && tags.indexOf('empresas') !== -1);
			card.classList.toggle('is-hidden', !show);
		});
	}

	buttons.forEach(function (btn) {
		btn.addEventListener('click', function () {
			applyFilter(btn.getAttribute('data-filter') || 'all');
		});
	});
})();
