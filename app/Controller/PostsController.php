<?php

class PostsController extends AppController {
    
    	public function index() {
            //$hoge = $this->Post->test();
            //echo "<pre>";var_dump($hoge);
            //exit;
	}
    
    	public function ichiran() {
            $this->set('posts', $this->Post->listing());
            //echo "<pre>";var_dump($posts);
            //exit; 
        }       
        
}

?>