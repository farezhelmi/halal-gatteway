<?php

namespace App\Jobs;

use App\Models\Trn\Bills;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\iPusaka\iPusakaRegistrations;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class iPusakaBillMonthly implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $registrations = iPusakaRegistrations::where('status_registration_id','=',5)->get();

        foreach ($registrations as $registration) 
        {
            $check_bill = Bills::where([['product_id','=',1],['registration_id','=',$registration->id],['year','=',date("Y")],['month','=',date("m")]])->first();

            if($check_bill == null)
            {
                $bill = Bills::create([
                    'product_id' => 1,
                    'registration_id' => $registration->id,
                    'payment_method_id' => $registration->payment_method_id,
                    'year' => date("Y"),
                    'month' => date("m"),
                    'amount' => $registration->package->monthly,
                    'status_payment_id' => 1,
                    'created_at' => NOW(),
                    'created_by' => 0,
                ]);
            }
        }
    }
}
