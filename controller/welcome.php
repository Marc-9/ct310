<?php  
   class Controller_Welcome extends Controller_Template {
      public $template = 'layout'; 
      public function action_index() { 
         
         // Create the view object 
         $view = View::forge('welcome/index');  
         
         // set the template variables 
         $this->template->title = "Our Home Page"; 
         $this->template->content = $view; 
      }
      
      public function action_hospital() {
         $view = View::forge('welcome/hospitals');
         
         $this -> template -> title = "Hospitals";
         $this -> template -> content = $view;
      }
   }