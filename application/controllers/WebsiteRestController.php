
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD']==='OPTIONS'){
    header('Access-Control-Allow-Methods:GET,PUT,POST,DELETE,OPTIONS');
    header('Access-Control-Allow-Headers:Content-Type');
    exit;
}
# require for rest api


include APPPATH .'/libraries/REST_Controller.php';
include APPPATH . 'libraries/Format.php';
use Restserver\Libraries\REST_Controller;

// use RestserverLibrariesREST_Controller;

class WebsiteRestController extends REST_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('website_model');
    }
    public function websites_get(){
        $website = $this->website_model->get_website_list();
            if($website){
                $this->response($website,200);
            }
            else
            {
                $this->response(array(),200);
            }
    }
    public function  website_get() {
        
        if(!$this->get('id')){
            $this->response(NULL,400);
           }
        $website = $this->website_model->get_website($this->get('id'));
            if($website){
                $this->response($website,200);
            } else {
                $this->response(array(),500);
            }
    }
    public function add_website_post(){
        $website_title = $this->post('title');
        $website_url =$this->post('url');

        $result = $this->website_model->add_website($website_title,$website_url);

        if($result === FALSE){
            $this->response(array('status'=>'Failed'));
        }
        else{
            $this->response(array('status'=>'Success'));
        }
    }
    public function update_website_put(){
        $website_id = $this->put('id');
        $website_title = $this->put('title');
        $website_url = $this->put('url');
        $result = $this->website_model->update_website($website_id,$website_title,$website_url);
        if($result===FALSE){
            $this->response(array('Status'=>'Failed'));
        }
        else{
            $this->response(array('Status'=>'Success'));
        }
    }
        public function delete_website_delete($website_id){
            #path parameter example is /delete/id
            $result = $this->website_model->delete_website($website_id);
            if($result===FALSE){
                $this->response(array('Status'=>'Failed'));
            }else{
                $this->response(array('Status'=>'Success'));
            }
        }
    
}