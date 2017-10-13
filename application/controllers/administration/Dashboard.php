<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

  /**
   * Initialise les pramètres standards du contrôleur
   * - les modèles génériques du cms
   * - le helper data qui traduit les sessions en données
   * 
   */ 
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('data_helper');
        $this->load->model('visitor');
        $this->load->model('project');
        $this->load->model('category');
        $this->load->model('picture');
    }

    /**
     * Permet la connexion d'un utilisateur
     * Si l'utilisateur est déjà connecté -> le renvoie vers l'index
     * Si l'utilisateur entre des données incorrectes, lui retourne un message d'erreur
     */
    public function login()
    {
        if ($this->user->is_logged_in() !== FALSE) {

            redirect('administration/dashboard');
        }

        $this->load->library('form_validation');
        $this->data['pagetitle'] = 'Connexion à l\'administration';

        //Use $config from app/config/form_validation to check data
        if ($this->form_validation->run() === FALSE){
           $this->load->view('admin/login_view',$this->data);
        }
        else{
            $email = $this->input->post('email');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if($this->user->login($email, $username, $password)){
                redirect('administration/dashboard');
            }
            else{
                $this->data['result_message'] = array('state'=>'error', 'content'=> "Votre connexion a échouée, vérifiez vos informations.");
                $this->load->view('admin/login_view',$this->data);
            }
        }
        
    }

    /**
     * Permet à un utilisateur connecté de se déconnecter
     */
    public function logout()
    {
        if ($this->user->is_logged_in() === FALSE) {
            redirect('administration/dashboard/login');
        }

        $this->user->logout();
        redirect('administration/dashboard/login');

    }

    /**
     * Retourne un tableau de bord de l'administration
     * ainsi que des données d'analyse de fréquentation du site.
     */
    public function index()
    {
        if ($this->user->is_logged_in() === FALSE) {
            redirect('administration/dashboard/login');
        };

        $this->data['pagetitle'] = 'Administration';
        $current_user = $this->user->getIdentity();
        $this->data['h1_title'] = 'Tableau de bord';
        $this->data['h2_title'] = 'Coucou '.$current_user;
        $this->data['is_admin'] = $this->user->is_admin();
        $this->data['nbrUsers'] = $this->user->count_item();
        $this->data['nbrCategories'] = $this->category->count_item();
        $this->data['nbrProjects'] = $this->project->count_item();
        $this->data['nbrPictures'] = $this->picture->count_item();
        $this->data['visitors'] = $this->visitor->list_visitors();
        $this->data["visitsReport"] = $this->visitor->visitors_time_stat();
        $this->data["anonymousReport"] = $this->visitor->anonymous_time_stat();
        
        $this->render('admin/dashboard_view', 'admin/admin_master');
    }

}