<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*****************************************************************
 *
 * @copyright Copyright (c) 2010-Present, 061375
 * @author Jeremy Heminger <j.heminger@061375.com>
 * @bindings CI
 * @deprecated = false
 *
 * */
class Cms extends CI_Controller
{
    private $template;
    private $data;
    private $analytics;
    private $articles;
    function __construct()
    {
        parent::__construct();
        $this->analytics = get_instance();
        $this->analytics->load->library('analytics/sp_analytics');
        $this->articles = get_instance();
        $this->articles->load->library('articles/sp_articles');
        $this->auth = get_instance();
        $this->auth->load->library('authorization/sp_authorization');
        
        $this->template = get_instance();
        $this->template->load->model('sp_templatemodel');
    }
    public function _remap($method, $params)
    {
        if ($this->auth->sp_authorization->isAuth(array('privileges'=>4)) !== false ) {
            $this->data = $this->initGeneralData();
	    $this->data['first_post_date'] = $this->articles->sp_articles->getFirstArticle();
            if (true == method_exists($this,$method)) {
                // call the feed method passed by the first GET variable
                $this->$method($params);
            } else {
                $this->load->view('cms',$this->data);    
            }
        }
    }
    /********************************
    * initGeneralData() : array
    * @description : certain aspects will always be loaded...why not put them into a general function
    * @params : none
    */
    private function initGeneralData()
    {
	Sp_General::set_session(array('sendmail','ip'),$_SERVER['REMOTE_ADDR']);
	
	$template_data['template_data'] = $this->template->sp_templatemodel->mdl_getActiveTemplate();
        $data = array(
	    'javascript'=>$this->load->view('core_javascript','',true),
	    'css'=>$this->load->view('core_css','',true),
	    'template_data'=>$template_data,
	    'keyword_search'=>'',
	    'header'=>$this->load->view('header',$template_data,true),
	    'footer'=>$this->load->view('footer',$template_data,true),
	    'confirmation_key' => Sp_General::get_session('confirmation_key')
        );
        return $data;
    }
}