<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\Bot;
use App\Models\BotAccounts;
use App\Models\User;
use App\Models\App;
use App\Telegram\TelegramApi;
use App\ShareAccounts\Share;

use App\Jobs\ChargeService;
use App\Jobs\ShareService;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $bots = Bot::query()->get();
            foreach ($bots as $bot) {
                if ($bot->p_type == "HTTP") {
                    $type = "CURLPROXY_HTTP";
                } else if ($bot->p_type == "SOCKS5") {
                    $type = "CURLPROXY_SOCKS5";
                } else if ($bot->p_type == "SOCKS4") {
                    $type = "CURLPROXY_SOCKS4";
                } else {
                    $type = "CURLPROXY_HTTP";
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://check-host.net/ip");
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$bot->p_login}:{$bot->p_password}");
                curl_setopt($ch, CURLOPT_PROXY, "{$bot->p_host}:{$bot->p_port}");
                curl_setopt($ch, CURLOPT_PROXYTYPE, $type);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_exec($ch);
                $header_data= curl_getinfo($ch);
                curl_close($ch);
                if ($header_data['http_code'] != 200) {
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_VERBOSE, 1);
                    curl_setopt($curl, CURLOPT_POST, false);
                    curl_setopt($curl, CURLOPT_URL, $bot->p_link);
                    curl_setopt($curl, CURLOPT_HEADER, true);
                    curl_exec($curl);
                    $header_p = curl_getinfo($curl);
                    curl_close($curl);
                    if ($header_p['http_code'] == 202) {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, "https://check-host.net/ip");
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "{$bot->p_login}:{$bot->p_password}");
                        curl_setopt($ch, CURLOPT_PROXY, "{$bot->p_host}:{$bot->p_port}");
                        curl_setopt($ch, CURLOPT_PROXYTYPE, $type);
                        curl_setopt($ch, CURLOPT_HEADER, true);
                        curl_exec($ch);
                        $header_data= curl_getinfo($ch);
                        curl_close($ch);
                        Bot::query()
                            ->where('id', $bot->id)->update(['p_status' => $header_data['http_code']]);
                    } else {
                        Bot::query()
                            ->where('id', $bot->id)->update(['p_status' => "404"]);
                    }
                } else {
                    Bot::query()
                        ->where('id', $bot->id)->update(['p_status' => $header_data['http_code']]);
                }
            }
        })->everyFifteenMinutes();

        $schedule->call(function () {
            $users = User::all();
            foreach ($users as $user) {
                $data = array(
                    'id' => $user->id,
                );
                ChargeService::dispatch($data);
            }
        })->dailyAt('01:00');

        $schedule->call(function () {
            $need_share = BotAccounts::query()->where('status', '=', 0)->get();
            if ($need_share) {
                $app = $need_share->groupBy('app_id');
                foreach($app as $appid => $actsChat) {
                    $data = array(
                        'id' => $appid,
                    );
                    ShareService::dispatch($data);
                }
            } else {
                TelegramApi::sendMessage("5502743173", "Нет аккаунтов");
            }
        })->everyFifteenMinutes();
    }

    public static function __callStatic(string $name, array $arguments)
    {
        // TODO: Implement __callStatic() method.
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
