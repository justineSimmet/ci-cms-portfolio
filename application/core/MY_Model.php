<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Le Modèle MY_Model étend le modèle standard de Codeigniter.
 * Son rôle est d'opérer des fonctions de CRUD standard
 * afin d'optimiser les appels à la BDD
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class MY_Model extends CI_Model {

    public function __construct(){

        parent::__construct();
    }

    
    /**
     * Récupère un ou des instances par rapport à un champs spécifique
     * 
     * @param mixed $value 
     * @param string $field
     * 
     * @throws bool False si pas de résultat 
     * @return array|object retourne un objet ou une liste d'objets
     */
    public function get_item($value, $field = 'id') {
        $this->db->where($field, $value);
        $query  = $this->db->get($this->_table);
        $result = $query->result();
        if ( count($result) == 0 ) {
            return FALSE;
        }
        elseif (count($result) == 1) {
            $result = reset($result);
            return $result;
        }
        else{
            return $result;
        }
    }

    /**
     * Récupère un ou des instances via plusieurs paramètres, si besoin.
     * Peut également utiliser un ordre de sortie en paramètre.
     * Si aucun paramètre n'est définit, ressort l'ensemble des données de la table
     * 
     * @param string $params 
     * @param string $orderby 
     * 
     * @throws bool False si pas de résultat 
     * @return array|object retourne un objet ou une liste d'objets
     */
    public function list_item($params= '', $orderby= ''){
        if( $params ){ $this->db->where($params); }
        if( $orderby ){ $this->db->order_by($orderby); }
        $query = $this->db->get($this->_table);
        if( $query->num_rows() == 0 ){
            return FALSE;
        }
        elseif ( $query->num_rows() == 1) {
            $result = $query->result();
            $result = reset($result);
            return $result;
        }
        else {
            return $query->result();
        }
    }


    /**
     * Idem à list_item, plus gestion d'une limite et d'un start
     * 
     * @param string $params 
     * @param string $orderby 
     * @param string $limit 
     * @param string $start
     * 
     * @throws bool False si pas de résultat 
     * @return array|object retourne un objet ou une liste d'objet
     */
    public function find_item($params= '', $orderby= '', $limit = '', $start = ''){
        if( $params ){ $this->db->where($params); }
        if( $orderby ){ $this->db->order_by($orderby); }
        if( !$start && $limit ){ $this->db->limit($limit); }
        if( $start && $limit ){ $this->db->limit($limit, $start); }
        $query = $this->db->get($this->_table);
        if( $query->num_rows() == 0 ){
            return FALSE;
        }
        elseif ( $query->num_rows() == 1) {
            $result = $query->result();
            $result = reset($result);
            return $result;
        }
        else {
            return $query->result();
        }

    }


    /**
     * Effectue un insert en base de donnée à partir d'un tableau associatif.
     * 
     * @param array $data
     * 
     * @throws bool False si action échoue
     * @return int retourne l'id de l'item inséré
     */
    public function insert_item($data) {
        $this->db->insert($this->_table, $data);
        $last_insert_id = $this->db->insert_id();
        if (is_numeric($last_insert_id) > 0 ) {
            return $last_insert_id;
        }
        else{
            return FALSE;
        }
    }

    /**
     * Effectue un update en base de donnée à partir d'un tableau associatif.
     * S'appuie de base sur la valeur de l'id pour cibler l'instance à modifier
     * 
     * @param array $data 
     * @param mixed $value 
     * @param string $field
     *  
     * @throws bool False si action échoue
     * @return bool TRUE si des changements ont réussi
     */
    public function update_item($data, $value, $field = 'id') {
        $this->db->where($field, $value);
        $this->db->update($this->_table, $data);
        $count_change = $this->db->affected_rows();
        if($count_change > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    /**
     * delete_item is used for delete item in the database
     * $count_change will check how many rows was affected during the last delete
     * the function will return false if less than 1 row was affected
     */
    /**
     * Supprime une instance en BDD à partir de son id par défaut
     * @param mixed $value 
     * @param string $field 
     *  
     * @throws bool False si action échoue
     * @return bool TRUE si des changements ont réussi
     */
    public function delete_item($value, $field = 'id') {
        $this->db->where($field, $value);
        $this->db->delete($this->_table);
        $count_change = $this->db->affected_rows();
        if($count_change > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    /**
     * Va changer le statut "visibility" d'une instance à FALSE
     * @param mixed $value 
     * @param string $field 
     *  
     * @throws bool False si action échoue
     * @return bool TRUE si des changements ont réussi
     */
    public function hide_item($value, $field = 'id'){
        $data = array('visibility'=>0);
        $this->db->where($field, $value);
        $this->db->update($this->_table, $data);
        $count_change = $this->db->affected_rows();
        if($count_change > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    /**
     * Va changer le statut "visibility" d'une instance à TRUE
     * @param mixed $value 
     * @param string $field 
     *  
     * @throws bool False si action échoue
     * @return bool TRUE si des changements ont réussi
     */
    public function show_item($value, $field = 'id'){
        $data = array('visibility'=>1);
        $this->db->where($field, $value);
        $this->db->update($this->_table, $data);
        $count_change = $this->db->affected_rows();
        if($count_change > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    /**
     * Compte les instances présentes dans la table
     * @param string|null $params 
     * @return integer
     */
    public function count_item($params = NULL)
    {
        if ($params !== NULL) {
            $this->db->where($params);
        }
        $query = $this->db->get($this->_table);
        return $query->num_rows();

    }

}