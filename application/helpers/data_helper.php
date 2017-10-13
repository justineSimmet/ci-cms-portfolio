<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Récupère les données de sessions en BDD
 * et retourne un tableau des données du 'blob'
 * @param blob $session_data [données stockées sur les sessions]
 * @return array [données formatées en tableau]
 */
function decode_ci_sessions($session_data){
  $return_data = array();  // tableau de stockage finale
           
  $offset = 0;
  while ($offset < strlen($session_data)) 
  {
     if (!strstr(substr($session_data, $offset), "|")){
      // Si le blob ne correspond pas au format attendu, retourne un exception
      throw new Exception("Donnée invalide : " . substr($session_data, $offset));
    }

    $pos = strpos($session_data, "|", $offset); 
    $num = $pos - $offset;
    $varname = substr($session_data, $offset, $num);
    $offset += $num + 1;
    $data = unserialize(substr($session_data, $offset));
    $return_data[$varname] = $data;  
    $offset += strlen(serialize($data));
  }

  return $return_data;
}
