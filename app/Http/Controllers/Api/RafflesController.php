<?php

namespace App\Http\Controllers\Api;

use App\Models\Raffle;
use App\Models\UserRaffle;
use App\Models\AdminRaffle;
use Illuminate\Support\Str;
use App\Models\RaffleNumber;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\StoreRaffle;
use App\Http\Requests\UpdateRaffle;
use App\Http\Controllers\Controller;
use App\Http\Resources\RaffleResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class RafflesController extends Controller
{
    use ResponseTrait;

    public function statistics(Raffle $raffle){
        $statisticQuantitySold = DB::table('raffles')->leftJoin('raffle_numbers','raffles.id','=','raffle_numbers.raffle_id')->leftJoin('collections','raffle_numbers.collection_id','=','collections.id')->selectRaw('raffles.id, raffles.quantity, COUNT(raffle_numbers.id) as sold_quantity, COALESCE(SUM(collections.paid),0) AS sold_amount')->whereRaw('raffles.id = ?',[$raffle->id])->groupBy(['raffles.id','raffles.quantity'])->first();
        $detailsAmountByDate = DB::table('collections')->selectRaw('COALESCE(date(collections.created_at) ,CURDATE()) AS date_sold, COALESCE(SUM(collections.amount),0) AS amount_sold')->whereRaw('collections.id in (SELECT rn.collection_id from raffle_numbers rn where rn.raffle_id = ?)',[$raffle->id])->groupBy('collections.created_at')->get();
        $detailsAmountByUsersAndDate = DB::table('users')->selectRaw('users.name, users.id, COALESCE(date(raffle_numbers.created_at) ,CURDATE()) AS date_sold, COALESCE(SUM(collections.amount),0) AS amount_sold, COUNT(raffle_numbers.id) AS quantity_sold, raffles.quantity')->leftJoin('raffle_numbers','raffle_numbers.user_id','=','users.id')->leftJoin('raffles','raffles.id','=','raffle_numbers.raffle_id')->leftJoin('collections','collections.id','=','raffle_numbers.collection_id')->where('raffle_numbers.raffle_id','=',$raffle->id)->groupBy(['users.name','users.id','raffle_numbers.created_at','raffles.quantity'])->get();
        $userRaffles = DB::table('user_raffles')->select(['user_raffles.user_id','users.name'])->leftJoin('users','users.id','=','user_raffles.user_id')->where('raffle_id',$raffle->id)->get();
        $detailsDateAmount = [];
        $datesArray = collect(range(6,0))->map(function($value){
            return now()->subDay($value)->format("Y-m-d");
        });
        $detailsTotalAmount = [];
        foreach($datesArray as $date){
            $detailsTotalAmount[$date] = $detailsAmountByDate->contains('date_sold',$date) ?  $detailsAmountByDate->where('date_sold',$date)->first()->amount_sold : 0;
        }
        $detailsDateAmount[] = [
            'key' => 'Total Recaudado',
            'data' => array_values($detailsTotalAmount)
        ];
        foreach($userRaffles as $user){
            $detailsTotalAmount = [];
            foreach($datesArray as $date){
                $detailsTotalAmount[$date] = $detailsAmountByUsersAndDate->where('date_sold',$date)->where('id',$user->user_id)->isNotEmpty() ? $detailsAmountByUsersAndDate->where('date_sold',$date)->where('id',$user->user_id)->first()->amount_sold : 0;
            }
            $detailsDateAmount[] = [
                'key' => $user->name,
                'data' => array_values($detailsTotalAmount)
            ];
        }
        return $this->success([
            "totals" => $statisticQuantitySold,
            "dates" => $datesArray,
            "details" => $detailsDateAmount,
            'users' => $detailsAmountByUsersAndDate
        ]);
    }

    public function index(Request $request){
        $this->authorize("viewAny",[Raffle::class]);
        $raffles = Raffle::query();
        $user = $request->user();
        $rafflesForUser = UserRaffle::where('user_id',$user->id)->get(['raffle_id'])->pluck('raffle_id')->toArray();
        $rafflesForAdmin = AdminRaffle::where('user_id',$user->id)->get(['raffle_id'])->pluck('raffle_id')->toArray();
         
        $raffles->where("id",array_merge($rafflesForUser,$rafflesForAdmin));
        foreach($request->input('filters',[]) as $key => $value){
            $raffles->{$key}($value);
        }
        return RaffleResource::collection($raffles->get());
    }

    public function show(Raffle $raffle){
        return new RaffleResource($raffle);
    }

    public function store(StoreRaffle $request){
        $params = $request->validated();
        if($request->hasFile("image")){
            $params["image_url"] = Storage::url($request->file('image')->store("raffles","public"));
            unset($params['image']);
        }
        $raffle = Raffle::create($params);
        $raffle->admin()->attach($request->user()->id);
        $raffle->users()->attach($request->user()->id,[
            "id" => (string) Str::uuid()
        ]);
        return new RaffleResource($raffle);
    }

    public function update(Raffle $raffle, UpdateRaffle $request){
        $params = $request->validated();
    }
    public function delete(Raffle $raffle){
        $raffle->delete();
        return new RaffleResource($raffle);
    }

    public function getDetails($token){
        $userRaffle = UserRaffle::with(['user','raffle'])->findOrFail($token);
        $raffleNumber = RaffleNumber::where('user_id',$userRaffle->user_id)->where('raffle_id',$userRaffle->raffle_id)->orderBy('created_at','desc')->first();
        $number = !empty($raffleNumber) ? $raffleNumber->number : ($userRaffle->min_number - 1);
        if(empty($number)){
            $number = 0;
        }
        if(($userRaffle->max_number - $number) < 1 && !empty($userRaffle->max_number)){
            return $this->error("El link expiro",404);
        }
        return $this->success($userRaffle);
    }
}
