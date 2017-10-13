<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Modèle Category traite les données liées aux catégories de projets.
 * Il hérite du modèle app/core/MY_Model
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Category extends MY_Model {
  protected $_table = 'project_category';

  public function __construct()
  {
    parent::__construct();
    log_message('info','Category Model initialised.');
  }

  /**
   * Crée une instance de category à partir d'un tableau associatif
   * 
   * @param array $data 
   * @return bool
   */
  public function create($data)
  {
    if(array_key_exists('title', $data)){
      if (!$this->insert_item($data)) {
        return FALSE;
      }
      else{
        return TRUE;
      }
    }
    else{
      return FALSE;
    }
  }

  /**
   * Met à jour le titre d'une instance category
   * @param array $data 
   * @return bool
   */
  public function update($data)
  {
    if (array_key_exists('id', $data) && array_key_exists('title', $data)) {
      if ( !$this->update_item(array('title' => $data['title']), $data['id']) ) {
        return FALSE;
      }
      else{
        return TRUE;
      }
    }
    else{
      return FALSE;
    }
  }

  /**
   * Supprime une instance category
   * @param int $id 
   * @return bool
   */
  public function delete($id)
  {
    if ( !$this->item_delete($id) ) {
      return FALSE;
    }
    else{
      return TRUE;
    }
  }
  
}