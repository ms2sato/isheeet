<?php
class Controller_Auth extends Controller
{
    /**
     * eg. http://www.exemple.org/auth/login/facebook/ will call the facebook opauth strategy.
     * Check if $provider is a supported strategy.
     */
    public function action_login($provider = null)
    {
      if (Auth::check()){
        Log::info('ログイン済みです');
      }

      // 呼び出すための OAuth プロバイダを持っていない場合は出て行く
      if ($provider === null)
      {
          Session::set_flash('error', __('login-no-provider-specified'));
          \Response::redirect_back();
      }

      // Opauth の読み込み、プロバイダのストラテジーを読み込みプロバイダにリダイレクトするでしょう
      \Auth_Opauth::forge();
    }

    // Print the user credentials after the authentication. Use this information as you need. (Log in, registrer, ...)
    public function action_callback()
    {
        // Opauth は厄介な雑用のすべての種類を投げることができます、さあ、準備ができました
        try
        {
            // Opauth オブジェクトを取得
            $opauth = \Auth_Opauth::forge(false);

            // そして、コールバックを処理
            $status = $opauth->login_or_register();

            // メッセージを表示できるように opauth 応答からプロバイダ名を取得
            $provider = $opauth->get('auth.provider', '?');

            // コールバック処理の結果を扱う
            switch ($status)
            {
                // ローカルのユーザがログインしていて、プロバイダはこのユーザーと関連付けられている
                case 'linked':
                    // 関連付けが正常に行われたことをユーザに通知
                    Session::set_flash('success', sprintf(__('login.provider-linked'), ucfirst($provider)));
                    // そして、この状態のためのリダイレクト URL を設定
                    $url = 'dashboard';
                break;

                // 既知のプロバイダへ関連付けられ、そのアカウントでログイン
                case 'logged_in':
                    // プロバイダを使用してログインが成功したことをユーザーに通知
                    Session::set_flash('success', sprintf(__('login.logged_in_using_provider'), ucfirst($provider)));
                    // そして、この状態のためのリダイレクト URL を設定
                    $url = 'dashboard';
                break;

                // このプロバイダでのログインは知らないので、最初にユーザーにローカルアカウントを作成するように依頼
                case 'register':
                    // プロバイダを使用してログインが成功したことをユーザーに通知、しかし、続けるにはローカルアカウントが必要です
                    // Session::set_flash('success', sprintf(__('login.register-first'), ucfirst($provider)));
                    Session::set_flash('success', 'ログインしました');
                    $user_hash = \Session::get('auth-strategy.user', array());
                    $created = \Auth::create_user(
                        \Arr::get($user_hash, 'name'),
                        'dummy', #TODO: ランダムで作るなどする
                        \Arr::get($user_hash, 'email'),
                        \Config::get('application.user.default_group', 1),
                        array(
                            'fullname' => \Arr::get($user_hash, 'name'),
                        )
                    );

                    Debug::dump($created);exit;

                    $this->link_provider();

                    // そして、この状態のためのリダイレクト URL を設定
                    $url = '/';
                break;

                // このプロバイダでのログインは知らなかったが、十分な情報が返されたのでユーザーを自動的に登録した
                case 'registered':
                    // プロバイダを使用してログインが成功したことをユーザーに通知、そして、ローカルアカウントが作成された
                    Session::set_flash('success', __('login.auto-registered'));
                    // そして、この状態のためのリダイレクト URL を設定
                    $url = 'dashboard';
                break;

                default:
                    throw new \FuelException('Auth_Opauth::login_or_register() has come up with a result that we dont know how to handle.');
            }

            // リダイレクト先の URL をセット
            \Response::redirect($url);
        }

        // Opauth の例外を処理
        catch (\OpauthException $e)
        {
            Session::set_flash('error', $e->getMessage());
            \Response::redirect_back();
        }

        // 認証の試みをユーザーが取り消しをしたことを捕捉 (一部のプロバイダはこれを許可)
        catch (\OpauthCancelException $e)
        {
            // おそらく、ここでもう少しきれいな何かをする必要があります...
            exit('It looks like you canceled your authorisation.'.\Html::anchor('users/oath/'.$provider, 'Click here').' to try again.');
        }
    }

    protected function link_provider($userid)
    {
        // 一致する認証ストラテジーを持っているか？
        if ($authentication = \Session::get('auth-strategy.authentication', array()))
        {
            // ストラテジーの呼び出しではなくオブジェクトのインスタンスが必要なので false を渡すことを忘れないでください
            $opauth = \Auth_Opauth::forge(false);

            // ローカルユーザーとプロバイダのログインを関連付けるため Opauth を呼び出す
            $insert_id = $opauth->link_provider(array(
                'parent_id' => $userid,
                'provider' => $authentication['provider'],
                'uid' => $authentication['uid'],
                'access_token' => $authentication['access_token'],
                'secret' => $authentication['secret'],
                'refresh_token' => $authentication['refresh_token'],
                'expires' => $authentication['expires'],
                'created_at' => time(),
            ));
        }
    }
}
