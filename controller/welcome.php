<?php
use \Model\DRGModel;

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
      }
      
      public function action_hospital() {
         $view = View::forge('welcome/hospital');
         
         $this -> template -> title = "Hospitals";
         $this -> template -> content = $view;
         $this -> template -> hospitalactive = "active";
         $this -> template -> indexactive = "none";
         $this -> template -> aboutactive = "none";
      }
      public function action_aboutus() {
         $view = View::forge('welcome/aboutus');
         
         $this -> template -> title = "About Us";
         $this -> template -> content = $view;
         $this -> template -> aboutactive = "active";
         $this -> template -> indexactive = "none";
         $this -> template -> hospitalactive = "none";
      }
      
      public function action_drg() {
         $data = array(
            'drg' =? DRGModel::read_drgs(),
         );
         
         $view = View::forge('drgview', $data);
         
         this -> template -> "DRG List";
         $this -> template -> content = $view;
         $this -> template -> aboutactive = "active";
         $this -> template -> indexactive = "none";
         $this -> template -> drgactive = "none";
      }
   }
   