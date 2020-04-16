<?php  
session_start();
use \Model\HospitalModel;
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
         $this -> template -> drgactive = "none";
      }

      public function action_aboutus() {
         $view = View::forge('welcome/aboutus');
         
         $this -> template -> title = "About Us";
         $this -> template -> content = $view;
         $this -> template -> aboutactive = "active";
         $this -> template -> indexactive = "none";
         $this -> template -> hospitalactive = "none";
         $this -> template -> drgactive = "none";
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
      }
   
      public function action_drgdetails() {
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
            $this -> templaet -> content = "No DRG Given";
         }
      }
      
   }