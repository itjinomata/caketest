<?php

//返信機能
//URL出力

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
            
            if ($this->request->is('post')) {
                //var_dump($this->request->data);exit;
                if ($this->request->data['Post']['message']) {
                    //画像アップロードでエラーが出るので、バリデーションをfalseにしておく
                    if ($this->Post->save($this->request->data)) {
                        $this->Session->setFlash('Success!');
                        return $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Session->setFlash('failed!');
                    }
                }
            }
                       
            
	}
    
        
        public function view($id) {
            
            //var_dump($id);exit;
            
            //postデータの獲得
            $this->set('post', $this->Post->recording($id));   
            
            $table = $this->Post->recording($id);
            
            /**
             * オブジェクト参照にはコストがかかるため
             * 2回以上使うオブジェクトは変数に入れてしまったほうがいい
             * $table = $this->Post->recording($id)
             * $this->set('post', $table);   
             */
            
            //prevデータ（前のデータ）の獲得
            $this->set('prev', $this->Post->recording($table[0]['Post']['reply_post_id']));            
            
            //nextデータの獲得
            $this->set('nexts', $this->Post->nexting($id));               
            
        }  
        
        public function delete($id) {
            
            if ($this->Post->delete($id)) {
                $this->Session->setFlash('Deleted!');
                $this->redirect(array('action'=>'index'));
            }             
            
        }  
        
        
}

?>