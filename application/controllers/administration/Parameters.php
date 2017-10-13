<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Contrôleur Parameters gère les options du site.
 * Il a pour rôle de permettre la gestion des données saisies par l'utilisateur.
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Parameters extends MY_Controller {

  /**
   * Vérifie que l'utilisateur est connecté, sinon le renvoie vers le login.
   * Il contrôle également que seul un administrateur accède à cette zone.
   * Initialise les paramètres standards du contrôleur
   * - le modèle parameter
   * - le helper form
   * - la librairie form_validation (app/config/form_validation)
   * - la gestion des messages d'erreur
   * 
   */  
  public function __construct()
  {
    parent::__construct();
    
    if ($this->user->is_logged_in() === FALSE) {
        redirect('administration/dashboard/login');
    };

    if ($this->user->is_admin() === FALSE) {
      redirect('administration/dashboard');
    };

    $this->load->helper('form');
    $this->load->library('form_validation');
    if ($this->session->flashdata('result_message') !== NULL) {
      $this->data['result_message'] = $this->session->flashdata('result_message');
    }
  }

  /**
   * L'index retourne la vue du formulaire de gestion des paramètres
   */
  public function index()
  {
    $this->data['pagetitle'] = 'Administration - Paramètres du site';
    $this->data['h1_title'] = 'Gestion des paramètres du site';
    $this->data['site_name'] = $this->site_parameter->site_name;
    $this->data['site_description'] = $this->site_parameter->site_description;
    $this->data['site_author'] = $this->site_parameter->site_author;
    if($this->form_validation->run() === FALSE){
      $this->render('admin/form_edit_parameters_view', 'admin/admin_master');
    }
    else{
      $form = array(
        'site_name' => $this->input->post('site_name'),
        'site_description' => $this->input->post('site_description'),
        'site_author' => $this->input->post('site_author')
      );

      if ($this->parameter->update_parameter($form)) {
        $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "Vos paramètres ont bien été mise à jour."));
        redirect('administration/parameters');
      }
      else{
        $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite durant la mise à jour de vos paramètres.");
        $this->render('admin/form_edit_parameters_view', 'admin/admin_master');
      }
    }
    
  }
}