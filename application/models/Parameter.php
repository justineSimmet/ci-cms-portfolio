<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Modèle Parameter traite les options du site.
 * Il hérite du modèle app/core/MY_Model
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Parameter extends MY_Model {
  protected $_table = 'parameter';

  public function __construct()
  {
    parent::__construct();
    log_message('info','Parameter Model initialised.');
  }

  public function get_parameter()
  {
    return $this->get_item('1');
  }

  public function update_parameter($data)
  {
    return $this->update_item($data, '1');
  }
}