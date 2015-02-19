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
    
        
        public function view($id) {
            
            //var_dump($id);exit;
            
            //postデータの獲得
            $this->set('post', $this->Post->recording($id));   
            
            $table = $this->Post->recording($id);
            
            //prevデータ（前のデータ）の獲得
            $this->set('prev', $this->Post->recording($table[0]['Post']['reply_post_id']));            
            
            //nextデータの獲得
            $this->set('nexts', $this->Post->nexting($id));               
            
        }  
        
}

?>