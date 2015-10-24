<?php
class Controller_Account extends Controller_Base{
  public function action_create(){

    if (Input::method() == 'POST') {
      $val = Model_User::validate('create');

      if ($val->run())
      {
        $user = Model_User::forge(array(
          'name' => Input::post('name'),
          'email' => Input::post('email'),
          'password' => $this->password_hash(Input::post('password')),
          'profile' => Input::post('profile')
        ));

        if ($user and $user->save())
        {
          Session::set_flash('success', 'ユーザを新規作成しました #'.$user->id.'.');
          $this->session_ready_and_redirect($user);
        }
        else
        {
          Session::set_flash('error', 'Could not save User.');
        }
      }
      else
      {
        Session::set_flash('error', $val->error());
      }
    }

    $this->template->title = "新規作成";
		$this->template->content = View::forge('account/create');
  }

  public function action_login(){

    if (Input::method() == 'POST') {
      $val = Model_User::validate('login');
      if($val->run()){
        $user = Model_User::query()
          ->where('email', Input::post('email'))
          ->get_one();

        if(isset($user) && password_verify(Input::post('password'), $user->password)){
          Session::set_flash('success', 'ログインしました');
          $this->session_ready_and_redirect($user);
        } else {
          Session::set_flash('error', 'emailとパスワードが一致しません');
        }
      }
      else
      {
        Session::set_flash('error', $val->error());
      }
    }

    $this->template->title = "ログイン";
		$this->template->content = View::forge('account/login');
  }

  public function action_logout(){
    Session::destroy();
    Response::redirect('/');
  }

  private function password_hash($str){
    return password_hash($str, PASSWORD_BCRYPT);
  }

  private function session_ready_and_redirect($user){
    Session::instance()->rotate(); // セッションIDを変更
    Session::set('user_id', $user->id);
    Response::redirect('/');
  }
}
