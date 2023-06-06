<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClient;
use Illuminate\Http\Request;
use App\Http\Resources\ClientResource;
use App\Models\Client;

class ClientsController extends Controller
{
    public function index(Request $request){
        $clients = Client::query();
        foreach($request->input('filters',[]) as $filter => $value){
            $clients->{$filter}($value);
        }
        return ClientResource::collection($clients->get());
    }

    public function show(Client $client){
        return new ClientResource($client);
    }

    public function store(StoreClient $request){
        $params = $request->validated();
        $client = Client::create($params);
        return new ClientResource($client);
    }

    public function delete(Client $client){
        $client->delete();
        return new ClientResource($client);
    }
}
