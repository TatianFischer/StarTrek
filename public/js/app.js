/**!
Navigation Button Toggle class
*/
(function() {

// old browser or not ?
if ( !('querySelector' in document && 'addEventListener' in window) ) {
return;
}
window.document.documentElement.className += ' js-enabled';

function toggleNav() {

// Define targets by their class or id
var button = document.querySelector('.nav-button');
var target = document.querySelector('body nav[role="navigation"]');

// click-touch event
if ( button ) {
  button.addEventListener('click',
  function (e) {
      button.classList.toggle('is-active');
    target.classList.toggle('is-opened');
    e.preventDefault();
  }, false );
}
} // end toggleNav()

toggleNav();
}());


$('.episode-list-item h2').on('click', function(){
	$(this).toggleClass('selected');
	$(this).next().toggleClass('visually-hidden');

	var episodeList = $('.episode-list-item').not($(this).parent());
	episodeList.find('h2').removeClass('selected');
	episodeList.find('.episode-details').addClass('visually-hidden');
})

$('textarea').on('blur focus', function(){
    $(this).height($(this).css('min-height'));
    $(this).height($(this).prop('scrollHeight'));
});