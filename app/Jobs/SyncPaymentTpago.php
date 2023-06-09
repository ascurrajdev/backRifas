<?php

namespace App\Jobs;

use App\Models\Status;
use App\Models\Payment;
use App\Models\UserRaffle;
use App\Mail\ConfirmPayment;
use App\Mail\ConfirmPaymentToUser;
use App\Models\RaffleNumber;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class SyncPaymentTpago implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $reply;
    public $params;
    /**
     * Create a new job instance.
     */
    public function __construct($reply, $params)
    {
        $this->reply = $reply;
        $this->params = $params;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info($this->reply);
        $done = Status::where('is_done',true)->first();
        $payment = Payment::with('collection')->where('identifier_provider',$this->params['payment']['link_alias'])->first();
        if($this->reply['status'] == 'success' && !empty($payment) && $payment->status_id != $done->id){
            $payment->update([
                'status_id' => $done->id
            ]);
            foreach($payment->collection as $collection){
                $collection->load(['client','detail','user']);
                Mail::to($collection->client->email)->send(new ConfirmPayment($payment, $collection));
                Mail::to($collection->user->email)->send(new ConfirmPaymentToUser($collection));
                $collection->paid += $payment->amount;
                $collection->save();
                foreach($collection->detail as $item){
                    for($i = 1; $i <= $item->quantity; $i++){
                        $userRaffle = UserRaffle::where('user_id',$collection->user_id)->where('raffle_id',$item->raffle_id)->first();
                        $raffleNumbers = RaffleNumber::where('raffle_id',$item->raffle_id)->get(['number','user_id','id']);
                        $number = 1;
                        if($raffleNumbers->count() > 0){
                            $lastRaffleNumber = $raffleNumbers->where('user_id',$collection->user_id)->sortByDesc('id')->first();
                            if(!empty($lastRaffleNumber)){
                                $number = $lastRaffleNumber->number + 1;
                            }else if(!empty($userRaffle)){
                                $number = !empty($userRaffle->min_number) ? $userRaffle->min_number : 1;
                            }
                        }else if(!empty($userRaffle)){
                            $number = !empty($userRaffle->min_number) ? $userRaffle->min_number : 1;
                        }
                        RaffleNumber::create([
                            'collection_id' => $item->collection_id,
                            'user_id' => $collection->user_id,
                            'client_id' => $collection->client_id,
                            'raffle_id' => $item->raffle_id,
                            'number' => $number,
                        ]);
                    }
                }
            }
        }
    }
}
