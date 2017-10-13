<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * La librairie MY_Session permet de surcharger la librairie originelle CI_Session
 * afin de lui permettre de trouver le navigateur de l'utilisateur et son OS. 
 * 
 * @author Justine Simmet <justine.simmet@gmail.com>
 * @copyright 2017 Justine Simmet
 * @version 1.0
 */
class MY_Session extends CI_Session{

  protected $_user_agent; // Stocke le type de navigateur de l'utilisateur
  protected $_user_platform; // Stocke l'OS de l'utilisateur
  private $CI; // Super objet d'instance CodeIgniter

  public function __construct()
  {
    //Initialise super objet CI pour pouvoir utiliser la librairie user_agent
    $this->CI = get_instance();
    $this->CI->load->library('user_agent');

    $this->_user_agent = $this->set_user_agent();
    $this->_user_platform = $this->set_user_platform();

    // No sessions under CLI
    if (is_cli())
    {
      log_message('debug', 'Session: Initialization under CLI aborted.');
      return;
    }
    elseif ((bool) ini_get('session.auto_start'))
    {
      log_message('error', 'Session: session.auto_start is enabled in php.ini. Aborting.');
      return;
    }
    elseif ( ! empty($params['driver']))
    {
      $this->_driver = $params['driver'];
      unset($params['driver']);
    }
    elseif ($driver = config_item('sess_driver'))
    {
      $this->_driver = $driver;
    }
    // Note: BC workaround
    elseif (config_item('sess_use_database'))
    {
      log_message('debug', 'Session: "sess_driver" is empty; using BC fallback to "sess_use_database".');
      $this->_driver = 'database';
    }

    $class = $this->_ci_load_classes($this->_driver);

    // Configuration ...
    $this->_configure($params);
    $this->_config['_sid_regexp'] = $this->_sid_regexp;

    $class = new $class($this->_config);
    if ($class instanceof SessionHandlerInterface)
    {
      if (is_php('5.4'))
      {
        session_set_save_handler($class, TRUE);
        
      }
      else
      {
        session_set_save_handler(
          array($class, 'open'),
          array($class, 'close'),
          array($class, 'read'),
          array($class, 'write'),
          array($class, 'destroy'),
          array($class, 'gc')
        );
        register_shutdown_function('session_write_close');
      }
    }
    else
    {
      log_message('error', "Session: Driver '".$this->_driver."' doesn't implement SessionHandlerInterface. Aborting.");
      return;
    }

    // Sanitize the cookie, because apparently PHP doesn't do that for userspace handlers
    if (isset($_COOKIE[$this->_config['cookie_name']])
      && (
        ! is_string($_COOKIE[$this->_config['cookie_name']])
        OR ! preg_match('#\A'.$this->_sid_regexp.'\z#', $_COOKIE[$this->_config['cookie_name']])
      )
    )
    {
      unset($_COOKIE[$this->_config['cookie_name']]);
    }

    session_start();

/****************** MISE EN PLACE DES VARIABLES CUSTOM POUR UNE SAUVEGARDE EN BDD *************************/

    if (!isset($_SESSION['__ci_user_agent'])) {
      $_SESSION['__ci_user_agent'] = $this->_user_agent;
    }

    if (!isset($_SESSION['__ci_user_platform'])) {
      $_SESSION['__ci_user_platform'] = $this->_user_platform;
    }

/*********************************************************************************************************/    

    // Is session ID auto-regeneration configured? (ignoring ajax requests)
    if ((empty($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
      && ($regenerate_time = config_item('sess_time_to_update')) > 0
    )
    {
      if ( ! isset($_SESSION['__ci_last_regenerate']))
      {
        $_SESSION['__ci_last_regenerate'] = time();
      }
      elseif ($_SESSION['__ci_last_regenerate'] < (time() - $regenerate_time))
      {
        $this->sess_regenerate((bool) config_item('sess_regenerate_destroy'));
      }
    }
    // Another work-around ... PHP doesn't seem to send the session cookie
    // unless it is being currently created or regenerated
    elseif (isset($_COOKIE[$this->_config['cookie_name']]) && $_COOKIE[$this->_config['cookie_name']] === session_id())
    {
      setcookie(
        $this->_config['cookie_name'],
        session_id(),
        (empty($this->_config['cookie_lifetime']) ? 0 : time() + $this->_config['cookie_lifetime']),
        $this->_config['cookie_path'],
        $this->_config['cookie_domain'],
        $this->_config['cookie_secure'],
        TRUE
      );
    }

    $this->_ci_init_vars();

    log_message('info', "MY_Session: Class initialized using '".$this->_driver."' driver.");
  }

  /**
   * Utilise la librarie CI user_agent pour définir l'origine de l'utilisateur ou son origine.
   * @return string 
   */
  public function set_user_agent()
  {
    if ($this->CI->agent->is_browser())
    {
      $agent = $this->CI->agent->browser().' '.$this->CI->agent->version();
      return $agent;
    }
    elseif ($this->CI->agent->is_robot())
    {
      return 'Robot';
    }
    elseif ($this->CI->agent->is_mobile())
    {
      return 'Mobile';
    }
    else
    {
      return 'Unidentified User Agent';
    }
    
  }

  /**
   * Utilise la librarie CI user_agent pour définir l'OS de l'utilisateur.
   * @return string 
   */
  public function set_user_platform()
  {
    if (!empty($this->CI->agent->platform()))
    {
      return $this->CI->agent->platform();
    }
    else
    {
      return 'Unidentified User Plaform';
    }
    
  }

  /**
   * Session regenerate
   *
   * Legacy CI_Session compatibility method
   *
   * @param bool  $destroy  Destroy old session data flag
   * @return  void
   */
  public function sess_regenerate($destroy = FALSE)
  {
    $_SESSION['__ci_last_regenerate'] = time();
    $_SESSION['__ci_user_agent'] = $this->_user_agent;
    $_SESSION['__ci_user_platform'] = $this->_user_platform;
    session_regenerate_id($destroy);
  }

}