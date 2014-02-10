<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*****************************************************************
 *
 * @description Ajax controller to display the CMS sections
 * @copyright Copyright (c) 2010-Present, 061375
 * @author Jeremy Heminger <jheminger@061375.com>
 * @bindings Codeigniter
 * @deprecated = false
 *
 * */
class Cms extends CI_Controller
{
    private $data;
    private $errors = array();
    private $libraries = array();
    function __construct()
    {
        parent::__construct();
        // load libraries
        $this->libraries['articles'] = get_instance();
        $this->libraries['articles']->load->library('articles/sp_articles');
        $this->libraries['auth'] = get_instance();
        $this->libraries['auth']->load->library('authorization/sp_authorization');
        // load models
        $this->libraries['template'] = get_instance();
        $this->libraries['template']->load->model('sp_templatemodel');	
    }
    /**
     * Filters all calls to the constructor thru one function
     * this allows me to:
     * - check against the database for login authorization
     * - handle incorrect URL's my own way
     * - use folders like GET strings i.e. :
     * http://www.mysite.com/method=method&query1=query1&query2=query2&query3=query3
     * becomes
     * http://www.mysite.com/method/query1/query2/query3
     * @method _remap
     * @param {String} $method
     * @param {Array} $params
     * */
    public function _remap($method, $params)
    {
        // get the confirmation key and compare it against the database
        $confirmation_key = Sp_General::post_variable('confirmation_key');
        
        if (true !== $this->libraries['auth']->sp_authorization->checkConfirmationKey($confirmation_key,1)) {
            // triggers javascript to force the unauthorized user to the log-out page
            echo json_encode(array('logout'=>1));exit();
        } else {
            // initialize general setup based on template
            $this->data = $this->initGeneralData();
            if (true == method_exists($this,$method)) {
                $this->$method($params);
            } else {
                header("HTTP/1.0 404 Not Found");
            }
        }
    }
    private function listArticles($params)
    {
        $params = Sp_General::post_variable('data');
        $result = $this->libraries['articles']->sp_articles->listArticles($params);
        if (false !== $result) {
            echo json_encode(array(
                                   'success' => 1,
                                   'data'    => $result
            ));
            exit();   
        } else {
            $this->display_errors();
        }
    }
    private function listUsers($params)
    {
        $result = $this->libraries['auth']->sp_authorization->listUsers($params);
        if (false !== $result) {
            echo json_encode(array(
                                   'success' => 1,
                                   'data'    => $result
            ));
            exit();   
        } else {
            $this->display_errors();
        }
    }
    private function listSections($params)
    {
        $result = $this->libraries['articles']->sp_articles->listSections($params);
        if (false !== $result) {
            $return = array();
            $i = 0;
            foreach ($result as $row) {
                $return[$i]['id']   = $row['id'];
                $return[$i]['section'] = $row['section'];
                $i++;
            }
            echo json_encode(array(
                                   'success' => 1,
                                   'data'    => $return
            ));
            exit();   
        } else {
            $this->display_errors();
        }
    }
    private function getArticleByID($params)
    {
        $id = Sp_General::getFunctionParam($params,0,false);
        if (false === $id) {
            $this->set_error_message('err_no_id') ;  
        }
        if ( false === $this->has_error() ) {
            $result = $this->libraries['articles']->sp_articles->getArticleByID($id);
            if (false !== $result) {
                echo json_encode(array(
                                       'success' => 1,
                                       'data'    => $result
                ));
                exit();   
            } else {
                $this->display_errors();
            }
        } else {
            $this->display_errors();
        }
    }
    private function addNewArticle($params)
    {
        $data = Sp_General::post_variable('data','');
        $params = array(
            'title'      => Sp_General::getFunctionParam($data,'title'),
            'section_id' => Sp_General::getFunctionParam($data,'section_id'),
            'post'       => Sp_General::getFunctionParam($data,'post')
        );
        $result = $this->libraries['articles']->sp_articles->addNewArticle($params);
        if (false !== $result) {
            echo json_encode(array(
                                   'success' => 1,
                                   'data'    => $result
            ));
            exit();   
        } else {
            $this->display_errors();
        }
    }
    private function addNewUser($params)
    {
        $result = $this->libraries['auth']->sp_authorization->addNewUser($params);
        if (false !== $result) {
            echo json_encode(array(
                                   'success' => 1,
                                   'data'    => $result
            ));
            exit();   
        } else {
            $this->display_errors();
        }
    }
    private function editArticle($params)
    {
        $result = $this->libraries['articles']->sp_articles->editArticle($params);
        if (false !== $result) {
            echo json_encode(array(
                                   'success' => 1,
                                   'data'    => $result
            ));
            exit();   
        } else {
            $this->display_errors();
        }
    }
    private function editUser($params)
    {
        $result = $this->libraries['auth']->sp_authorization->editUser($params);
        if (false !== $result) {
            echo json_encode(array(
                                   'success' => 1,
                                   'data'    => $result
            ));
            exit();   
        } else {
            $this->display_errors();
        }
    }
    private function deleteArticlesByID($params)
    {
        $params = Sp_General::post_variable('data',false);
        if (false === $params) {
            $this->set_error_message('err_no_id') ;  
        }
        if ( false === $this->has_error() ) {
            $result = $this->libraries['articles']->sp_articles->deleteArticlesByID($params);
            if (false !== $result) {
                echo json_encode(array(
                                       'success' => 1,
                                       'data'    => $result
                ));
                exit();   
            } else {
                $this->display_errors();
            }
        } else {
            $this->display_errors();
        }
    }
    /********************************
    * initGeneralData() : array
    * @description : certain aspects will always be loaded...why not put them into a general function
    * @params : none
    */
    private function initGeneralData()
    {
        // set the header to accept JSON
        header('Content-type: application/json');
        $data = array ();
        return $data;
    }
    // --------------------------------------------------------------------

    /**
     * Get Error messages
     *
     * @return array
     */
    private function get_error_message()
    {
        if (count($this->errors) > 0) {
            $tmp = $this->errors;
            $this->errors = array();
            return $tmp;
        }
        return true;
    }

    // --------------------------------------------------------------------

    /**
     * Set Error messages
     *
     * @return array
     */
    private function set_error_message($message)
    {
        if ($message != '') {
            $this->errors[] = $message;
        }
    }
	
    // --------------------------------------------------------------------
	
    /**
     * Has Error
     *
     * @return array
     */
    private function has_error()
    {
        if (count($this->errors) > 0) {
            return true;
        }
        return false;
    }

    // --------------------------------------------------------------------

    /**
     * Clear Error
     *
     * @return array
     */
    private function clear_error()
    {
        $this->errors = array();
    }
    /**
     * Gathers errors and converts them to XML to be returned to the user
     *
     * @return void
     */
    private function display_errors()
    {
        $errors = array();
        $errors[] = $this->get_error_message();
        foreach ($this->libraries as $row) {
            $errors[] = $row->get_error_message();
        }
        $result = array(
                'success' => 0,
                'errors' => $errors
        );
        echo json_encode($result);
    }
}