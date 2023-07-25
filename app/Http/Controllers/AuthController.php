<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function createUser(CreateUserRequest $r){

        $user=User::create([
            'name'=>$r->name,
            'email'=>$r->email,
            'password'=>Hash::make($r->password),

        ]);




        return response()->json([
            'status'=>true,
            'message'=>'Usuario creado correctamente',
            'token'=>$user->createToken("API TOKEN")->plainTextToken
        ],200);



    }

    public function LoginUser(LoginUserRequest $lur){

        if(!Auth::attempt($lur->only(['email','password']))){
            //falla, es decir, email o password, o ambos, son incorrectos
            return response()->json(
                [
                    'status'=>false,
                    'message'=>'Email o password, incorrectos'

                ],401);


        }else{

           // $user=User::find($lur->email);
            $user=User::where('email',$lur->email)->first();
            return  response()->json([

                'status'=>true,
                'message'=>'User logeado correctamente',
                'token'=>$user->createToken("API TOKEN")->plainTextToken,

            ],200);


        }




    }
}
