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
class Picture extends MY_Model {
  protected $_table = 'picture';

  public function __construct()
  {
    parent::__construct();
    log_message('info','Picture Model initialised.');
  }

  /**
   * Crée une nouvelle instance de Picture
   * - Normalise le titre du fichier
   * - Enregistre le fichier
   * - Crée une miniature
   * - Enregistre l'instance en BDD
   * @param array $data les données du formulaire
   * @return bool
   */
  public function create($data)
  {
    if ($_FILES["file"]['error'] !== 4 && !empty($data)) {

      //Preparation de l'upload, on commence par renommer le fichier
      $title_normalize = friendly_url($data['title']);
      
      $base_name    = $_FILES["file"]['name'];
      $file_ext     = substr($base_name, strripos($base_name, '.'));
      $_FILES["file"]['name'] = $title_normalize.''.$file_ext;

      //Definition du chemin de destination
      $file_location = FCPATH.'public/projects_pictures/p-'.$data['project_id'].'/';

      //Enclenche l'upload du fichier
      if ($this->upload_file($file_location)) {

        //Prépare les données pour la bdd
        $data['filename'] = $_FILES["file"]['name'];

        //Si l'upload réussi, création d'une miniature
        $this->set_thumbnail($data['filename'], $file_location);

        //Définit un gallery_order pour la première instance avec ce project_id
        $gallery = $this->picture->find_item('project_id = '.$data['project_id'].' AND gallery_order = 1');
        if(!$gallery){
             $data['gallery_order'] = 1;
        }

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
    else{
      return FALSE;
    }
  }

  public function update($data, $id)
  {
    // S'il n'y a pas de nouveau visuel
    if ($_FILES['file']['error'] == 4) {
      if (array_key_exists('title', $data)) {
        // Si le titre change : changement filename / changement des noms de fichiers
        $title_normalize = friendly_url($data['title']);

        $picture = $this->get_item($id);

        $original_filename = $picture->filename;
        $file_ext = substr($original_filename, strripos($original_filename, '.'));
        $new_filename = $title_normalize.''.$file_ext;

        $data['filename'] = $new_filename;

        $location = FCPATH.'public/projects_pictures/p-'.$picture->project_id.'/';
        //Update des fichiers
        if ($this->update_file_name($original_filename, $new_filename, $location) && $this->update_file_name('thumb_'.$original_filename, 'thumb_'.$new_filename, $location))
        {
          if ($this->update_item($data, $id)) {
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
      else{
        if ($this->update_item($data, $id)) {
          return TRUE;
        }
        else{
          return FALSE;
        }
      }
    }
    else{
      if (array_key_exists('title', $data)) {
        $picture = $this->get_item($id);
        $old_filename = $picture->filename;

        $title_normalize = friendly_url($data['title']);
      
        $base_name    = $_FILES["file"]['name'];
        $file_ext     = substr($base_name, strripos($base_name, '.'));
        $_FILES["file"]['name'] = $title_normalize.''.$file_ext;

        $path = FCPATH.'public/projects_pictures/p-'.$picture->project_id.'/';

        $data['filename'] = $_FILES["file"]['name'];

        // Suppression des anciens visuels
        if ($this->delete_file($old_filename, $path) && $this->delete_file('thumb_'.$old_filename, $path)) {
          
          // Upload nouveau visuel
          if ($this->upload_file($path)){
            $this->set_thumbnail($data['filename'], $path);

            // Update en BDD
            if ($this->update_item($data, $id)) {
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
        else{
          return FALSE;
        }

      }
      else{
        $picture = $this->get_item($id);
        $old_filename = $picture->filename;

        $base_name              = $_FILES["file"]['name'];
        $file_ext               = substr($base_name, strripos($base_name, '.'));
        $file_name              = substr($old_filename, 0, strripos ($old_filename, '.'));
        $new_filename           = $file_name.''.$file_ext;
        $_FILES["file"]['name'] = $new_filename;

        $data['filename'] = $new_filename;

        $path = FCPATH.'public/projects_pictures/p-'.$picture->project_id.'/';

        // Suppression des anciens visuels
        if($this->delete_file($data['filename'], $path) && $this->delete_file('thumb_'.$data['filename'], $path)) {
          // Upload des nouveaux fichiers
          if ($this->upload_file($path)){
            // Mise en place de la miniature
            $this->set_thumbnail($data['filename'], $path);

            // Update en BDD
            if ($this->update_item($data, $id)) {
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
        else{
          return FALSE;
        }
      }
    }
  }


  /**
   * Supprime un visuel en base de donnée et ses fichiers physiques
   * @param string $id [id du visuel ciblé]
   * @return bool [indique le succès ou nom]
   */
  public function delete_picture($id)
  {
    if (!empty($id)) {
      $picture = $this->get_item($id);
      $filename = $picture->filename;
      $path = FCPATH.'public/projects_pictures/p-'.$picture->project_id.'/';

      if ($this->delete_item($id)) {
        if ($this->delete_file($filename, $path) && $this->delete_file('thumb_'.$filename, $path)) {
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
    else{
      return FALSE;
    }
  }

  /**
   * Vide un galerie de tout ses visuels
   * @param type $gallery 
   * @return type
   */
  public function empty_gallery($gallery)
  {
    $gallery_item = $this->list_item('project_id ='.$gallery);
    $telltale = 0;
    if (count($gallery_item) > 1) {
      foreach ($gallery_item as $picture) {
        if($this->delete_picture($picture->id)){
          $telltale++;
        }
      }
    }
    else{
     if($this->delete_picture($gallery_item->id)){
        $telltale++;
      }
    }

    if ($telltale == count($gallery_item)) {
      return TRUE;
    }
    else{
      return FALSE;
    }

  }

  /**
   * Modifie l'ordre des visuels en bdd
   * @param array $array tableau associatif des visuels à modifier
   * @return bool
   */
  public function set_order($array)
  {
    $telltale = 0;
    for ($i=0; $i < count($array) ; $i++) { 
      $data = array(
        'gallery_order' => $array[$i]['position']
      );
      $id = $array[$i]['id'];
      if ($this->update_item($data, $id)) {
        $telltale++;
      }
    };
  
    if ($telltale == count($array)) {
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

  /**
   * Retourne le nombre de visuels totaux pour une galerie précise
   * @param integer $project_id 
   * @return integer
   */
  public function count_total($project_id)
  {
    return $this->count_item('project_id ='.$project_id);
  }

  /**
   * Retourne le nombre de visuels publié pour une galerie précise
   * @param integer $project_id 
   * @return integer
   */
  public function count_visible($project_id)
  {
    return $this->count_item('project_id ='.$project_id.' AND visibility = 1');
  }


  /**
   * S'appuie sur la librairie Upload de Codeigniter
   * pour mettre en place le téléversement de fichiers
   * @param type $file le ficher à upload
   * @param type $location l'adresse où enregistrer le fichier
   * @return bool
   */
  private function upload_file($filepath)
  {
    //Configuration des paramètres d'upload
    $config['upload_path']   = $filepath;
    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
    $config['max_size']      = 5120;

    //Charge la librarie 'upload' de CI avec les paramètres
    $this->load->library('upload', $config);

    if ($this->upload->do_upload('file')){
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

  private function delete_file($file, $path)
  {
    if (unlink($path.''.$file)) {
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

  /**
   * Crée une miniature d'un visuel uploadé
   * @param string $file Nom du fichier à dupliquer
   * @param string $filepath Chemin du fichier à dupliquer
   * @return bool
   */
  private function set_thumbnail($file, $filepath)
  {

    $original_file = $filepath.''.$file;
    $new_path = $filepath.'thumb_'.$file;

    //Definir le format de l'image
    $file_ext     = substr($file, strripos($file, '.'));

    switch ($file_ext) {
      case '.gif':
        $thumb_image = imagecreatefromgif($original_file);
        break;

      case '.jpeg':
        $thumb_image = imagecreatefromjpeg($original_file);
        break;

      case '.jpg':
        $thumb_image = imagecreatefromjpeg($original_file);
        break;

      case '.png':
        $thumb_image = imagecreatefrompng($original_file);
        break;
      
      default:
          return FALSE;
        break;
    }

    //Definir les dimensions
    list($orig_width, $orig_height) = getimagesize($original_file);

    $max_width = 260;

    $ratio = $max_width / $orig_width;

    $new_width = (int)$orig_width * $ratio;
    $new_height = (int)$orig_height * $ratio;

    $new_file = imagecreatetruecolor($new_width, $new_height);
    imagealphablending($new_file, false);
    imagesavealpha($new_file, true);
    imagecopyresampled($new_file, $thumb_image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);

    switch ($file_ext) {
      case '.gif':
        imagegif($new_file, $new_path);
        break;

      case '.jpeg':
        imagejpeg($new_file, $new_path, 85);
        break;

      case '.jpg':
        imagejpeg($new_file, $new_path, 85);
        break;

      case '.png':
        imagepng($new_file, $new_path, 6);
        break;
      
      default:
          return FALSE;
        break;
    }

    imagedestroy($thumb_image);
    imagedestroy($new_file);

    return TRUE;

  }

  /**
   * Mets à jours le nom d'un fichier physique
   * @param string $old_filename [ancien nom]
   * @param string $new_filename [nouveau nom]
   * @param string $path [chemin d'accès]
   * @return bool [succès ou non]
   */
  private function update_file_name($old_filename, $new_filename, $path)
  {
    if (rename($path.''.$old_filename, $path.''.$new_filename)) {
      return TRUE;
    }
    else{
      return FALSE;
    }
  }

}