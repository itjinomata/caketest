<?php

class PostsController extends AppController {

        // コンポーネントなのでコントローラーに書く。
        public $paginate = array(
            'limit' => 5,
            'order' => array(
                'Post.post_id' => 'desc'
            )
        );
        
    
    	public function index() {
            $this->set('posts', $this->Post->listing());
            
            //一覧表示の制御（foreach）をここでやる。それ以外は、paginateが勝手に$pagenateから計算してページを割り振ってくれる。
            $this->set('pgn', $this->paginate());                   
            
	}
    
        
        public function view() {
            $this->set('posts', $this->Post->recording());            
        }  
        
}

?>