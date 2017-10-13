<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Contrôleur Projects gère et dispatch les données du Modèle Project.
 * Il a pour rôle de permettre la gestion directe des projets
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Projects extends MY_Controller {

  /**
   * Vérifie que l'utilisateur est connecté, sinon le renvoie vers le login.
   * Initialise les pramètres standards du contrôleur
   * - les modèles project & catégory
   * - le helper form
   * - la librairie form_validation (app/config/form_validation)
   * - la liste des projets enregistrés
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
    $this->load->model('category');
    $this->load->model('picture');
    $this->load->helper('form');
    $this->load->library('form_validation');

    $list = $this->project->list_item();

    if ($list !== FALSE) {
      $this->data['list_projects'] = $list;

      if (count($this->data['list_projects']) == 1) {
        $this->data['list_projects']->nbr_pictures = $this->picture->count_total($this->data['list_projects']->id);
      }
      else{
        foreach ($this->data['list_projects'] as $project) {
          $project->nbr_pictures = $this->picture->count_total($project->id);
        }
      }
    }
    else{
      $this->data['list_projects'] = FALSE;
    }
    if ($this->session->flashdata('result_message') !== NULL) {
      $this->data['result_message'] = $this->session->flashdata('result_message');
    }
  }

  /**
   * Preview permet de prévisualiser dans un nouvel onglet l'aspect du projet
   * @param integer $target 
   */
  public function preview($target)
  {
    $project = $this->project->get_item($target);

    // Le paramètre doit être valide, sinon un message d'erreur est retourné
    if ($target == NULL || $project == FALSE) {
      $this->data['result_message'] = array('state'=>'error', 'content'=> "Vous ne pouvez pas prévisualiser un projet qui n'existe pas !");
      $this->data['pagetitle'] = 'Administration - Erreur prévisualisation';
      $this->data['h1_title'] = '';
      $this->render(NULL, 'admin/admin_master');
    }
    else{
      $this->data['pagetitle'] = 'Administration - Prévisualiser un projet';
      $this->data['h1_title'] = '';

      $this->data['id'] = $project->id;
      $this->data['title'] = $project->title;
      $this->data['category'] = $this->category->get_item($project->category_id)->title;
      $this->data['context'] = $project->context;
      $this->data['description'] = $project->description;
      $this->data['external_link'] = $project->external_link;
      $this->data['gallery'] = $this->picture->find_item('project_id ='.$project->id.' AND visibility=1', 'gallery_order ASC');

      $this->render('admin/preview_project_view', 'admin/admin_master');
    }

  }

  /**
   * Delete se lance avec une requête ajax
   * Il va  supprimer un projet qui ainsi que sa galerie
   * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
   * 
   * @return string
   */
  public function delete()
  {
    if (!empty($this->input->post('projId'))) {
      $id = $this->input->post('projId');
      if ($this->project->delete($id)) {
        echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
    }
    else{
      redirect('administration/projects/index');
    }
  }

  /**
   * Hide se lance avec une requête ajax
   * Il va  masquer un projet qui était publié
   * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
   * 
   * @return string
   */
  public function hide()
  {
    if (!empty($this->input->post('projId'))) {
      $id = $this->input->post('projId');
      if ($this->project->hide_item($id)) {
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
   * Il va  publier un projet qui était masqué après avoir vérifié qu'il ne soit pas lié à une catégorie masquée
   * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
   * 
   * @return string
   */
  public function show()
  {
    if (!empty($this->input->post('projId')) && !empty($this->input->post('catId'))) {
      $id = $this->input->post('projId');
      $category_id = $this->input->post('catId');
      if (!$this->category->find_item('id = '.$category_id.' AND visibility = 1')) {
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        if ($this->project->show_item($id)) {
          echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
        }
        else{
          echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
        }
      }
    }
    else{
      redirect('administration/projects/index');
    }
  }

  /**
   * Permet la création d'une nouvelle instance de project
   */
  public function new()
  {
    $this->data['pagetitle'] = 'Administration - créer un projet';
    $this->data['h1_title'] = 'Créer un projet';
    $avaible_categories = $this->category->list_item();
    $optionsCat[''] = '--- Sélectionnez une catégorie ---';
    if (count($avaible_categories) > 1) {
      foreach ($avaible_categories as $cat) {
        $optionsCat[$cat->id]= $cat->title;
      };
    }
    else{
      $optionsCat[$avaible_categories->id] = $avaible_categories->title;
    }
    
    $this->data['opt_categories'] = $optionsCat;

    if ($this->form_validation->run() === FALSE){
      $this->render('admin/form_new_project_view', 'admin/admin_master');
    }
    else{
      if (!empty($this->input->post('title')) && !empty($this->input->post('category_id')) || !empty($this->input->post('context')) || !empty($this->input->post('description')) ){
        $form = array( 
          'title'       =>$this->input->post('title'),
          'category_id' =>$this->input->post('category_id'),
          'context'     =>$this->input->post('context'),
          'description' =>$this->input->post('description')
        );

        if (!empty($this->input->post('external_link'))) {
          $form['external_link'] = $this->input->post('external_link');
        }

        if(!$this->project->create($form)){
          $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, le projet \"".$form['title']."\" n'a pas été enregistrée.");
          $this->render('admin/form_new_project_view', 'admin/admin_master');
        }
        else{
          $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "La nouveau projet \"".$form['title']."\" a bien été enregistré."));
          redirect('administration/projects/index');
        }
      }
      else{
        $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, les données du nouveau projet n'ont pas été envoyées.");
        $this->render('admin/form_new_project_view', 'admin/admin_master');
      }
    }
  }

 /**
  * Edit permet de modifier les informations d'un projet déjà existant
  * @param integer $target id du projet a modifier
  */
  public function edit($target){
    $project = $this->project->get_item($target);

    // Le paramètre doit être valide, sinon un message d'erreur est retourné
    if ($target == NULL || $project == FALSE) {
      $this->session->set_flashdata('result_message', array('state'=>'error', 'content'=> "Vous ne pouvez pas modifier un projet qui n'existe pas !"));
      redirect('administration/projects/index');
    }

    $this->data['pagetitle'] = 'Administration - modifier un projet';
    $this->data['h1_title'] = 'Modififier un projet';

    $this->data['id'] = $project->id;
    $this->data['title'] = $project->title;
    $this->data['category_id'] = $project->category_id;
    $this->data['context'] = $project->context;
    $this->data['description'] = $project->description;
    $this->data['external_link'] = $project->external_link;
    $this->data['visibility'] = $project->visibility;

    $avaible_categories = $this->category->list_item();
    $optionsCat[''] = '--- Sélectionnez une catégorie ---';
    foreach ($avaible_categories as $cat) {
        $optionsCat[$cat->id]= $cat->title;
    };
    $this->data['opt_categories'] = $optionsCat;

    if($this->form_validation->run('editProject') === FALSE){
      $this->render(array('admin/actions_edit_project_view','admin/form_edit_project_view'), 'admin/admin_master');
    }
    else{
      $form = array();

      // Crée un tableau associatif des données modifiées
      foreach ($project as $key => $value) {
        if (array_key_exists($key, $this->input->post()) && $this->input->post($key) != $value) {
          $form[$key] = $this->input->post($key);
        }
      }

      if (isset($form['title'])) {
        $project_title = $form['title'];
      }
      else{
        $project_title = $project->title;
      }

      if (!$this->project->update($form, $project->id)) {
        $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, le projet \"".$project_title."\" n'a pas été modifié.");
        $this->render(array('admin/actions_edit_project_view','admin/form_edit_project_view'), 'admin/admin_master');
      }
      else{
        $this->data['result_message'] = array('state'=>'success', 'content'=> "Le projet \"".$project_title."\" a bien été modifié.");
        $this->render(array('admin/actions_edit_project_view','admin/form_edit_project_view'), 'admin/admin_master');
      }
    }
  }

  /**
   * Permet d'afficher la liste des projets déjà créer
   * et d'effectuer des modifications
   * @return type
   */
  public function index()
  {
    $this->data['pagetitle'] = 'Administration - gestion des projets';
    $this->data['h1_title'] = 'Gestion des projets';

    $this->render('admin/table_project_view', 'admin/admin_master');
  }
}