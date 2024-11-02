<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Mail;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'app:send-mail';
    protected $signature = 'users:send-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $datas= User::select('email')->get();
        $emails=[];
        foreach($datas as $data){
             //dd($data->email);
             //\Mail::to($data->email)->send(new BirthdayMail($event->post));
             $emails[]=$data['email'];
        }

        Mail::send('mail.birthday_mail',[], function($message) use ($emails){
            $message->to($emails)->subject('This is test mail for cron');
        });
    }
}
