/**
 * Gestion du menu responsive sur écrans nomades
 */
$('#hamburger').on('click', function(){
  $('nav').toggle('slow');
  if($(this).html() == '<span class="oi oi-menu"></span>'){
    $(this).html('<span class="oi oi-x"></span>');
    $('#main-header').css('height', '100vh');
  }
  else{
    $(this).html('<span class="oi oi-menu"></span>');
    $('#main-header').css('height', 'auto');
  }
  $('#main-nav li').on('click', function(){
    $('nav').hide();
    $('#main-header').css('height', 'auto');
    $('#hamburger').html('<span class="oi oi-menu"></span>');
  });
});
