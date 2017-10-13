import 'webpack-jquery-ui/sortable';

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

/** Masque un visuel au click */
function hidePicture(id, item){
  var token = $('input[name=csrf_token]').val();
  $('[data-toggle="tooltip"]').tooltip('hide');
  $.post(
    BaseURL+'administration/pictures/hide',
    { csrf_token: token, picture: id}
  ).done(function(data) {
    var response = JSON.parse(data);
    $('input[name=csrf_token]').val(response.new_token);
    if (!response.result) {
      var message = 'Une erreur s\'est produite, le visuel n\'a pas été masqué.';
      alertMessage('danger',message);
      $('input[name=csrf_token]').val(response.new_token);
      $('[data-toggle="tooltip"]').tooltip();
    }
    else{
      item.addClass('showPicture').removeClass('hidePicture');
      $(item).addClass('btn-warning').removeClass('btn-success');
      $(item).attr('data-original-title','Cliquez pour publier');
      $('[data-toggle="tooltip"]').tooltip();
    } 
  });
}

$(document).on('click', '.hidePicture', function(){
  var itemId = $(this).data('id');
  hidePicture(itemId, $(this));
});

/** Publie un visuel au click */
function showPicture(id, item){
  var token = $('input[name=csrf_token]').val();
  $('[data-toggle="tooltip"]').tooltip('hide');
  $.post(
    BaseURL+'administration/pictures/show',
    { csrf_token: token, picture: id}
  ).done(function(data) {
    var response = JSON.parse(data);
    $('input[name=csrf_token]').val(response.new_token);
    if (!response.result) {
      var message = 'Une erreur s\'est produite, le visuel n\'a pas été publié.';
      alertMessage('danger',message);
      $('input[name=csrf_token]').val(response.new_token);
      $('[data-toggle="tooltip"]').tooltip();
    }
    else{
      item.addClass('hidePicture').removeClass('showPicture');
      $(item).addClass('btn-success').removeClass('btn-warning');
      $(item).attr('data-original-title','Cliquez pour masquer');
      $('[data-toggle="tooltip"]').tooltip();
    } 
  });
}

$(document).on('click', '.showPicture', function(){
  var itemId = $(this).data('id');
  showPicture(itemId, $(this));
});

/** Supprime un visuel au click */
function deletePicture(id, title, item){
  var check = confirm('Êtes-vous sûr de vouloir supprimer définitivement le visuel "'+ title +'" ?');
  if(check) {
    var token = $('input[name=csrf_token]').val();
    var tooltipItem = item.attr('aria-describedby');
    $.post(
      BaseURL+'administration/pictures/delete',
      { csrf_token: token, picture: id}
    ).done(function(data) {
      var response = JSON.parse(data);
      $('input[name=csrf_token]').val(response.new_token);
      if (!response.result) {
        var message = 'Une erreur s\'est produite, le visuel "'+title+'" n\'a pas été supprimé.';
        alertMessage('danger',message);
      }else{
        var message = 'Le visuel "'+title+'" a été correctement supprimé.';
        alertMessage('success',message);

        var item = $('#gallery-list li[data-picture="'+id+'"]');
        item.remove();
        $('#'+tooltipItem).remove();
        $('#gallery-list-count li:last').remove();
      }
    });
  }
}

$(document).on('click', '.deletePicture', function(){
  var itemId = $(this).data('id'),
    itemTitle = $(this).data('title');
  deletePicture(itemId,itemTitle, $(this));
});



/** Vide une galerie au click */
function emptyGallery(id, title, item){
  var check = confirm('Êtes-vous sûr de vouloir supprimer définitivement les visuels de la galerie "'+ title +'" ?');
  if (check) {
    $('[data-toggle="tooltip"]').tooltip('hide');
    var token = $('input[name=csrf_token]').val();
    $.post(
      BaseURL+'administration/pictures/empty_gallery',
      { csrf_token: token, gallery: id}
    ).done(function(data){
      var response = JSON.parse(data);
      if (!response.result) {
        var message = 'Une erreur s\'est produite, la galerie "'+title+'" n\'a pas été vidée.';
        alertMessage('danger',message);
        $('input[name=csrf_token]').val(response.new_token);
      }
      else{
        if($('#gallery-list').length){
          var message = 'La galerie "'+title+'" a bien été vidée.';
          alertMessage('success',message);
          $('input[name=csrf_token]').val(response.new_token);
          $('#gallery-list').empty();
          $('#gallery-list-count').empty();
          $('[data-toggle="tooltip"]').tooltip();
        }
        else{
          var message = 'La galerie "'+title+'" a bien été vidée.';
          alertMessage('success',message);
          $('input[name=csrf_token]').val(response.new_token);
          var gallery_item = $('.card[data-gallery="'+id+'"');
          gallery_item.find('.card-subtitle').html('Visuels : 0 | Visuels publiés : 0');
          var link = gallery_item.find('.card-img-top').parent();
          link.html('<div class="card-img-top no-img"></div>');
          $('[data-toggle="tooltip"]').tooltip();
        }
      }
    });
  }
}


$(document).on('click', '.emptyGallery', function(){
  var itemId = $(this).data('id'),
    itemTitle = $(this).data('title');
  emptyGallery(itemId,itemTitle, $(this));
});

/**
 * Lorsqu'un visuel est chargé par un utilisateur dans les formulaires, 
 * ce script va faire apparaitre son nom dans l'input stylisé
 * et montrer un aperçu de l'image ainsi que des informations sur son poids
 * et ses dimensions.
 **/
$('.input-file').each(function() {
  var $input = $(this),
    $label = $input.next('.js-labelFile'),
    labelVal = $label.html();
  
  $input.on('change', function(element) {
    var fileName = '';
    if (element.target.value) fileName = element.target.value.split('\\').pop();
    fileName ? $label.addClass('has-file').find('.js-fileName').html('<span class="oi oi-check" style="color:#5AAC7B;"></span> '+fileName) : $label.removeClass('has-file').html(labelVal);
    $('#new-img').show();
    var file = $(this).get(0).files[0];
    var reader = new FileReader();
    reader.onloadend = function(){
      var size = (file.size/ 1024).toFixed(1);
      $('#img-preview').css('background-image', 'url('+reader.result+')');
      $('#img-desc').empty();     
      $('#img-desc').append('<p><strong>Poid du fichier :</strong><br>'+size+' Ko</p>');
      var img = new Image();
      img.src = reader.result;
      img.onload = function() {
        $('#img-desc').append('<p><strong>Dimensions:</strong><br>'+img.width+' x '+img.height+' px</p>');
      };
    };
    if(file){
      reader.readAsDataURL(file);
    }

  });
});

// Initialise la hauteur des repères de positions sur le conteneur parent
function setItemHeight(target, clone){
  clone.each(function(i, item){
    var newHeight = $(target[i]).outerHeight();
    $(item).height(newHeight);
    $(item).children().css('line-height', newHeight+'px');
  });
}

/**
 * L'utilisateur a la possibilité de réordonner ses visuels.
 * Sortable de jQuery UI va permettre de déplacer les visuels dans la liste
 * et à chaque drop une requête Ajax s'éxécute pour permettre les changements de gallery_order
 **/

// Les paramètres sont initialisé
var sortableList = $('#gallery-list');
var startOrder = [];
var newOrder = [];
var changedOrder = [];
var targetList = $('#gallery-list li');
var cloneList = $('#gallery-list-count li');

setItemHeight(targetList, cloneList);


// Cette fonction permet d'obtenir un tableau des éléments qui ont été déplacés
// Les données sont stockées dans changedOrder, via l'id de l'item et sa nouvelle position
function compareOrder(original, update){
  $.each(original, function(i, item){
    for (var j = 0; j <= update.length - 1; j++) {
      if (item.id == update[j].id) {
        if (item.position !== update[j].position) {
          var item = {
            'position' : update[j].position,
            'id' : update[j].id,
          };
          changedOrder.push(item);
        }
      }
    }
  });
}

// Instancie le plugin sortable de jQuery UI sur la liste des visuels
sortableList.sortable({
  placeholder: 'ui-state-highlight',
  // A l'initialisation du processus, créé un tableau de l'ordre de départ des items -> startOrder
  create: function(event, ui){
    $(this).children().each(function(i, el){
      i++;
      var item = {
        'position' : i,
        'id' : $(this).data('picture'),
      };
      startOrder.push(item);
    });
    
  },

  // Lorsque le processus s'arrête, au drop d'un item, crée le tableau newOrder avec les nouvelles positions
  stop: function(event, ui) {
    $(this).children().each(function(i, el){
      i++;
      var item = {
        'position' : i,
        'id' : $(this).data('picture'),
      };
      newOrder.push(item);
    });

    // Utilisation de la fonction CompareOrder pour obtenir les changements
    compareOrder(startOrder, newOrder);

    var token = $('input[name=csrf_token]').val();

    $.post(
      BaseURL+'administration/pictures/order',
      {csrf_token: token, change: changedOrder}
    ).done(function(data) {
      var response = JSON.parse(data);
      $('input[name=csrf_token]').val(response.new_token);
      startOrder = newOrder;
      newOrder = [];
      changedOrder = [];
      if (!response.result) {
        var message = 'Une erreur s\'est produite, l\'ordre des visuels n\'a pas été modifié.';
        alertMessage('danger',message);
      }
    });
    var state = $('#gallery-list li');
    setItemHeight(state, cloneList);
  },
});