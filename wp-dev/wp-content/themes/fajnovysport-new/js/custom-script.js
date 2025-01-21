$ = jQuery;

function vypocetVysky() {
	var sirkaOkna = $(window).width();
	var dynamickaVyska = ((sirkaOkna / 4) * 294) / 476;

	$('.news__item').css('height', dynamickaVyska + 'px');
}
$(document).ready(vypocetVysky);
$(window).resize(vypocetVysky);


// Přidáme třídu na základě vstupu z klávesnice
function handleFirstTab(event) {
    if (event.key === 'Tab') {
        document.body.classList.add('keyboard');
        window.removeEventListener('keydown', handleFirstTab);
        window.addEventListener('mousedown', handleMouseDownOnce);
    }
}

function detectFirstTab(e) {
	if (e.key === 'Tab') {
	  $('body').addClass('keyboard');
	  $(window).off('keydown', detectFirstTab);
	  $(window).on('mousedown', handleMouseDownOnce);
	}
  }

  // Funkce pro odstranění třídy 'keyboard', když uživatel používá myš
  function handleMouseDownOnce() {
	$('body').removeClass('keyboard');
	$(window).off('mousedown', handleMouseDownOnce);
	$(window).on('keydown', detectFirstTab);
  }

  // Přidáme posluchače události pro stisk klávesy
  $(window).on('keydown', detectFirstTab);

  // Získání referencí na elementy
  var $alert = $('#error');
  var $button = $('.button').first(); // Cílíme na první tlačítko s třídou .button
  var $input = $('#search');

  // Přidání události pro kliknutí na tlačítko
  $button.on('click', checkInput);

  // Funkce pro kontrolu vstupu
  function checkInput(e) {
	e.preventDefault(); // Zabraňuje odeslání formuláře nebo výchozímu chování tlačítka
	if ($input.val() === "") {
	  $alert.html(''); // Vymaže předchozí zprávy
	  var $span = $('<span>').text('You need to enter a search term before pressing submit');
	  $alert.append($span);
	  $input.attr('aria-invalid', true).focus(); // Nastaví atribut a vrátí fokus na vstupní pole
	}
  }

  // Událost při načtení stránky
  $(window).on('load', function() {
	// $alert.attr('aria-hidden', true); // Zakomentováno, ale mohlo by skrýt alert na začátku
  });


/*

// Při použití myši odstraníme třídu
function handleMouseDownOnce() {
    document.body.classList.remove('keyboard');
    window.removeEventListener('mousedown', handleMouseDownOnce);
    window.addEventListener('keydown', handleFirstTab);
}

window.addEventListener('keydown', handleFirstTab);


var alert = document.getElementById('error');
var button = document.querySelector('.button');
var input = document.getElementById('search');

button.addEventListener('click', checkInput);

function checkInput(e) {
	e.preventDefault();

	if(input.value === "") {
		alert.innerHTML = "";
		var span = document.createElement('span');
		span.innerHTML = "You need to enter a search term before pressing submit";
		alert.appendChild(span);
		input.setAttribute('aria-invalid', true);
		input.focus();
	}
}

window.onload = function() {
	//alert.setAttribute('aria-hidden', true);
};

*/

