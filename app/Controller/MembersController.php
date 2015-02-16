<?php

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class MembersController extends AppController {

    //Authの仕様のログインページへのリンク回避
    public function beforeFilter() {
        parent::beforeFilter();

        //リンク回避の範囲全体
        $this->Auth->allow();
    }

    public function index() {

        // ② セッション情報ある場合、入力（checkから戻ったとき）
        
        /**
         * この処理はPOSTされたタイミングでは不要な処理のため
         * 記入する位置を調整してください
         */
        
        // → ここにSessionの中身をフォームにする処理を書いてしまうとpostで判定が通った際も処理が実行されてしまう。

        // ① Postが送られたタイミングでデータが格納される（index内のvalidation）

        if ($this->request->is('post')) {
            $this->Member->set($this->request->data['Member']);
            // リクエストデータの形式Post

            if ($this->Member->validates()) {

                //echo"<pre>";var_dump($this->request->data);echo"</pre>";
                //echo exit;

                $this->Session->write('Posting', $this->request->data['Member']);
                return $this->redirect(array('action' => 'check'));

                //echo '成功です。';
            }
                
                /**
                 * 無駄なeles文は書かないこと
                 */

                // → 削除
            
            
        }
        
        if (($this->Session->read('Posting')) && (empty($this->request->data['Member']))) {
            $this->request->data['Member'] = $this->Session->read('Posting');
        }
        
        
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
            /**
            * この方式だと
            * postされてる内容にuser_idとかプライマリーキーを入れられていると(開発者ツールでuser_idとかのツール使って勝手にフォーム生成されたりして)
            * UPDATE文になり、勝手にレコードを書き換えることが可能だったりします
            * 
            * cakeでsaveを利用するとinsertとupdateをプライマリーキーで判断してくれちゃうので
            * insertをしたい時はpostデータから必要なデータだけをとりだしてsave
            * もしくはpostデータからプライマリーキーの配列を削除してsaveをするようにしましょう
            */

            // → saveの配列でプライマリーキー以外を導入（idとcreatedとmodifiedは自動で登録される・validateは既にやってるのでどっちでもいい）
            // Model::save(array $data = null, boolean $validate = true, array $fieldList = array())
            // $this->Modelname->save($data,$validate,$fieldList)

            $sessionPlus = $this->Session->read('Posting');
            $passwordHasher = new SimplePasswordHasher();
            $sessionPlus['password'] = $passwordHasher->hash($sessionPlus['password']);

            if ($this->Member->save($sessionPlus,true,array('name','email','password'))) {
                $this->Session->setFlash('Success!');
                $this->Session->delete('Posting');
                /**
                 * redirectは別ページに飛ばし、処理が終わるため
                 * return をつけよう
                 * これがあると、cakeのredirectについて知らない人がコードを呼んでも
                 * saveがtrueだとredirectして終了なんだなって一発でわかるので
                 */

                // → 処理は同じ結果でもコードの見やすさでreturnをふっている。

                return $this->redirect(array('action' => 'thanks'));
            } else {
                $this->Session->setFlash('failed!');
            }
        }
            
            /**
             * この処理をcheckメソッドの一番上で行うことでif文のネストを避けることができる
             * 
             * if(!$this->Session->read('Posting')){
             *      $this->redirect(array('action' => 'index')); 
             *      return;
             * }
             * 
             * if ($this->request->is('post')) {
             * ～～～～～～～～～～～
             */
            
            // → 上部参照。ネスト減少に加え、Sessionない場合にindexに移動の意味でもより読み込み量が少なくシンプルなコードでかける。
        
    }

    public function thanks() {
        
    }

    public function login() {

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