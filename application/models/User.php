<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Modèle User traite les données liées aux utilisateurs.
 * Il hérite du modèle app/core/MY_Model
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class User extends MY_Model {

  protected $_table = 'user';

  /**
   * Charge la librairie bcrit (app/library/bcrypt)
   */
  public function __construct()
  {
    parent::__construct();
    $this->load->library('bcrypt');
    log_message('info','User Model initialised.');
  }

  /**
   * S'appuie sur la librarie Bcryp pour hasher le mot de passe en paramètre
   * @param string $password 
   * 
   * @throws bool FALSE en cas d'erreur
   * @return string le mot passe hashé
   */
  public function hash_password($password)
  {
    if (empty($password)) {
      return FALSE;
    }
    else{
      return $this->bcrypt->hash($password);
    }
  }

  /**
   * Use the Bcrypt library to verify the password set in param
   **/
  /**
   * Utilise la librairie Bcryp pour vérifier le mot de passe en paramètre par rapport à celui enregistré en bdd
   * @param int $id 
   * @param string $password
   * 
   * @return bool
   */
  private function check_password($id, $password)
  {
    // Get user password by is id
    $query = $this->db->select('password')
                      ->where('id', $id)
                      ->limit(1)
                      ->order_by('id','desc')
                      ->get($this->_table);
    $password_db = $query->row();
    if ($query->num_rows() !== 1) {
      return FALSE;
    }
    // Use the function verify to check if the input password is correct
    if ($this->bcrypt->verify($password,$password_db->password)) {
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

  /**
   * A partir des données saisies par l'utilisateur, va valider ou non sa connexion
   * @param string $email 
   * @param string $username 
   * @param string $password 
   * @return bool
   */  
  public function login($email, $username, $password)
  {
    if( empty($email) || empty($username) || empty($password)){
      return FALSE;
    }
    // L'existence de l'utilisateur en bdd se vérifie avec son username et son email
    $control_values = array('username'=> $username, 'email'=> $email);

    $query = $this->db->select('id, username, email')
                      ->where($control_values)
                      ->limit(1)
                      ->order_by('id','desc')
                      ->get($this->_table);

    // Si la requête a un résultat, l'utilisateur est enregistré en bdd                
    if ($query->num_rows() === 1) {
      $user = $query->row();
      // Vérifie la validité du mot de passe saisi
      if ($this->check_password($user->id, $password) === TRUE) {
        // Initialise la session de l'utilisateur
        $this->set_session($user);

        // Met à jour sa dernière connexion en bdd
        $this->update_last_login($user->id);
        return TRUE;
      }
    }
    else{
      return FALSE;
    }
  }


  /**
   * Utilise la gestion des sessions de CI pour enregistrer la connexion de l'utilisateur en BDD
   * @param object $user 
   * @return bool
   */
  private function set_session($user)
  {

    $session_data = array(
      'user_id'    => $user->id,
      'username'   => $user->username,
      'email'      => $user->email,
      'last_check' => time()
    );

    $this->session->set_userdata($session_data);

    return TRUE;
  }

  /**
   * Mets à jours la dernière connexion en bdd
   * @param int $id 
   * @return bool
   */
  private function update_last_login($id)
  {
    $this->db->update($this->_table, array('last_login' => time()), array('id' => $id));
    return TRUE;
  }

  /**
   * Va détruire la session en cours
   * @return bool
   */
  public function logout()
  {
    $this->session->unset_userdata( array('username', 'email', 'last_check', 'user_id'));
    $this->session->sess_destroy();
    session_start();
    $this->session->sess_regenerate(TRUE);

    return TRUE;
  }

  /**
   * Vérifie que l'utilisateur est bien connecter
   * 
   * @throws bool retourne FALSE si la vérification de session a échouée et déconnecte l'utilisateur
   * @return void
   */
  public function is_logged_in()
  {
    $user_session = $this->check_session('last_check');
    if (!$user_session) {
      $this->logout();
      return FALSE;
    }
  }

  /**
   * Vérifie la sessions dans deux cas de figure définit par les paramètres
   * - last-check : vérifie que l'utilisateur n'est pas inactif depuis plus de 2h
   * - status : vérifie si l'utilisateur est admin ou non
   * @param string $param 
   * @return type
   */
  private function check_session($param = 'last_check')
  {
    if($param === 'last_check'){
      $last_login = $this->session->userdata('last_check');
      // Vérifie que la dernière activité remonte à moins de 2h
      if (($last_login+7200)  > time()) {
        // Récupère les données de sessions de l'utilisateur
        $control_values = array('username'=> $this->session->userdata('username'), 'email'=> $this->session->userdata('email'));

        $query = $this->db->select('id')
                      ->where($control_values)
                      ->limit(1)
                      ->order_by('id','desc')
                      ->get($this->_table);
        // Si les données de sessions correspondent en bbd, la connexion est validée
        if ($query->num_rows() === 1) {
          $this->session->set_userdata('last_check', time());
          return TRUE;
        }
        // Sinon les données de sessions sont effacées
        else{
          $this->session->unset_userdata( array('username', 'email', 'last_check', 'user_id'));
          return FALSE;
        }
      }
      $this->session->unset_userdata( array('username', 'email', 'last_check', 'user_id'));
      return FALSE;
    }
    elseif ($param === 'status') {
      $control_values = array('id'=>$this->session->userdata('user_id'), 'username'=> $this->session->userdata('username'), 'email'=> $this->session->userdata('email'));

      $query = $this->db->select('is_admin')
                      ->where($control_values)
                      ->limit(1)
                      ->order_by('id','desc')
                      ->get($this->_table);

      // Vérifie que la sessions est correcte
      if ($query->num_rows() === 1) {
        // Vérifie le statut d'administrateur
        if ($query->row()->is_admin === '1' ) {
          return TRUE;
        }
        else{
          return FALSE;
        }
      }
      // Si la sessions est incorrecte l'utilisateur est déconnecté
      else{
        $this->logout();
      }
    }
    else{
      return FALSE;
    }
  }

  /**
   * Vérifie si un utilisateur est administrateur
   * @return void
   */
  public function is_admin()
  {
    if ($this->check_session('status') == FALSE || $this->check_session('status') == NULL) {
      return FALSE;
    }
    else{
      return TRUE;
    }
  }

  /**
   * Enregistre un nouvel utilisateur en bbd
   * @param string $username 
   * @param string $password 
   * @param string $email 
   * @param string|null $first_name 
   * @param string|null $last_name 
   * @param int $is_admin 
   * 
   * @return bool
   */
  public function create($username, $password, $email, $first_name = NULL, $last_name = NULL, $is_admin = 0)
  {
    if(empty($username) || empty($password) || empty($email)){
      return FALSE;
    }

    $password = $this->hash_password($password);

    $data = array(
      'username'   => $username,
      'password'   => $password,
      'email'      => $email,
      'first_name' => $first_name,
      'last_name'  => $last_name,
      'is_admin'  => $is_admin
    );

    if ($this->insert_item($data) === FALSE) {
      return FALSE;
    }
    else{
      return TRUE;
    }
  }

  /**
   * Met à jours les données entrées en paramètre
   * @param int $id 
   * @param array $data 
   * @return bool
   */
  public function update_profil($id, array $data)
  { 
    if (array_key_exists('new_password', $data)) {
      $new_password = $data['new_password'];
      $password = $data['password'];
      if (!empty($password) && !empty($new_password)){
        if ($this->check_password($id, $password)) {

          $hash = $this->hash_password($new_password);

          $data['password'] = $hash;
          unset($data['new_password']);

          if ($this->update_item($data,$id) === FALSE) {
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
      else{
        return FALSE;
      }
    }
    else{
      if ($this->check_password($id, $data['password'])) {
        unset($data['password']);
        if ($this->update_item($data,$id) === FALSE) {
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
  }

  /**
   * Supprime un utilisateur en bdd
   * @param string $id [id de l'utilisateur]
   * @return bool [succès ou non]
   */
  public function delete($id)
  {
    if ($this->delete_item($id) === FALSE) {
      return FALSE;
    }
    else{
      return TRUE;
    }
  }

  /**
   * Associe le nom et prénom d'un utilisateur pour retourner son identité
   * Si ces données n'existent pas, retourne son nom d'utilisateur
   * @return string [identité de l'utilisateur]
   */
  public function getIdentity()
  {
    $user = $this->get_item($this->session->userdata('user_id'));
    if (empty($user->first_name) && empty($user->last_name)) {
      return $user->username;
    }
    else{
      return $user->first_name.' '.$user->last_name;
    }
  }
}

?>