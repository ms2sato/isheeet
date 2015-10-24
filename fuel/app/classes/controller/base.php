<?php
class Controller_Base extends Controller_template{
  private $current_user;

  public function before(){
    parent::before();
    $this->check_csrf();
    $this->verify_auth();

    $this->template->current_user = $this->current_user();
  }

  protected function current_user(){
    return $this->current_user;
  }

  protected function is_logged_in(){
    return isset($this->current_user);
  }

  private function check_csrf(){
    if (Input::method() == 'POST') {
      // CSRF
      if(!Security::check_token()){
        Session::set_flash('error', 'csrf token invalid');
        Response::redirect('/');
      }
    }
  }

  private function verify_auth(){
    $user_id = Session::get('user_id');
    if(!isset($user_id)){
      return;
    }
    $this->current_user = Model_User::find($user_id);
  }
}
