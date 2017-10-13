<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  $config = array(
    'administration/dashboard/login' => array(
      array(
        'field' => 'username',
        'label' => 'nom d\'utilisateur',
        'rules' => 'trim|required'
      ),
      array(
        'field' => 'email',
        'label' => 'adresse e-mail',
        'rules' => 'trim|required|valid_email'
      ),
      array(
        'field' => 'password',
        'label' => 'mot de passe',
        'rules' => 'trim|required'
      )
    ),
    'administration/parameters/index' => array(
      array(
        'field' => 'site_name',
        'label' => 'titre du site',
        'rules' => 'trim|required'
      ),
      array(
        'field' => 'site_description',
        'label' => 'description du site',
        'rules' => 'trim|required'
      ),
      array(
        'field' => 'site_author',
        'label' => 'auteur du site',
        'rules' => 'trim|required'
      )
    ),
    'administration/users/index' => array(
      array(
        'field' => 'username',
        'label' => 'nom d\'utilisateur',
        'rules' => 'trim|required|min_length[3]|max_length[40]'
      ),
      array(
        'field' => 'first_name',
        'label' => 'prénom',
        'rules' => 'trim|min_length[2]'
      ),
      array(
        'field' => 'last_name',
        'label' => 'nom',
        'rules' => 'trim|min_length[2]'
      ),
      array(
        'field' => 'email',
        'label' => 'adresse e-mail',
        'rules' => 'trim|required|valid_email'
      ),
      array(
        'field' => 'password',
        'label' => 'mot de passe',
        'rules' => 'trim|required|min_length[8]'
      ),
      array(
        'field' => 'valid_password',
        'label' => 'confirmation du mot de passe',
        'rules' => 'trim|required|matches[password]|min_length[8]'
      )
    ),
    'editUser' => array(
      array(
        'field' => 'username',
        'label' => 'nom d\'utilisateur',
        'rules' => 'trim|required|min_length[3]'
      ),
      array(
        'field' => 'first_name',
        'label' => 'prénom',
        'rules' => 'trim|min_length[2]'
      ),
      array(
        'field' => 'last_name',
        'label' => 'nom',
        'rules' => 'trim|min_length[2]'
      ),
      array(
        'field' => 'email',
        'label' => 'adresse e-mail',
        'rules' => 'trim|required|valid_email'
      )
    ),
    'administration/users/profil' => array(
      array(
        'field' => 'username',
        'label' => 'nom d\'utilisateur',
        'rules' => 'trim|required|min_length[3]'
      ),
      array(
        'field' => 'first_name',
        'label' => 'prénom',
        'rules' => 'trim|min_length[2]'
      ),
      array(
        'field' => 'last_name',
        'label' => 'nom',
        'rules' => 'trim|min_length[2]'
      ),
      array(
        'field' => 'email',
        'label' => 'adresse e-mail',
        'rules' => 'trim|required|valid_email'
      ),
      array(
        'field' => 'password',
        'label' => 'mot de passe',
        'rules' => 'trim|required'
      ),
      array(
        'field' => 'new_password',
        'label' => 'nouveau mot de passe',
        'rules' => 'trim|min_length[8]'
      ),
      array(
        'field' => 'valid_password',
        'label' => 'nouveau mot de passe',
        'rules' => 'trim|matches[new_password]'
      )
    ),
    'administration/categories/index' => array(
      array(
        'field' => 'title',
        'label' => 'titre',
        'rules' => 'trim|required|min_length[3]|is_unique[project_category.title]|max_length[42]'
      )
    ),
    'editCategory' => array(
      array(
        'field' => 'title',
        'label' => 'titre',
        'rules' => 'trim|required|min_length[3]|is_unique[project_category.title]|max_length[42]'
      )
    ),
    'administration/projects/new' => array(
      array(
        'field' => 'title',
        'label' => 'titre',
        'rules' => 'trim|required|min_length[3]'
      ),
      array(
        'field' => 'category_id',
        'label' => 'catégorie associée',
        'rules' => 'required'
      ),
      array(
        'field' => 'context',
        'label' => 'contexte',
        'rules' => 'trim|required|min_length[10]|max_length[256]'
      ),
      array(
        'field' => 'description',
        'label' => 'description',
        'rules' => 'trim|required|min_length[10]'
      ),
      array(
        'field' => 'external_link',
        'label' => 'lien externe',
        'rules' => 'trim|min_length[5]|valid_url'
      )
    ),
    'editProject' => array(
      array(
        'field' => 'title',
        'label' => 'titre',
        'rules' => 'trim|required|min_length[3]'
      ),
      array(
        'field' => 'category_id',
        'label' => 'catégorie associée',
        'rules' => 'required'
      ),
      array(
        'field' => 'context',
        'label' => 'contexte',
        'rules' => 'trim|required|min_length[10]|max_length[256]'
      ),
      array(
        'field' => 'description',
        'label' => 'description',
        'rules' => 'trim|required|min_length[10]'
      ),
      array(
        'field' => 'external_link',
        'label' => 'lien externe',
        'rules' => 'trim|min_length[5]|valid_url'
      )
    ),
    'newPicture' => array(
      array(
        'field' => 'title',
        'label' => 'titre',
        'rules' => 'trim|required|min_length[3]|is_unique[picture.title]'
      ),
      array(
        'field' => 'alt',
        'label' => 'description',
        'rules' => 'trim|required|min_length[3]'
      ),
      array(
        'field' => 'file',
        'label' => 'visuel',
        'rules' => 'callback_file_check'
      )
    ),
    'editPicture' => array(
      array(
        'field' => 'alt',
        'label' => 'description',
        'rules' => 'trim|required|min_length[3]'
      ),
      array(
        'field' => 'file',
        'label' => 'visuel',
        'rules' => 'callback_file_check'
      )
    )
  )
?>
