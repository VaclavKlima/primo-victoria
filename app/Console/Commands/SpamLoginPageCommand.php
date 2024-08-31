<?php

namespace App\Console\Commands;

use GuzzleHttp\Exception\ConnectException;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class SpamLoginPageCommand extends Command
{
    protected $signature = 'spam:login-page';

    protected $description = 'Fast script to spam one fishing page';

    public function handle(): void
    {
        $url = "http://www.euthewarwithin.com/login.asp?a=ok";

        foreach (range(1,    100) as $batch) {
            $this->info("Sending batch $batch");
            $res = Http::pool(function(Pool $pool) use ($url) {
                foreach (range(1, 100) as $key) {
                    $faker = \Faker\Factory::create();
                    $pool->post($url, [
                        // use faker to generate random data
                        'accountName' => $faker->userName,
                        'password' => $faker->password,
                        'upgradeVerifier' => '',
                        'useSrp' => 'false',
                        'publicA' => '',
                        'clientEvidenceM1' => '',
                        'persistLogin' => 'on'
                    ]);
                }
            });

            // warn if some requests failed
            foreach ($res as $response) {
                /**
                 * @var \Illuminate\Http\Client\Response $response
                 */
                if ($response instanceof ConnectException) {
                    dump($response);
                }
            }

            $this->info("Batch $batch sent");
            $this->info("Sleeping for 5 seconds");
            sleep(5);
        }


        $this->info('All requests sent');
    }
}
