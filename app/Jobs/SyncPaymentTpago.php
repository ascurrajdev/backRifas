<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;
use App\Models\Status;
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
        $done = Status::where('is_done',true)->first();
        $payment = Payment::with('collection')->where('identifier_provider',$this->params['payment']['link_alias'])->first();
        if($this->reply['status'] == 'success' && !empty($payment) && $payment->status_id != $done->id){
            $payment->update([
                'status_id' => $done->id
            ]);
            foreach($payment->collection as $collection){
                $collection->paid += $payment->amount;
                $collection->save();
            }
        }
    }
}
