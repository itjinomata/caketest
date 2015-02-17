<?php
    
// App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class Member extends AppModel {

    public $primaryKey = 'member_id';
    
    //バリデーション（imageについては後で実装）- ルール２つも可能
    
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'required' => 'true',            
            'message' => '入力してください'
        ),
        'email' => array(
            'rule1' => array(
                'rule' => 'notEmpty',
                'required' => 'true',            
                'message' => '入力してください'
            ),
            // 真ならチェック通って、偽ならチェック通らない
            'rule2' => array(
                'rule' => 'sameMail',            
                'message' => '登録アドレスが重複しています。'
            )            
        ),
        'password' => array(
            'rule' => array('minLength', '4'),
            'required' => 'true',            
            'message' => '4文字以上入力してください'
        ),
        
        //アップロード画像のバリデーション
        'picture' => array(
            // ルール：uploadError => errorを検証 (2.2 以降)
            'upload-file' => array( 
                'rule' => array('uploadError'),
                'message' => array('アップロード時にエラーがあります。')
            ),
            // ルール：extension（拡張子） => pathinfoを使用して拡張子を検証
            'extension' => array(
                'rule' => array( 'extension', array( 
                    'jpg', 'jpeg', 'png', 'gif')  // 拡張子を配列で定義
                ),
                'message' => array('拡張子をjpg or png or gifで選んでください。')
            ),
            // ルール：mimeType => 
            // finfo_file(もしくは、mime_content_type)でファイルのmimeを検証 (2.2 以降)
            // 2.5 以降 - MIMEタイプを正規表現(文字列)で設定可能に
            'mimetype' => array( 
                'rule' => array( 'mimeType', array( 
                    'image/jpeg', 'image/png', 'image/gif')  // MIMEタイプを配列で定義
                ),
                'message' => array( 'MIME typeにエラーがあります。')
            ),
            // ルール：fileSize => filesizeでファイルサイズを検証(2GBまで)  (2.3 以降)
            'size' => array(
                'maxFileSize' => array( 
                    'rule' => array( 'fileSize', '<=', '100MB'),  // 100M以下
                    'message' => array( '100メガサイズ以下の画像を選択してください。')
                ),
                'minFileSize' => array( 
                    'rule' => array( 'fileSize', '>',  0),    // 0バイトより大
                    'message' => array( 'file size error')
                ),
            ),
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