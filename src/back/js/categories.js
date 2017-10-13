/**
 * Insert a custom alert message
 * @param  String $state [success or danger]
 * @param  String $message [custome message]
 */
function alertMessage(state, message){
  var alertArea = $('#main-alert');
  var divAlert  ='<div class="alert alert-'+state+' alert-dismissible fade show" role="alert">'
                +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                +'<span aria-hidden="true">&times;</span>'
                +'</button>'
                + message
                +'</div>';
  alertArea.html(divAlert);
}

/** Publie une catégorie au click */
function showCategory(id, title, item){
  var token = $('.admin-form input[name=csrf_token]').val();
  $('[data-toggle="tooltip"]').tooltip('hide');
  $.post(
    BaseURL+'administration/categories/show',
    { csrf_token: token, catId: id}
  ).done(function(data) {
    var response = JSON.parse(data);
    $('.admin-form input[name=csrf_token]').val(response.new_token);
    if (!response.result) {
      var message = 'Une erreur s\'est produite, la categorie "'+title+'" n\'a pas été publiée.';
      alertMessage('danger',message);
      $(item).tooltip();
    }else{
      var message = 'La catégorie "'+title+'" a été publiée.';
      alertMessage('success',message);
      $(item).html('<span class="oi oi-eye"></span>');
      $(item).addClass('hideCategory').removeClass('showCategory');
      $(item).addClass('btn-success').removeClass('btn-warning');
      $(item).attr('data-original-title','Cliquez pour masquer');
      $('[data-toggle="tooltip"]').tooltip();
    }
  });
}

$(document).on('click', '.showCategory', function(){
  var itemId = $(this).data('id'),
    itemTitle = $(this).data('title');
  showCategory(itemId, itemTitle, $(this));
});


/** Masque une catégorie au click */
function hideCategory(id, title, item){
  var token = $('.admin-form input[name=csrf_token]').val();
  $('[data-toggle="tooltip"]').tooltip('hide');
  $.post(
    BaseURL+'administration/categories/hide',
    { csrf_token: token, catId: id}
  ).done(function(data) {
    var response = JSON.parse(data);
    $('.admin-form input[name=csrf_token]').val(response.new_token);
    if (!response.result) {
      var message = 'Une erreur s\'est produite, la categorie ""'+title+'" n\'a pas été masquée.';
      alertMessage('danger',message);
      $(item).tooltip();
    }else{
      var message = 'La catégorie "'+title+'", ainsi que ses projets, a été masquée.';
      alertMessage('success',message);
      $(item).html('<span class="oi oi-eye"></span>');
      $(item).addClass('showCategory').removeClass('hideCategory');
      $(item).addClass('btn-warning').removeClass('btn-success');
      $(item).attr('data-original-title','Cliquez pour publier');
      $('[data-toggle="tooltip"]').tooltip();
    }
  });
}

$(document).on('click', '.hideCategory', function(){
  var itemId = $(this).data('id'),
    itemTitle = $(this).data('title');
  hideCategory(itemId, itemTitle,$(this));
});


/**
 * Enclenche la suppression d'une catégorie au click
 */
function deleteCategory(id, title, item){
  var check = confirm('Êtes-vous sûr de vouloir supprimer la catégorie "'+ title +'" ?');
  if(check) {
    var tooltipItem = item.attr('aria-describedby');
    var token = $('.admin-form input[name=csrf_token]').val();
    $.post(
      BaseURL+'administration/categories/delete',
      { csrf_token: token, catId: id}
    ).done(function(data) {
      var response = JSON.parse(data);
      $('.admin-form input[name=csrf_token]').val(response.new_token);
      if (!response.result) {
        var message = 'Une erreur s\'est produite, la catégorie "'+title+'" n\'a pas été supprimée.';
        alertMessage('danger',message);
        $(item).tooltip();
      }else{
        $(item).tooltip('disable');
        var message = 'La catégorie "'+title+'" a été correctement supprimée.';
        alertMessage('success',message);
        $('#'+tooltipItem).remove();
        $('#list-category-table tr[data-category="'+id+'"]').remove();
        $('.admin-form input[name=csrf_token]').val(response.new_token);
      }
    });
  }
}

$(document).on('click', '.deleteCategory', function(){
  var itemId = $(this).data('id'),
    itemTitle = $(this).data('title');
  deleteCategory(itemId, itemTitle, $(this));
});
