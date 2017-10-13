<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * La classe Bcrypt permet de simplifier l'utilisation de fonctionnalités liées au hashage
 */
class Bcrypt {

  public function __construct(){
    $this->rounds = $this->generate_round();
  }

  /**
   * Hash un chaîne en s'appuyant sur l'algo BCRYPT
   * @param string $input [la chaîne à hasher]
   * @return mixed $hash|bool [la chaîne hashée ou false]
   */
  public function hash($input) {
    $options = [
      'cost' => $this->rounds
    ];
    $hash = password_hash($input, PASSWORD_BCRYPT, $options);
    if(strlen($hash) > 13) {
      return $hash;
    }

    return false;
  }

  /**
   * Va vérifier qu'une chaîne de caractères correspond à un hash
   * @param string  $input  [la chaîne a comparer]
   * @param string  $existingHash  [le hash de reférence]
   * @return bool  [le résultat de la comparaison]
     */
  public function verify($input, $existingHash) {
    return password_verify($input, $existingHash);
  }

  /**
   * Va calculer le coût optimal par rapport à la vitesse du serveur
   * @return type
   */
  private function generate_round(){
    $timeTarget = 0.05; // 50 millisecondes
    $cost = 8; //coût minimal
    do {
        $cost++;
        $start = microtime(true);
        password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
        $end = microtime(true);
    } while (($end - $start) < $timeTarget);
    return $cost;
  }
}
