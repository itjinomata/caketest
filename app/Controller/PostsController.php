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
        
        public function join_index() {       
            if ($this->request->is('post')) {
                if ($this->Post->save($this->request->data)) {
                    $this->Session->setFlash('Success!');
                    $this->redirect(array('action'=>'check'));
                } else {
                    $this->Session->setFlash('failed!');
                }
            }

        }
        
        
}

?>