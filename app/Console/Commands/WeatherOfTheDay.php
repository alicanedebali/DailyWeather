<?php

namespace App\Console\Commands;

use App\User;
use Bioudi\LaravelMetaWeatherApi\Weather;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class WeatherOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Daily email to all users with a word and its meaning';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        Cache::flush();
        $users = User::all();
        foreach ($users as $user) {

            if(Cache::has($user->cities)){
                $weat=Cache::get($user->cities);
                Mail::raw("{$user->cities} -> {$weat}", function ($mail) use ($user) {
                    $mail->from('deneme@gmail.com');
                    $mail->to($user->email)
                        ->subject('Weather of the Day');
                });
            }
            else{
                $weather = new Weather();
                $w = $weather->getByCityName($user->cities,date('Y/m/d'));
                $i = 0;
                $we = '';
                foreach ($w as $ww) {
                    if ($i == 0) {
                        $we = $ww;
                    }
                    $i++;
                }
                Cache::put($user->cities, $we->the_temp,600);

                Mail::raw("{$user->cities} -> {$we->the_temp}", function ($mail) use ($user) {
                    $mail->from('deneme@gmail.com');
                    $mail->to($user->email)
                        ->subject('Weather of the Day');
                });
            }

        }

        $this->info('Word of the Day sent to All Users');
    }
}
