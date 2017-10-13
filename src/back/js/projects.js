import '@fancyapps/fancybox';
import '@fancyapps/fancybox/dist/jquery.fancybox.min.css';

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

/**
 * Enclenche la publication d'un projet au click
 */
function showProject(id, title, category, item){
  var token = $('input[name=csrf_token]').val();
  $('[data-toggle="tooltip"]').tooltip('hide');
  $.post(
    BaseURL+'administration/projects/show',
    { csrf_token: token, projId: id, catId: category}
  ).done(function(data) {
    var response = JSON.parse(data);
    $('input[name=csrf_token]').val(response.new_token);
    if (!response.result) {
      var message = 'Une erreur s\'est produite, le projet "'+title+'" n\'a pas été publié. Vérifiez qu\'il n\'appartient pas à une catégorie masquée.';
      alertMessage('danger',message);
      $('[data-toggle="tooltip"]').tooltip();
    }else{
      var message = 'La projet "'+title+'" a été publié.';
      alertMessage('success',message);
      $(item).html('<span class="oi oi-eye"></span>  Masquer le projet');
      $(item).addClass('hideProject').removeClass('showProject');
      $(item).addClass('btn-success').removeClass('btn-warning');
      $(item).attr('data-original-title','Cliquez pour masquer');
      $('[data-toggle="tooltip"]').tooltip();
    }
  });
}

$(document).on('click', '.showProject', function(){
  var itemId = $(this).data('id'),
    itemTitle = $(this).data('title'),
    itemCategory = $(this).data('category');
  showProject(itemId, itemTitle, itemCategory, $(this));
});

/**
 * Enclenche le masquage d'un projet au click
 */
function hideProject(id, title, category,item){
  var token = $('input[name=csrf_token]').val();
  $('[data-toggle="tooltip"]').tooltip('hide');
  $.post(
    BaseURL+'administration/projects/hide',
    { csrf_token: token, projId: id}
  ).done(function(data) {
    var response = JSON.parse(data);
    $('input[name=csrf_token]').val(response.new_token);
    if (!response.result) {
      var message = 'Une erreur s\'est produite, le projet ""'+title+'" n\'a pas été masqué.';
      alertMessage('danger',message);
      $('[data-toggle="tooltip"]').tooltip();
    }else{
      var message = 'Le projet "'+title+'" a été masqué.';
      alertMessage('success',message);
      $('input[name=csrf_token]').val(response.new_token);
      $(item).html('<span class="oi oi-eye"></span>  Publier le projet');
      $(item).addClass('showProject').removeClass('hideProject');
      $(item).addClass('btn-warning').removeClass('btn-success');
      $(item).attr('data-original-title','Cliquez pour publier');
      $('[data-toggle="tooltip"]').tooltip();
    }
  });
}


$(document).on('click', '.hideProject', function(){
  var itemId = $(this).data('id'),
    itemTitle = $(this).data('title'),
    itemCategory = $(this).data('category');
  hideProject(itemId, itemTitle, itemCategory, $(this));
});


/**
 * Enclenche la suppression d'un projet au click
 */
function deleteProject(id, title, item){
  var check = confirm('Êtes-vous sûr de vouloir supprimer définitivement le projet "'+ title +'" et sa galerie ?');
  if(check) {
    var tooltipItem = item.attr('aria-describedby');
    var token = $('input[name=csrf_token]').val();
    $.post(
      BaseURL+'administration/projects/delete',
      { csrf_token: token, projId: id}
    ).done(function(data) {
      var response = JSON.parse(data);
      if (!response.result) {
        var message = 'Une erreur s\'est produite, le projet "'+title+'" n\'a pas été supprimé.';
        alertMessage('danger',message);
        $('input[name=csrf_token]').val(response.new_token);
      }else{
        var message = 'Le projet "'+title+'" et sa galerie ont été correctement supprimé.';
        alertMessage('success',message);
        $('input[name=csrf_token]').val(response.new_token);
        $('#'+tooltipItem).remove();
        if($('#list-project-table').length){
          $('#list-project-table tr[data-project="'+id+'"]').remove();
          var stringProject = $('#list-project-table h2').html().trim();
          var numberProject = stringProject.slice(-1)-1;
          var newString = 'Projets créés : '+numberProject;
          $('#list-project-table h2').html(newString);
        }
        else{
          var button = '<a href="'+BaseURL+'administration/projects" type="button" role="button" class="d-block btn btn-primary btn-lg mx-auto">Retourner à la liste des projets </a>';
          $('.content-area .row').remove();
          $('.content-area h1').remove();
          $('.content-area').append(button);
        }
      }
    });
  }
}


$(document).on('click', '.deleteProject', function(){
  var itemId = $(this).data('id'),
    itemTitle = $(this).data('title');
  deleteProject(itemId, itemTitle, $(this));
});
