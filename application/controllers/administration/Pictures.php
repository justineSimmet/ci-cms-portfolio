<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Contrôleur Pictures gère et dispatch les données du Modèle Picture.
 * Il a pour rôle de permettre la gestion des galeries de projets et de leurs visuels
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Pictures extends MY_Controller {

  /**
   * Vérifie que l'utilisateur est connecté, sinon le renvoie vers le login.
   * Initialise les paramètres standards du contrôleur
   * - le modèle project
   * - le modèle picture
   * - le helper form
   * - la librairie form_validation (app/config/form_validation)
   * - la liste des galeries existantes
   * - la gestion des messages d'erreur
   * 
   */  
  public function __construct()
  {
    parent::__construct();
    
    if ($this->user->is_logged_in() === FALSE) {
        redirect('administration/dashboard/login');
    };

    $this->load->model('project');
    $this->load->model('picture');
    $this->load->helper('form');
    $this->load->library('form_validation');

    $this->data['galleries'] = $this->project->list_gallery();
    if ($this->session->flashdata('result_message') !== NULL) {
      $this->data['result_message'] = $this->session->flashdata('result_message');
    }
  }

  /**
   * empty_gallery se lance avec une requête ajax
   * Il va  supprimer l'ensemble des visuels d'une galerie cible
   * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
   * 
   * @return string
   */
  public function empty_gallery()
  {
    if (!empty($this->input->post('gallery'))) {
      $id = $this->input->post('gallery');
      if ($this->picture->empty_gallery($id)) {
        echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
    }
    else{
      echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
    }
  }

  /**
   * Delete se lance avec une requête ajax
   * Il va  supprimer un visuel
   * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
   * 
   * @return string
   */
  public function delete()
  {
    if (!empty($this->input->post('picture'))) {
      $id = $this->input->post('picture');
      if ($this->picture->delete_picture($id)) {
        echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
    }
    else{
      echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
    }
  }


  /**
   * Hide se lance avec une requête ajax
   * Il va  masquer un visuel qui était publié
   * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
   * 
   * @return string
   */
  public function hide()
  {
    if (!empty($this->input->post('picture'))) {
      $id = $this->input->post('picture');
      if ($this->picture->hide_item($id)) {
        echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
    }
    else{
      echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
    }
  }


  /**
   * Show se lance avec une requête ajax
   * Il va  masquer un visuel qui était publié
   * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
   * 
   * @return string
   */
  public function show()
  {
    if (!empty($this->input->post('picture'))) {
      $id = $this->input->post('picture');
      if ($this->picture->show_item($id)) {
        echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
    }
    else{
      echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
    }
  }

  public function order()
  {
    if (!empty($this->input->post('change'))) {
      if (!$this->picture->set_order($this->input->post('change'))) {
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
      }
    }
    else{
      echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
    }
  }

  /**
   * View permet de visualiser et modifier le contenue d'une galerie
   * @param integer $gallery id du projet/galerie cible
   * @param string|null $action new ou edit détermine l'action sur un visuel
   * @param integer|null $item cible l'item a modifier
   */
  public function view($target, $action = NULL, $item = NULL)
  {
    $project = $this->project->get_item($target);

    // Le paramètre doit être valide, sinon un message d'erreur est retourné
    if ($target == NULL || $project == FALSE) {
      $this->session->set_flashdata('result_message', array('state'=>'error', 'content'=> "Vous ne pouvez pas modifier une galerie qui n'existe pas !"));
      redirect('administration/pictures/index');
    }

    $this->load->helper('file');
    
    $this->data['pagetitle'] = 'Administration - gestion d\'une galerie';
    $this->data['h1_title'] = 'Galerie '.$project->title;
    $this->data['list_pictures'] = $this->picture->list_item('project_id ='.$project->id, 'gallery_order ASC' );
    $this->data['project_id'] = $project->id;
    $this->data['project_title'] = $project->title;
    $this->data['pictures_list'] = $this->picture->list_item('project_id ='.$project->id, 'gallery_order ASC');

    //Définir les action de la page cible d'une galerie
    if ($action == NULL && $item == NULL) {
      $this->render(array('admin/list_picture_view', 'admin/actions_picture_view'), 'admin/admin_master');
    }

    if ($action == 'new' && $item == NULL) {
      $this->data['pagetitle'] = 'Administration - ajouter un visuel';
      if ($this->form_validation->run('newPicture') === FALSE){
        $this->render(array('admin/list_picture_view', 'admin/form_new_picture_view'), 'admin/admin_master');
      }
      else{
        if (!empty($this->input->post('title')) && !empty($this->input->post('alt')) && !empty($_FILES['file'])) {
          $form = array(
            'title'      => $this->input->post('title'),
            'alt'        => $this->input->post('alt'),
            'project_id' => $this->input->post('project')
          );
          if ($this->picture->create($form)) {
            $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "Le nouveau visuel \"".$form['title']."\" a bien été enregistré."));
            redirect('administration/pictures/view/'.$project->id);
          }
          else{
            $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, le visuel n'a pas été enregistré.");
            $this->render(array('admin/list_picture_view', 'admin/form_new_picture_view'), 'admin/admin_master');
          }
        }
        else{
          $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, votre formulaire ne contient pas les informations nécessaires.");
          $this->render(array('admin/list_picture_view', 'admin/form_new_picture_view'), 'admin/admin_master');
        }
      }
    }

    if($action == 'edit'){
      $picture = $this->picture->get_item($item);

      if ($item == NULL || $picture == FALSE) {
        $this->session->set_flashdata('result_message', array('state'=>'error', 'content'=> "Vous ne pouvez pas modifier un visuel qui n'existe pas !"));
        redirect('administration/pictures/view/'.$target);
      }

      $this->data['pagetitle'] = 'Administration - modifier un visuel';
      $this->data['title'] = $picture->title;
      $this->data['alt'] = $picture->alt;
      $this->data['id'] = $picture->id;

      if ($this->input->post('title') !== $picture->title) {
        $this->form_validation->set_rules('title', 'titre', 'trim|required|min_length[3]|is_unique[picture.title]');
      }
      else{
        $this->form_validation->set_rules('title', 'titre', 'trim|required|min_length[3]');
      }

      if ($this->form_validation->run('editPicture') === FALSE){
        $this->render(array('admin/list_picture_view', 'admin/form_edit_picture_view'), 'admin/admin_master');
      }
      else{
        $id = $this->input->post('id');
        $form = array();
        if ($this->input->post('title') !== $picture->title) {
          $form['title'] = $this->input->post('title');
        }
        if ($this->input->post('alt') !== $picture->alt) {
          $form['alt'] = $this->input->post('alt');
        }


        if (empty($form) && $_FILES['file']['error'] == 4 ) {
          $this->data['result_message'] = array('state'=>'error', 'content'=> "Vous n'avez effectué aucun changement, le visuel n'a pas été modifié.");
          $this->render(array('admin/list_picture_view', 'admin/form_edit_picture_view'), 'admin/admin_master');
        }
        else{
          if (!$this->picture->update($form, $id)) {
            $this->data['result_message'] = array('state'=>'error', 'content'=> "Le visuel n'a pas été modifié.");
            $this->render(array('admin/list_picture_view', 'admin/form_edit_picture_view'), 'admin/admin_master');
          }
          else{
            $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "Le visuel a bien été modifié."));
            redirect('administration/pictures/view/'.$project->id, 'refresh');
          }
        }

      }


    }
  }

  /**
   * callback de validation du fichier uploadé
   * Vérifie le type, l'existence, et la présence du fichier dans le formulaire envoyé
   */
  public function file_check($str){
      $allowed_type = array('application/pdf','image/gif','image/jpeg','image/png');
      $file_type = get_mime_by_extension($_FILES['file']['name']);
      if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
          if(in_array($file_type, $allowed_type)){
              if ( (($_FILES['file']['size'])/1024) < 5120 )  {
                  return TRUE;
              }
              else{
                  $this->form_validation->set_message('file_check', 'Votre fichier ne doit pas faire plus de 5Mo.');
                  return FALSE;
              }
          }
          else{
              $this->form_validation->set_message('file_check', 'Votre fichier doit être au format jpeg / gif / png ou pdf.');
              return FALSE;
          }
      }
      else{
          $this->form_validation->set_message('file_check', 'Merci de choisir un fichier a télécharger.');
      return FALSE;
      }
  }

  /**
   * L'index donne un aperçu de l'ensemble des galeries existantes
   */
  public function index()
  {
    $this->data['pagetitle'] = 'Administration - gestion des galeries';
    $this->data['h1_title'] = 'Gestion des galeries';
    $this->data['main_pictures'] = array();
    if (count($this->data['galleries']) == 1) {
      $first_pic =  $this->picture->find_item('project_id ='.$this->data['galleries']->id.' AND visibility = '.TRUE, 'gallery_order ASC', '1');
      if ($first_pic !== FALSE) {
        $this->data['main_pictures'][$this->data['galleries']->id] = $first_pic;
      }
    }
    else{
      foreach ($this->data['galleries'] as $gallery) {
        $first_pic =  $this->picture->find_item('project_id ='.$gallery->id.' AND visibility = '.TRUE, 'gallery_order ASC', '1');
        if ($first_pic !== FALSE) {
          $this->data['main_pictures'][$gallery->id] = $first_pic; 
        }
      }
    }

    $this->render('admin/grid_galleries_view', 'admin/admin_master');
  }

}