<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Modèle Visitor traite les données liées aux enregistrements de sessions des visiteurs.
 * Il hérite du modèle app/core/MY_Model
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class Visitor extends MY_Model {

  protected $_table = 'ci_sessions';

  /**
   * Charge la librairie bcrit (app/library/bcrypt)
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->helper('data_helper');
    log_message('info','Visitor Model initialised.');
  }

  public function list_visitors()
  {
    $query = $this->db->select('timestamp, data')
                      ->order_by('timestamp','desc')
                      ->get($this->_table);
    if( $query->num_rows() == 0 ){
      return FALSE;
    }
    elseif ( $query->num_rows() == 1) {

      $result = $query->result();
      $result = reset($result);
      return $result;
    }
    else {
      $result =  $query->result();
      $arrayReturn = array();

      foreach ($result as $item) {
        $array['date'] = date("d/m/Y à\ H:i:s", $item->timestamp);
        $data = decode_ci_sessions($item->data);
        if (array_key_exists('__ci_user_platform', $data)) {
          $agent = $data['__ci_user_agent'].' sur '.$data['__ci_user_platform'];
          $array['agent'] = $agent; 
        }
        else{
          $array['agent'] = $data['__ci_user_agent'];
        }

        if (array_key_exists('username', $data)) {
          $array['identity'] = $data['username'];
        }
        else{
          $array['identity'] = 'anonyme';
        }

        array_push($arrayReturn, $array);
      }
      return $arrayReturn;
    }

  }

  public function visitors_time_stat(){

    $query = $this->db->select('data')
                      ->get($this->_table);
    if( $query->num_rows() == 0 ){
        return FALSE;
    }
    elseif ( $query->num_rows() == 1) {
      $result = $query->result();
      $result = reset($result);
      $arrayReturn = array();

      $decodeValues = decode_ci_sessions($result->data);
      $date = date("d-m-Y", $decodeValues['__ci_last_regenerate']);
      $arrayReturn['date'][] = $date;
      $arrayReturn['count'][] = 1;

      return $arrayReturn;
    }
    else {
      $result = $query->result();
      $arrayReturn = array();

      $arrayCount = array();
      foreach ($result as $item) {
        $decodeValues = decode_ci_sessions($item->data);
        $item = date("d-m-Y", $decodeValues['__ci_last_regenerate']);
        array_push($arrayCount, $item);
      }
      $arrayCount = array_count_values($arrayCount);

      foreach ($arrayCount as $key => $value) {
        $date = $key;
        $count = $value;
        $arrayReturn['date'][] = $date;
        $arrayReturn['count'][] = $count;
      }
        
      return $arrayReturn;
    } 
  }

  public function anonymous_time_stat(){
    $query = $this->db->select('data')
                      ->get($this->_table);
    if( $query->num_rows() == 0 ){
        return FALSE;
    }
    elseif ( $query->num_rows() == 1) {
      $result = $query->result();
      $result = reset($result);
      $arrayReturn = array();

      $decodeValues = decode_ci_sessions($result->data);
      if (!array_key_exists('username', $decodeValues)) {
        $date = date("d-m-Y", $decodeValues['__ci_last_regenerate']);
        $arrayReturn['date'][] = $date;
        $arrayReturn['count'][] = 1;
      }

      return $arrayReturn;
    }
    else{
      $result = $query->result();
      $arrayReturn = array();

      $arrayCount = array();
      foreach ($result as $item) {
        $decodeValues = decode_ci_sessions($item->data);
        if (!array_key_exists('username', $decodeValues)) {
          $item = date("d-m-Y", $decodeValues['__ci_last_regenerate']);
          array_push($arrayCount, $item);
        }
      }
      $arrayCount = array_count_values($arrayCount);

      foreach ($arrayCount as $key => $value) {
        $date = $key;
        $count = $value;
        $arrayReturn['date'][] = $date;
        $arrayReturn['count'][] = $count;
      }
      return $arrayReturn;
    }
  }

}
