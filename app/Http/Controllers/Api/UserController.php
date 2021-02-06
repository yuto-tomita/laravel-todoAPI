<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Hash, DB, Mail};
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
class UserController extends Controller
{
    public function signup(Request $request) {
        // signup→メールアドレスで認証→認証したらToken発行してマイページに遷移する
        $this->validator($request->all())->validate();
 
        $user = new User();
        clock($user);

        DB::insert(
            'insert into users (name, email, password, created_at, updated_at) values (?, ?, ?, ?, ?)',
            [$request->name, $request->email, $request->password, Carbon::now(), Carbon::now()]
        );

        $token = $user->createToken('token-name');
        $token->planeTextToken;

        // $user->fill($request->all())->save();
        // メールを送信できるようにするもの。メールから別途email_verified_atを更新するメソッドを書く必要あり。
        // event(new Registered($user));
        // メール送れるようにするもの
        // Mail::to($request->email)->send(new OrderShipped());

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function signin(Request $request) {
        return $request;
    }

    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max: 255'],
            'email' => ['required', 'string', 'email', 'max: 255'],
            'password' => ['required', 'string']
        ]);

        return $validator;
    }
}



