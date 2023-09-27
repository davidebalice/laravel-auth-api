<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;
use Illuminate\Support\Facades\Auth;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use App\Models\User;
use Exception;
class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'login',
        'description' => 'User login mutation'
    ];

    public function type(): Type
    {
        return Type::string();
    }

    public function args(): array
    {
        return [
            'username' => [
                'name' => 'username',
                'type' => Type::string(),
                'description' => 'Username',
                'rules' => ['required'],
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::string(),
                'description' => 'Password',
                'rules' => ['required'],
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $credentials = [
            'username' => $args['username'],
            'password' => $args['password'],
        ];

        if (auth()->attempt($credentials)) {
            
            try{
                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    $token = $user->createToken('app')->accessToken;

                    return response([
                        'message' => "Successfully login",
                        'token' => $token,
                        'server' => 'laravel'
                    ],200);
                }

            }catch(Exception $exception){
                return response([
                    'message' => $exception->getMessage()
                ],400);
            }
            return response([
                'message' => 'Invalid Username or Password'
            ],401);
           
        } else {
            return 'Invalid Username or Password';
        }
    }
}
