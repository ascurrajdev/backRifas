<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionsController extends Controller
{
    public function index(Request $request){
        $collection = Collection::with(['user','client']);
        foreach($request->input('filters', []) as $filter => $value){
            $collection->{$filter}($value);
        }
        return CollectionResource::collection($collection->get());
    }
}
