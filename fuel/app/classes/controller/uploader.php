<?php
class Controller_Uploader extends Controller_Rest
{
    public function get_index(){
      var_dump('post index test');
      $this->response(['test'=>'OK']);
    }

    public function post_index()
    {
        // プロファイリング停止
        Fuel::$profiling = false;

        // アップロード設定
        $config = array(
            'path' => DOCROOT.'upload', //TODO: あとで変える
            // 'ext_whitelist' => array('jpg', 'jpeg', 'gif', 'png'),
            'ext_whitelist' => array('jpg', 'jpeg'),
        );
        Log::debug('1');
        // アップロード
        $json = array();
        \Upload::process($config);
        Log::debug('2');
        if ( \Upload::is_valid() )
        {
          Log::debug('is_valid');
            \Upload::save();
            $json = \Upload::get_files(0);
        }
        else
        {
          Log::debug('is_error');
          $json['errors'] = \Upload::get_errors();
          Debug::dump($json['errors']);
        }

        $this->response($json);
    }
}
