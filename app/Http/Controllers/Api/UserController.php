<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Hash, DB, Mail, Auth};
use App\Mail\OrderShipped;
use App\Models\Order;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
class UserController extends Controller
{
    public function signup(Request $request) {
        // signup→メールアドレスで認証→認証したらToken発行してマイページに遷移する
        clock($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            clock($validator);
            return response()->json([
                'message' => '入力内容を確認してください'
            ], 401);
        }

        $user = new User();

        $duplicateCheck = User::where('email', $request->email)->first();

        if ($duplicateCheck) {
            return response()->json([
                'message' => 'すでに登録されているユーザーです'
            ], 401);
        }

        $hash_password = Hash::make($request->password);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $hash_password;
        $user->save();

        $token = $user->createToken('token')->plainTextToken;
        
        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
        // $user->fill($request->all())->save();
        // メールを送信できるようにするもの。メールから別途email_verified_atを更新するメソッドを書く必要あり。
        // event(new Registered($user));
        // メール送れるようにするもの
        // Mail::to($request->email)->send(new OrderShipped());
    }

    public function signin(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => '入力内容を確認してください'
            ], 401);
        };

        $user = User::where('email', $request->email)->first();

        clock($request->password);

        if (is_null($user)) {
            return response()->json(['message' => 'メールアドレスまたはパスワードが違います'], 400);
        }

        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);
        } else {
            return response()->json(['message' => 'メールアドレスまたはパスワードが違います'], 400);
        }
    }
}



