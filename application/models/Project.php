<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Modèle Project traite les données liées aux projets.
 * Il hérite du modèle app/core/MY_Model
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Project extends MY_Model {
  protected $_table = 'project';

  public function __construct()
  {
    parent::__construct();
    log_message('info','Project Model initialised.');
  }

  /**
   * Crée une nouvelle instance de project en base de donnée
   * ainsi que son dossier destiné à accueillir les visuels du projet
   * 
   * @param array $data tableau associatif des données à insérer 
   * @return bool
   */
  public function create($data)
  {
    if (array_key_exists('title', $data) && array_key_exists('description', $data) && array_key_exists('context', $data)) {
      $data['public_url'] = friendly_url($data['title']);
      $new_item = $this->insert_item($data);
      if (!$new_item) {
        return FALSE;
      }
      else{
        $this->create_folder($new_item);
        return TRUE;
      }
    }
    else{
      return FALSE;
    }
  }

  /**
   * Description
   * @param array $data tableau associatif des données à modifier
   * @param int $id id de l'instance à cibler
   * @return bool
   */
  public function update($data, $id)
  {
    if (array_key_exists('title', $data)) {
      $data['public_url'] = friendly_url($data['title']);
    }

    if (!$this->update_item($data, $id)) {
      return FALSE;
    }
    else{
      return TRUE;
    }
  }

  /**
   * Supprime un projet en base de donnée
   * ainsi que les visuels associés
   * @param string $id [id du projet] 
   * @return bool [succès ou non]
   */
  public function delete($id)
  {
    $path = FCPATH.'public/projects_pictures/p-'.$id;
    // Supprime le dossier p-$id
    if ($this->delete_folder($path)) {
      //Supprimer l'instance en bdd et par cascade toutes les instances picture qui y sont liées
      if ($this->delete_item($id)) {
        return TRUE;
      }
      else{
        return FALSE;
      }
    }
    else{
      return FALSE;
    }

  }

  /**
   * Créer un folder dans assets/images/projects afin de stocker les visuels qui seront associés au projet
   * @param int $id id de l'instance cible
   * @return bool
   */
  private function create_folder($id)
  {
    $file_location = FCPATH.'public/projects_pictures/p-'.$id;
    if(!file_exists($file_location)){
      $new_folder = mkdir($file_location, 0777, true);
      if (!$new_folder) {
        return FALSE;
      }
      else{
        return TRUE;
      }
    }
    else{
      return TRUE;
    }
  }

  /**
   * Supprime le dossier visuel physique du projet
   * @param string $path [chemin d'accès au dossier] 
   * @return bool [succès ou non]
   */
  private function delete_folder($path)
  {
    $files = glob($path . '/*');
    foreach ($files as $file) {
      is_dir($file) ? $this->delete_folder($file) : unlink($file);
    }
    if(rmdir($path)){
      return TRUE;
    }
    else{
      return FALSE;
    }
  }



  /**
   * Retourn le nombre total d'instance créées
   * @return int
   */
  public function count_total()
  {
    return $this->count_item();
  }

  /**
   * Retourne le nombre d'instance visible
   * @return int
   */
  public function count_publish()
  {
    return $this->count_item('visibility = 1');
  }

  /**
   * Retourne une liste des galeries projet
   * @return array
   */
  public function list_gallery()
  {
    $query = $this->db->select('id, title')
                      ->order_by('id','desc')
                      ->get($this->_table);
    $result = $query->result();
    if (count($result) == 1) {
      $result = reset($result);
    }
    return $result;
  }
}