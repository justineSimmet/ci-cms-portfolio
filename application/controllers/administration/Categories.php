<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Contrôleur Categories gère et dispatch les données du Modèle Category.
 * Il a pour rôle de permettre la gestion directe des categories de projet
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Categories extends MY_Controller {

  /**
   * Vérifie que l'utilisateur est connecté, sinon le renvoie vers le login.
   * Initialise les pramètres standards du contrôleur
   * - le modèle category
   * - le helper form
   * - la librairie form_validation (app/config/form_validation)
   * - la liste des categories enregistrée
   * - la gestion des messages d'erreur
   * 
   */  
  public function __construct()
  {
    parent::__construct();
    
    if ($this->user->is_logged_in() === FALSE) {
        redirect('administration/dashboard/login');
    };

    $this->load->model('category');
    $this->load->helper('form');
    $this->load->library('form_validation');
    $this->data['list_categories'] = $this->category->list_item();
    if ($this->session->flashdata('result_message') !== NULL) {
      $this->data['result_message'] = $this->session->flashdata('result_message');
    }
  }

  /**
  * Edit permet de modifier le titre d'une catégorie déjà existante
  * @param integer $target id de la catégorie a modifier
  */
  public function edit($target)
  {
    $category = $this->category->get_item($target);

    // Le paramètre doit être valide, sinon un message d'erreur est retourné
    if ($target == NULL || $category == FALSE) {
      $this->session->set_flashdata('result_message', array('state'=>'error', 'content'=> "Vous ne pouvez pas modifier une categorie qui n'existe pas !"));
      redirect('administration/categories/index');
    }

    $this->data['pagetitle'] = 'Administration - modifier une catégorie';
    $this->data['h1_title'] = 'Gestion des catégories';

    $this->data['id']    = $category->id;
    $this->data['title'] = $category->title;
    if($this->form_validation->run('editCategory') === FALSE){
      $this->render(array('admin/table_category_view','admin/form_edit_category_view'), 'admin/admin_master');
    }
    else{
      if(!empty($this->input->post('title')) && !empty($this->input->post('id'))){
        $form =  array(
          'id'    => $this->input->post('id'),
          'title' => $this->input->post('title')
        );
        if (!$this->category->update($form)) {
          $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, la catégorie \"".$form['title']."\" n'a pas été modifiée.");
          $this->render(array('admin/table_category_view','admin/form_edit_category_view'), 'admin/admin_master');
        }
        else{
          $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "La catégorie \"".$form['title']."\" a bien été modifiée."));
          redirect('administration/categories/index');
        }
      }
      else{
        $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, les nouvelles données de la catégorie \"".$form['title']."\" n'ont pas été envoyées.");
        $this->render(array('admin/table_category_view','admin/form_edit_category_view'), 'admin/admin_master');
      }
    }
  }

 /**
  * Delete se lance avec une requête ajax
  * Il va supprimer une categorie via son id
  * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
  * 
  * @return string
  */
  public function delete()
  {
    if (!empty($this->input->post('catId'))) {
      $id = $this->input->post('catId');
      if ($this->category->delete_item($id)) {
        echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
    }
    else{
      redirect('administration/categories');
    }
  }

 /**
  * Show se lance avec une requête ajax
  * Il va  publier une categorie qui était masquée
  * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
  * 
  * @return string
  */
  public function show()
  {
    if (!empty($this->input->post('catId'))) {
      $id = $this->input->post('catId');
      if ($this->category->show_item($id)) {
        echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
    }
    else{
      redirect('administration/categories');
    }
  }

 /**
  * Hide se lance avec une requête ajax
  * Il va masquer une categorie qui était publiée
  * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
  * 
  * @return string
  */
  public function hide()
  {
    if (!empty($this->input->post('catId'))) {
      $id = $this->input->post('catId');
      if ($this->category->hide_item($id)) {
        echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
      }
      else{
        echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
      }
    }
    else{
      redirect('administration/categories');
    }
  }

  /**
   * Permet de visualiser et d'agir sur l'ensemble des catégories créées
   * et d'en enregistrer une nouvelle.
   */
  public function index()
  {
    $this->data['pagetitle'] = 'Administration - gestion des categories';
    $this->data['h1_title'] = 'Gestion des categories';

    if ($this->form_validation->run() === FALSE){
      $this->render(array('admin/table_category_view','admin/form_new_category_view'), 'admin/admin_master');
    }
    else{
      if (!empty($this->input->post('title'))) {
        $form['title'] =$this->input->post('title');

        if (!$this->category->create($form)) {
          $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, la nouvelle catégorie n'a pas été enregistrée.");
          $this->render(array('admin/table_category_view','admin/form_new_category_view'), 'admin/admin_master');
        }
        else{
          $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "La nouvelle catégorie \"".$form['title']."\" a bien été enregistrée."));
          redirect('administration/categories/index');
        }
      }
      else{
        $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, les données de la nouvelle catégorie n'ont pas été envoyées.");
        $this->render(array('admin/table_category_view','admin/form_new_category_view'), 'admin/admin_master');
      }
    }
  }

}