<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use App\Models\User;

class LoginMutation extends Mutation
{
    protected $attributes = [
        'name' => 'login',
        'description' => 'User login mutation'
    ];

    public function type(): Type
    {
        return Type::string(); // Puoi restituire il tipo che desideri per il risultato del login
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
            // L'utente è stato autenticato con successo
            // Puoi generare e restituire un token di autenticazione qui se necessario
            return 'Login riuscito!';
        } else {
            // L'utente non è stato autenticato
            return 'Credenziali non valide';
        }
    }
}
