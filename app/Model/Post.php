<?php

class Post extends AppModel {

    public $primaryKey = 'post_id'; 
    //キャメル　primary

    public $belongsTo = 'Member';
    //親モデルに含まれている（親のデータも参照可能）


    public function listing(){
        return $this->find('all', array('order' => array('Post.post_id DESC')));
    }
   
    public function recording($postId){
        //var_dump($id);exit;
        return $this->find('all', array('conditions' => array('Post.post_id' => $postId)));
    }
   
    public function nexting($id = NULL){
        return $this->find('all', array('conditions' => array('Post.reply_post_id' => $id)));
    }
 
    public function counter(){
        return $this->find('count');
    }
    
}

?>