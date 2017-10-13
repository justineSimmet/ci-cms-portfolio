<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Contrôleur User gère et dispatch les données du Modèle user.
 * Il a pour rôle de permettre la gestion des utilisateurs sur le site
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Users extends MY_Controller {

    /**
     * Vérifie que l'utilisateur est connecté, sinon le renvoie vers le login.
     * Initialise les pramètres standards du contrôleur
     * - le helper form
     * - la librairie form_validation (app/config/form_validation)
     * - la liste des utilisateurs
     * - la gestion des messages d'erreur
     * 
     */
    public function __construct()
    {
        parent::__construct();
        
        if ($this->user->is_logged_in() === FALSE) {
            redirect('administration/dashboard/login');
        };

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['list_users'] = $this->user->list_item();
        if ($this->session->flashdata('result_message') !== NULL) {
          $this->data['result_message'] = $this->session->flashdata('result_message');
        }
    }

   /**
    * Profil permet à un utilisateur de gérer ses informations personnelles
    * et de modifier son mot de passe.
    */
    public function profil(){
      $session_user = $this->session->userdata('user_id');
      $target_user = $this->user->get_item($session_user);
      $this->data['pagetitle'] = 'Administration - Profil';
      $this->data['h1_title'] = 'Gérer votre profil';

      // Envoie à la vue les informations de l'utilisateur
      $this->data['id'] = $target_user->id;
      $this->data['username'] = $target_user->username;
      $this->data['first_name'] = $target_user->first_name;
      $this->data['last_name'] = $target_user->last_name;
      $this->data['email'] = $target_user->email;

      if($this->form_validation->run() === FALSE){
        $this->render('admin/profil_user_view', 'admin/admin_master');
      }
      else{
        // Vérifie si une modification du mot de passe a lieu
        if(!empty($this->input->post('new_password'))){
          if (empty($this->input->post('valid_password'))) {
            $this->data['result_message'] = array('state'=>'error', 'content'=> "Vous devez confirmez votre nouveau mot de passe pour effectuer son changement et l'enregistrement de vos modifications/");
            $this->render('admin/profil_user_view', 'admin/admin_master');
          }
          else{
            // Initialise les données à modifier dans un tableau associatif
            $form = array(
              'password'       => $this->input->post('password'),
              'new_password'   => $this->input->post('new_password')
            );
            if ($form['new_password'] == $this->input->post('valid_password')) {

              // Set the other update information
              if ($this->input->post('username') != $this->data['username']) {
                $form['username'] = $this->input->post('username');
              }

              if ($this->input->post('first_name') != $this->data['first_name']) {
                $form['first_name'] = $this->input->post('first_name');
              }

              if ($this->input->post('last_name') != $this->data['last_name']) {
                $form['last_name'] = $this->input->post('last_name');
              }

              if ($this->input->post('email') != $this->data['email']) {
                $form['email'] = $this->input->post('email');
              }

              // Utilise la fonction update_profil du modèle
              if ($this->user->update_profil($this->input->post('id'), $form)) {
                $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "Vos informations ont bien été mise à jour."));
                redirect('administration/users/profil');
              }
              else{
                $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite durant la mise à jour de vos informations.");
                $this->render('admin/profil_user_view', 'admin/admin_master');
              }
            }
            else{
              $this->data['result_message'] = array('state'=>'error', 'content'=> "Votre confirmation de mot de passe doit être identique au nouveau mot de passe.");
              $this->render('admin/profil_user_view', 'admin/admin_master');
            }
          }
        }
        // Si le mot de passe ne change pas
        else{
          // Initialise l'ensemble des données dans un tableau
          $form = array(
            'password' => $this->input->post('password')
          );

          if ($this->input->post('username') != $this->data['username']) {
            $form['username'] = $this->input->post('username');
          }

          if ($this->input->post('first_name') != $this->data['first_name']) {
            $form['first_name'] = $this->input->post('first_name');
          }

          if ($this->input->post('last_name') != $this->data['last_name']) {
            $form['last_name'] = $this->input->post('last_name');
          }

          if ($this->input->post('email') != $this->data['email']) {
            $form['email'] = $this->input->post('email');
          }

          if ($this->user->update_profil($this->input->post('id'), $form)) {
            $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "Vos informations ont bien été mise à jour."));
            redirect('administration/users/profil');
          }
          else{
            $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite durant la mise à jour de vos informations.");
            $this->render('admin/profil_user_view', 'admin/admin_master');
          }
        }

      }

    }

   /**
    * Edit permet aux administrateur de modifier les informations d'un utilisateur
    * @param integer $target id de l'utilisateur a modifier
    */
    public function edit($target){
      if ($this->user->is_admin() === FALSE) {
        redirect('administration/dashboard');
      };

      $user = $this->user->get_item($target);

      // Le paramètre doit être valide, sinon un message d'erreur est retourné
      if ($target == NULL || $user == FALSE) {
        $this->session->set_flashdata('result_message', array('state'=>'error', 'content'=> "Vous ne pouvez pas modifier un utilisateur qui n'existe pas !"));
        redirect('administration/users');
      }

      $this->data['pagetitle'] = 'Administration - modifier un utilisateur';
      $this->data['h1_title'] = 'Gestion des utilisateurs';

      // Initialise les données de l'utilisateur cible
      $this->data['id'] = $user->id;
      $this->data['username'] = $user->username;
      $this->data['first_name'] = $user->first_name;
      $this->data['last_name'] = $user->last_name;
      $this->data['email'] = $user->email;
      $this->data['is_admin'] = $user->is_admin;

      if($this->form_validation->run('editUser') === FALSE){
        $this->render(array('admin/table_user_view','admin/form_edit_user_view'), 'admin/admin_master');
      }
      else{
        // Initialise l'ensemble des données dans un tableau
        $form = array();

        if($this->input->post('username') !== $this->data['username']){
          $form['username'] = $this->input->post('username');
        }

        if($this->input->post('first_name') !== $this->data['first_name']){
          $form['first_name'] = $this->input->post('first_name');
        }

        if($this->input->post('last_name') !== $this->data['last_name']){
          $form['last_name'] = $this->input->post('last_name');
        }

        if($this->input->post('email') !== $this->data['email']){
          $form['email'] = $this->input->post('email');
        }

        if ($this->input->post('is_admin') != 1) {
            $form['is_admin'] = 0;
        }
        else{
          $form['is_admin'] = $this->input->post('is_admin');
        }

        if(!$this->user->update_item($form, $this->input->post('id'))){
          $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, l'utilisateur ".$this->data['username']." n'a pas été modifié.");
          $this->render(array('admin/table_user_view','admin/form_edit_user_view'), 'admin/admin_master');
        }
        else{
          $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "L'utilisateur ".$this->data['username']." a bien été modifié."));
          redirect('administration/users');
        }
      }
    }

   /**
    * Delete s'éxécute avec une requête ajax
    * Il va supprimer l'utilisateur ciblé par la requête,
    * et retourner en JSON le résultat de son action et le nouveau token CSRF qui a été généré
    * 
    * @return string
    */
    public function delete()
    {
      if (!empty($this->input->post('userId')) && !empty($this->input->post('action')) && $this->input->post('action') == 'deleteUser') {
        $id = $this->input->post('userId');
        if ($this->user->delete($id)) {
          echo json_encode(array('result' => TRUE, 'new_token'=> $this->security->get_csrf_hash()));
        }
        else{
          echo json_encode(array('result' => FALSE, 'new_token'=> $this->security->get_csrf_hash()));
        }
      }
      else{
        redirect('administration/users');
      }
    }


   /**
    * L'index permet aux administrateur d'enregister un nouvel utilisateur
    * et d'accéder aux actions disponibles pour les utilisateurs déjà enregistré
    * @return type
    */
    public function index()
    {
        if ($this->user->is_admin() === FALSE) {
          redirect('administration/dashboard');
        };

        $this->data['pagetitle'] = 'Administration - gestion des utilisateurs';
        $this->data['h1_title'] = 'Gestion des utilisateurs';        
        
        if ($this->form_validation->run() === FALSE){
          $this->render(array('admin/table_user_view','admin/form_new_user_view'), 'admin/admin_master');
        }
        else{
          $form = array(
            'username'   => $this->input->post('username'),
            'email'      => $this->input->post('email'),
            'password'   => $this->input->post('password'),
          );

          if(empty($this->input->post('first_name'))){
            $form['first_name'] = NULL;
          }
          else{
            $form['first_name'] = $this->input->post('first_name');
          }

          if(empty($this->input->post('last_name'))){
            $form['last_name'] = NULL;
          }
          else{
            $form['last_name'] = $this->input->post('last_name');
          }

          if ($this->input->post('is_admin') != 1) {
            $form['is_admin'] = 0;
          }
          else{
            $form['is_admin'] = $this->input->post('is_admin');
          }

          $create = $this->user->create($form['username'], $form['password'], $form['email'], $form['first_name'], $form['last_name'], $form['is_admin']);
          if (!$create) {
            $this->data['result_message'] = array('state'=>'error', 'content'=> "Une erreur s'est produite, le nouvel utilisateur n'a pas été enregistré.");
            $this->render(array('admin/table_user_view','admin/form_new_user_view'), 'admin/admin_master');
          }
          else{
            $this->session->set_flashdata('result_message', array('state'=>'success', 'content'=> "Le nouvel utilisateur a bien été enregistré."));
            redirect('administration/users');
          }
        }
    }

}