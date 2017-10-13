$(document).ready(function(){
/** 
 * Paramètres du plugin fullpage.js
 */
  $('#onePage').fullpage({
    menu: '#main-nav ul',
    anchors:['section1', 'projets', 'section2', 'contact'],
    sectionsColor : ['#fff', '#cecece', '#fff', '#cecece'],
    fixedElements: '#main-header, #admin-navbar',
    scrollBar: true,
    autoScrolling: false,
    fitToSection: false,
  });
  
  /** 
   * Paramètres du plugin filterizr
   */
  $('.filtr-container').filterizr({
    layout: 'sameWidth',
    delay: 50,
    delayMode: 'progressive',
  });

  $('#grid-filter li').click(function() {
    $('#grid-filter li').removeClass('filtr-active');
    $(this).addClass('filtr-active');
  });
});