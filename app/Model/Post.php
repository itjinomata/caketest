<?php
 
class Post extends AppModel {

    public $primaryKey = 'post_id'; 
    //キャメル　primary

    /*
    public function hoge(){
        return "moge";
    }
    
    // データベースの操作をコントローラでさせない（関数でどのコントローラからも操作を参照できるようにしとく）
    public function test(){
        $params = array(
            'conditions' => array(
                'member_id' => '5'
            ),
            'limit' =>10
        );
        
        return $this->find('all',$params);
    }
     */
    
    public function listing(){
        return $this->find('all');
    }
   

}

?>