<?php

namespace App\Listeners;

use App\Events\Birthday;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Mail\BirthdayMail;

class SendBirthdayNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        // 
    }

    /**
     * Handle the event.
     */
    public function handle(Birthday $event): void
    {
        $datas= User::get();
       
        foreach($datas as $data){
             //dd($data->email);
             \Mail::to($data->email)->send(new BirthdayMail($event->post));
        }
        
    }
}
