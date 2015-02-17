<?php

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class MembersController extends AppController {

    //Authの仕様のログインページへのリンク回避
    public function beforeFilter() {
        parent::beforeFilter();

        //リンク回避の範囲全体
        /**
         * リンク回避は正しい表現ではない
         * Auth認証なしでアクセスできるメソッドの定義です
         */
        $this->Auth->allow();
    }

    public function index() {      
        
        if ($this->request->is('post')) {
            
            //もし画像入力があれば更新される。なかったらそのまま（セッション’Photo’で制御）
            if($this->request->data['Member']['image']['name']){
                
                // 画像をアップロードする
                $image = date('YmdHis') . $this->request->data['Member']['image']['name'];

                // アップロード（一時フォルダ（temporary）フォルダを介する。P111）
                move_uploaded_file($this->request->data['Member']['image']['tmp_name'], IMAGES . 'member_picture' . DS . $image);               

                //この時点でpicture name書き換えておかないと$imageの値を他の関数に引き継げない。
                //ここの部分はViewにおける表示画面の参照元を表すので、表示名を変えても構わない。
                $this->request->data['Member']['image']['name'] = $image;
                /**
                 * 無駄にセッション書き込まなくても
                 * Postingに画像の情報を格納してしまえばいいんじゃないかな,
                 * saveの処理も楽になるだろうし
                 */
                $this->Session->write('Photo', $this->request->data['Member']['image']['name']);
                
            }
            
            $this->request->data['Member']['image']['name'] = $this->Session->read('Photo');
            
            $this->Member->set($this->request->data['Member']);
            // リクエストデータの形式Post

            if ($this->Member->validates()) {
                             
                $this->Session->write('Posting', $this->request->data['Member']);                
                return $this->redirect(array('action' => 'check'));

            }                        
            
        }
        
        if (($this->Session->read('Posting')) && (empty($this->request->data['Member']))) {
            $this->request->data['Member'] = $this->Session->read('Posting');
        }
        
        //画像ファイルが一度でもアップされているか否か
        if($this->Session->read('Photo')){
        
            $sessionCheck = $this->Session->read('Posting');
            
            /**
             * imgexistで画像あるか判定してると思うけど
             * view側で$this->dataでrequest->dataの値を参照できるので
             * 上のほうで書いたセッション関係のコメントと合わせて考えると
             * imgexistは不要になるんじゃないかと
             */
            $this->set('imgexist', 'true');
                        
            if($this->request->data['Member']['image']){
                $this->set('imgpass', $this->request->data['Member']['image']);                         
            }else if($sessionCheck['image']){ //重複してる場合はリクエストデータが優先される。
                $this->set('imgpass', $sessionCheck['image']);                
            }
            
        }else{
            
            $this->set('imgexist', 'false');
            
        }
        
        //var_dump($this->request->data['Member']['image']['name']);var_dump($this->Session->read('Photo'));exit;
        $this->set('photo', $this->Session->read('Photo'));
        
    }

    public function check() {

        //ここでセッション情報がない場合を書くことで、セッション情報がある場合と考えたif文を１段階減らせている。
        if(!$this->Session->read('Posting')){
            $this->redirect(array('action' => 'index')); 
            return;
        }
        
        // echo"<pre>";var_dump($this->Session->read('Posting'));echo"</pre>";exit;
        //セッション情報がきちんと入力されているか否かでindexからステップを経て来ているか判別


        $this->set('sesposts', $this->Session->read('Posting'));
        

        if ($this->request->is('post')) {

            //パスワードを暗号化する

            // → saveの配列でプライマリーキー以外を導入（idとcreatedとmodifiedは自動で登録される・validateは既にやってるのでどっちでもいい）
            // Model::save(array $data = null, boolean $validate = true, array $fieldList = array())
            // $this->Modelname->save($data,$validate,$fieldList)

            $sessionPlus = $this->Session->read('Posting');
            $passwordHasher = new SimplePasswordHasher();
            $sessionPlus['password'] = $passwordHasher->hash($sessionPlus['password']);
 
            $sessionPlus['picture'] = $sessionPlus['image']['name']; 

            //var_dump($sessionPlus);exit;
            
            //画像アップロードでエラーが出るので、バリデーションをfalseにしておく
            if ($this->Member->save($sessionPlus,false,array('name','email','password','picture'))) {
                //var_dump($sessionPlus);exit;
                $this->Session->setFlash('Success!');
                $this->Session->delete('Posting');
                $this->Session->delete('Photo');

                // → 処理は同じ結果でもコードの見やすさでreturnをふっている。

                return $this->redirect(array('action' => 'thanks'));
            } else {
                $this->Session->setFlash('failed!');
            }
        }
        
    }

    public function thanks() {
        
    }

    public function login() {

        //既にログインされている状態ならばページ移動
        if ($this->Auth->loggedIn()) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                //public $componentsで指定した場所にアクセスする。
                //redirectは2.3で廃止されている。
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        }
        
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }

}

?>