<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\Auth;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use App\Models\Product; 
use Illuminate\Support\Facades\Log;
class ProductsQuery extends Query
{
    protected $attributes = [
        'name' => 'products',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return Type::listOf(Type::string());
    }

    public function args(): array
    {
        return [

        ];
    }

    public function resolve($root, array $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        //$products = Product::all();

        $select[] = 'id';
        $select[] = 'name';
        $select[] = 'price';
        $select[] = 'photo';
    
        $products = Product::select($select)->get();

/*
        if (!Auth::guard('api')->check()) {
           return response()->json(['error' => 'Not authenticated'], 401);
        }

        try {
            if (!Auth::guard('api')->check()) {
                return response()->json(['error' => 'Not authenticated'], 401);
            }
        } catch (\Exception $e) {
            Log::error('Authenticated error : ' . $e->getMessage());
            return response()->json(['error' => 'Intrernal server error'], 500);
        }*/

       return $products;
    }
}

