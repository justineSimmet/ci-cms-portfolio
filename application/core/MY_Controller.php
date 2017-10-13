<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Contrôleur MY_Controller étend le modèle standard de Codeigniter.
 * Il est utilisé pour mettre en place la gestion de templates, retourner les paramètres du site
 * et gérer l'accès administrateur.
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class MY_Controller extends CI_Controller
{
  protected $data = array();

  /**
   * Instancie le contrôleur
   * Définit les Constantes utilisateur
   * Vérifie le statut de l'utilisateur connecté
   * 
   */
  function __construct()
  {
    parent::__construct();
    $this->load->model('parameter');

    $this->site_parameter = $this->parameter->get_parameter();

    define('SITE_NAME', $this->site_parameter->site_name);
    define('SITE_AUTHOR', $this->site_parameter->site_author);
    define('SITE_DESCRIPTION', $this->site_parameter->site_description);

    $this->data['pagetitle'] = SITE_NAME;
    if ($this->user->is_admin() === FALSE) {
        $this->data['admin'] = FALSE;
    }
    else{
        $this->data['admin'] = TRUE;
    }
  }

  /**
   * La fonction render initialise l'appel des vues par rapport au template
   * Il permet également d'instancier des retour de type JSON
   * 
   * @param mixed $the_view   Une seul vue -> string | Plusieurs vues -> array
   * @param string $template  Nom du template
   * @return Charge le template désigné
   */
  protected function render($the_view = NULL, $template = 'front/front_master')
  {
    if($template == 'json' || $this->input->is_ajax_request())
    {
      header('Content-Type: application/json');
      echo json_encode($this->data);
    }
    elseif(is_null($template))
    {
      $this->load->view($the_view,$this->data);
    }
    elseif (is_array($the_view)) {
      $this->data['the_view_content'] = array();
      foreach ($the_view as $view) {
        array_push($this->data['the_view_content'], $this->load->view($view,$this->data, TRUE));
      }
      $this->load->view('templates/'.$template, $this->data);
    }
    else
    {
      $this->data['the_view_content'] = (is_null($the_view)) ? '' : $this->load->view($the_view,$this->data, TRUE);
      $this->load->view('templates/'.$template, $this->data);
    }
  }
}

