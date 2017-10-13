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
 * Enclenche la suppression d'un utilisateur au click
 */
function deleteUser(id, username, item){
  var check = confirm('Êtes-vous sûr de vouloir supprimer l\'utilisateur '+ username +' ?');
  if(check) {
    var token = $('input[name=csrf_token]').val();
    var tooltipItem = item.attr('aria-describedby');
    $.post(
      BaseURL+'administration/users/delete',
      { csrf_token: token, userId: id, action: 'deleteUser'}
    ).done(function(data) {
      var response = JSON.parse(data);
      $('input[name=csrf_token]').val(response.new_token);
      if (!response.result) {
        var message = 'Une erreur s\'est produite, l\'utilisateur '+username+' n\'a pas été supprimé.';
        alertMessage('danger',message);
      }else{
        var message = 'L\'utilisateur '+username+' a été correctement supprimé.';
        alertMessage('success',message);
        $('#'+tooltipItem).remove();
        $('tr[data-user="'+id+'"]').remove();
        $('.admin-form input[name=csrf_token]').val(response.new_token);
      }
    });
  }
}


$(document).on('click', '.deleteUser', function(){
  var itemId = $(this).data('id'),
    itemUsername = $(this).data('username');
  deleteUser(itemId, itemUsername, $(this));
});