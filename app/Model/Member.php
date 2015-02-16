<?php
    
// App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class Member extends AppModel {

    //バリデーション（imageについては後で実装）- ルール２つも可能
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'required' => 'true',            
            'message' => '入力よろっす'
        ),
        'email' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'required' => 'true',            
                'message' => '入力よろっす'
            ),
            // 真ならチェック通って、偽ならチェック通らない
            'rule2' => array(
                'rule' => 'sameMail',            
                'message' => 'アドレス重複してるよ'
            )            
        ),
        'password' => array(
            'rule' => array('minLength', '4'),
            'required' => 'true',            
            'message' => '4文字以上入力よろっす'
        )
    );
    
    //emailの重複チェック（教科書P108の書き方（$check?））
    public function sameMail($check){

        $table = $this->find('count',array(
            'conditions' => array(
                'email' => $check['email']
            )
        ));
     
        // debug($table);
        // exit;
        
        //$tableに1以上が代入されていれば偽（validate発動）
        if($table > 0){
            return false;
        }else{
            return true;
        };
    }
    
    // before系の関数は使わないほうがいい（）
    
    // Cake/Utility/Seculityの122行目でデフォルト設定がsha1 -> sha1で暗号化される設定
    // Hashの設定は33行目
    /*
    public function beforeSave($options = array()) {
        if (!$this->member_id) {
            $passwordHasher = new SimplePasswordHasher();
            $this->data['Member']['password'] = $passwordHasher->hash($this->data['Member']['password']);
        }
        return true;
    }
    */
    
    
    
    public function listing2(){
        return $this->find('all', array('fields' => array('name','picture')));       
    }
    
}
    
?>