<?php

namespace App\Http\Controllers\Api;

use App\Models\Raffle;
use App\Models\Status;
use App\Models\Payment;
use App\Models\Collection;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Jobs\SyncPaymentTpago;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Facades\Payment as PaymentFacade;

class PaymentLinksController extends Controller
{
    use ResponseTrait;
    public function generateLink(Request $request){
        $request->validate([
            'raffle_id' => ['required', 'exists:raffles,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'quantity' => ['required'],
            'user_id' => ['required','exists:users,id']
        ]);
        $pending = Status::where('is_pending',true)->first();
        $raffle = Raffle::findOrFail($request->raffle_id);
        $response = PaymentFacade::generateLink($request->input('quantity',0)."x ".$raffle->description,($raffle->amount * $request->input('quantity',0)));
        $payment = Payment::create([
            'amount' => $response['payment_link']['amount'],
            'currency' => 'PYG',
            'status_id' => $pending->id,
            'description' => $response['payment_link']['description'],
            'link_url' => $response['payment_link']['link_url'],
            'identifier_provider' => $response['payment_link']['link_alias'],
            'provider' => 'tpago',
        ]);
        $collection = Collection::create([
            'user_id' => $request->user_id,
            'amount' => ($raffle->amount * $request->input('quantity',0)),
            'client_id' => $request->client_id
        ]);
        $collection->detail()->create([
            'raffle_id' => $request->raffle_id,
            'quantity' => $request->input('quantity',0),
            'amount' => ($raffle->amount * $request->input('quantity',0)),
        ]);
        $collection->detailPayment()->create([
            'payment_id' => $payment->id,
            'amount' => ($raffle->amount * $request->input('quantity',0)),
        ]);
        return $this->success([
            'url' => $payment->link_url
        ]);
    }

    public function callback(Request $request){
        $params = $request->all();
        Log::info($params);
        $reply = [
            'messages' => []
        ];
        $reply['status'] = $params['payment']['status'] == "confirmed" ? "success" : "error";
        $reply['messages'][] = [
            "level" => $reply['status'],
            "key" => $params['payment']['status'] == "confirmed" ? "Confirmed" : "ConfirmedError",
            "description" => $params['payment']['response_description'],
        ];
        SyncPaymentTpago::dispatch($reply, $params);
        return response()->json($reply);
    }
}
