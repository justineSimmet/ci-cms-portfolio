<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Contrôleur Home gère toute la partie publique du site
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Home extends MY_Controller {

  /**
   * Instancie les models standard de l'app
   * Affiche une adminbar pour les utilisateurs connectés
   * 
   */
  public function __construct()
  {
    parent::__construct();
    if ($this->user->is_logged_in() !== FALSE) {
      $this->load->view('templates/front/_parts/front_master_adminbar');
    }

    $this->load->model('category');
    $this->load->model('project');
    $this->load->model('picture');
  }

  /**
   * Redirige les visiteurs pour une gestion plus simple des urls
   */
	public function _remap()
	{
    $segment_1 = $this->uri->segment(1);
      switch ($segment_1) {
        case NULL:
        case FALSE:
        case 'site':
        case 'index':
          $this->index();
        break;
        
        case 'project':
          $this->project($this->uri->segment(2));
        break;          

        case 'login':
        case 'connexion':
          redirect('administration/dashboard/login');
        break;

        default:
          show_404();
        break;
      }
	}

  /**
   * Retourne les information du projets ciblé par le visiteur
   * Gère la navigation entre projets
   * Contrôle l'url d'accès à la page. Si elle ne correspond pas à un projet du portfolio ou un projet masqué,
   * le visiteur est redirigé vers la page d'accueil.
   * 
   * @param string $public_url [url d'accès à la page]
   */
  public function project($public_url)
  { 
    $project = $this->project->get_item($public_url, 'public_url');

    if ($project == NULL && $project == FALSE || $project->visibility == 0) {
      redirect();
    }

    $this->data['pagetitle'] = 'Projet';
    $this->data['id'] = $project->id;
    $this->data['title'] = $project->title;
    $this->data['category'] = $this->category->get_item($project->category_id)->title;    
    $this->data['context'] = $project->context;
    $this->data['description'] = $project->description;
    $this->data['external_link'] = $project->external_link;
    $this->data['page_description'] ="Ceci est le projet ".$project->title." de la catégorie ".$this->category->get_item($project->category_id)->title.". Il est issu du portfolio de ".SITE_AUTHOR;

    $this->data['gallery'] = $this->picture->find_item('project_id ='.$project->id.' AND visibility=1', 'gallery_order ASC');
    if (count($this->project->list_item()) > 1) {
      $this->data['previous_project'] = $this->project->find_item("public_url < '".$project->public_url."' AND public_url NOT LIKE '".$project->public_url."' AND visibility=1", 'title DESC', '1');
      $this->data['next_project'] = $this->project->find_item("public_url > '".$project->public_url."' AND public_url NOT LIKE '".$project->public_url."' AND visibility=1", 'title ASC', '1');
    }

    $this->render('front/project_view');
  }

  /**
   * Affiche le contenu de la page d'accueil du site
   * Retourne les données liées à l'affichage des projets
   * 
   */
	public function index()
	{  
    $this->data['avaible_categories'] = $this->category->list_item('visibility = 1', 'title ASC');
    $this->data['avaible_projects'] = $this->project->list_item('visibility = 1', 'title ASC');
    if ($this->data['avaible_projects'] !== NULL && $this->data['avaible_projects'] !== FALSE) {
      if (count($this->data['avaible_projects']) == 1) {
        $this->data['avaible_projects']->main_picture = $this->picture->find_item('project_id = '.$this->data['avaible_projects']->id.' AND visibility = 1','gallery_order ASC', '1' );
      }
      else{
        foreach ($this->data['avaible_projects'] as $project) {
          $project->main_picture = $this->picture->find_item('project_id = '.$project->id.' AND visibility = 1','gallery_order ASC', '1' );
        };
      }
    }
    
    $this->render('front/homepage_view');
	}
}
