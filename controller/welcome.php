<?php  
   use \Model\HospitalModel;
   use \Model\DRGModel;
   use \Model\LoginModel;
   class Controller_Welcome extends Controller_Template {
      public $template = 'layout'; 
      public function action_index() { 
         
         // Create the view object 
         $view = View::forge('welcome/index');  
         
         // set the template variables 
         $this->template->title = "Our Home Page"; 
         $this->template->content = $view; 
         $this -> template -> indexactive = "active";
         $this -> template -> aboutactive = "none";
         $this -> template -> hospitalactive = "none";
         $this -> template -> drgactive = "none";
         $this -> template -> loginactive = "none";
      }
      
      public function action_aboutus() {
         $view = View::forge('welcome/aboutus');
         
         $this -> template -> title = "About Us";
         $this -> template -> content = $view;
         $this -> template -> aboutactive = "active";
         $this -> template -> indexactive = "none";
         $this -> template -> hospitalactive = "none";
         $this -> template -> drgactive = "none";
         $this -> template -> loginactive = "none";
      }
      
      public function action_hospital(){
         $data = array(
         'hospital' => HospitalModel::read_hospital(),
         );
         
         $view = View::forge('welcome/hospital', $data);
         
         $this->template->title = "Hospital List";
         $this -> template -> content = $view;
         $this -> template -> aboutactive = "none";
         $this -> template -> indexactive = "none";
         $this -> template -> drgactive = "none";
         $this -> template -> hospitalactive = "active";
         $this -> template -> loginactive = "none";
      }
      
      public function action_drg() {
         $data = array(
         'drg' => DRGModel::read_drgs(),
         );
         
         $view = View::forge('welcome/drgview', $data);
         
         $this->template->title = "DRG List";
         $this -> template -> content = $view;
         $this -> template -> aboutactive = "none";
         $this -> template -> indexactive = "none";
         $this -> template -> drgactive = "active";
         $this -> template -> hospitalactive = "none";
         $this -> template -> loginactive = "none";
      }
      
      public function action_drgdetails() {
         $this -> template -> aboutactive = "none";
         $this -> template -> indexactive = "none";
         $this -> template -> drgactive = "active";
         $this -> template -> hospitalactive = "none";
         $this -> template -> loginactive = "none";
         
         if(isset($_GET['drg'])) {
         $data = array(
         'drgDetails' => DRGModel::get_hospitals($_GET['drg']),
         );
         
         $view = View::forge('welcome/drgdetails', $data);
         
         $this -> template -> title = "DRG Details";
         $this -> template -> content = $view;
         }
         else {
            $this -> template -> title = "DRG Details";
            $this -> template -> content = "No DRG Given";
         }
      }
      public function action_hospitaldetails() {
         $this -> template -> aboutactive = "none";
         $this -> template -> indexactive = "none";
         $this -> template -> drgactive = "none";
         $this -> template -> hospitalactive = "active";
         $this -> template -> loginactive = "none";
         
         if(isset($_GET['id'])) {
            $data = array(
            'hospitalDetails' => HospitalModel::get_hospitals($_GET['id']),
            );
            
            $view = View::forge('welcome/hospitaldetails', $data);
            
            $this -> template -> title = "Hospital Details";
            $this -> template -> content = $view;
         }
         else {
            $this -> template -> title = "Hospital Details";
            $this -> template -> content = "No Hospital Given";
         }
      }
      
      public function action_login() {
         $data = array(
            'logins' => LoginModel::read_logins(),
         );
         
         $view = View::forge('welcome/login', $data); 
         $this->template->title = "Login"; 
         $this->template->content = $view; 
         $this -> template -> indexactive = "none";
         $this -> template -> aboutactive = "none";
         $this -> template -> hospitalactive = "none";
         $this -> template -> drgactive = "none";
         $this -> template -> loginactive = "active";
         
      }
}