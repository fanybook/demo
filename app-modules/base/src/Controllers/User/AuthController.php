<?php

namespace Modules\Base\Controllers\User;

use Exception;
use App;
use Auth;
use Request;
use Validator;
use Session;

class AuthController extends \BaseController
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /*
     * Get Method
     */
    public function login()
    {
        return view('base::user.auth.login');
    }

    /*
     * Get Method
     */
    public function register()
    {
        return view('base::user.auth.register');
    }

    /*
     * Get Method
     */
    public function findPassword()
    {
        return view('base::user.auth.find_password');
    }

    /*
     * Get Method
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('srch.home'));
    }

    public function postLogin()
    {
        $response = [
            'result'    => true,
            'message'   => '登录成功，正在跳转',
        ];

        try {

            $validator = Validator::make(Request::all(), [
                'email'    => 'required|email|exists:users',
                'password' => 'required',
            ], [
                'email.required'   => '邮箱不能为空',
                'email.email'      => '邮箱格式有误，请检查',
                'email.exists'     => '该邮箱未注册',
                'password.required'=> '请输入登录密码',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->messages()->first());
            }

            $login_user = [
                'email'    => Request::input('email'),
                'password' => Request::input('password'),
            ];

            if (Auth::attempt($login_user, Request::has('remember_me'))) {
                if (Request::has('return_url')) {
                    $response['go_url'] = Request::input('return_url');
                    Session::forget('url.intended');
                } else {
                    $response['go_url'] = Session::get('url.intended') ? Session::remove('url.intended') : route('srch.home');
                }
            } else {
                throw new Exception('登录失败，密码不正确');
            }

        } catch (Exception $e) {
            $response['result']  = false;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function postRegister()
    {
        $response = [
            'result'    => true,
            'message'   => '注册成功，正在跳转',
        ];

        try {

            $validator = Validator::make(Request::all(), [
                'nickname'  => 'required|unique:users',
                'email'     => 'required|email|unique:users',
                'password'  => 'required|min:6|max:20|confirmed',
                'captcha'   => 'required',
                'accept'    => 'required',
            ], [
                'nickname.required' => '昵称不能为空',
                'nickname.unique'   => '昵称已被使用，请换一个',
                'email.required'    => '邮箱不能为空',
                'email.email'       => '邮箱格式有误，请检查',
                'email.unique'      => '该邮箱已被注册',
                'password.required' => '登录密码不能为空',
                'password.min'      => '密码长度不能小于6位',
                'password.max'      => '密码长度不能大于20位',
                'password.confirmed'=> '两次输入的密码不一致',
                'captcha.required'  => '验证码不能为空',
                'accept.required'   => '必须接受我们的服务条款',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->messages()->first());
            }

            if (!captcha_valid(Request::input('email'))) {
                throw new Exception('验证码无效，请重新取得');
            } elseif (Request::input('captcha') != Session::get('captcha')) {
                Session::set('captcha_try', Session::get('captcha_try') + 1);
                throw new Exception('验证码不正确，请重新输入');
            }

            $new_user = [
                'nickname'  => Request::input('nickname'),
                'email'     => Request::input('email'),
                'password'  => bcrypt(Request::input('password')),
            ];

            $user = App\User::create($new_user);

            if($user) {
                Auth::login($user);
                $response['go_url'] = Session::get('url.intended') ? Session::remove('url.intended') : route('srch.home');

                captcha_destroy();
            } else {
                throw new Exception('注册失败');
            }

        } catch (Exception $e) {
            $response['result']  = false;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function postFindPassword()
    {
        $response = [
            'result'    => true,
            'message'   => '密码已更改，正在跳往登录页面',
            'go_url'    => route('front.auth.login'),
        ];

        try {

            $validator = Validator::make(Request::all(), [
                'email'    => 'required|email|exists:users',
                'password'  => 'required|min:6|max:20|confirmed',
                'captcha'  => 'required',
            ], [
                'email.required'    => '邮箱不能为空',
                'email.email'       => '邮箱格式有误，请检查',
                'email.exists'      => '该邮箱未注册',
                'password.required' => '请输入登录密码',
                'password.min'      => '密码长度不能小于6位',
                'password.max'      => '密码长度不能大于20位',
                'password.confirmed'=> '两次输入的密码不一致',
                'captcha.required'  => '验证码不能为空',
            ]);

            if ($validator->fails()) {
                throw new Exception($validator->messages()->first());
            }

            if (!captcha_valid(Request::input('email'))) {
                throw new Exception('验证码无效，请重新取得');
            } elseif (Request::input('captcha') != Session::get('captcha')) {
                Session::set('captcha_try', Session::get('captcha_try') + 1);
                throw new Exception('验证码不正确，请重新输入');
            }

            $get_user = App\User::where('email', Request::input('email'))->first();

            if (!$get_user) {
                throw new Exception('该用户已被删除');
            }

            $get_user->password = bcrypt(Request::input('password'));
            $get_user->save();

            captcha_destroy();

        } catch (Exception $e) {
            $response['result']  = false;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }
}
