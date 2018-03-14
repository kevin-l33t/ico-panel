<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client;
use App\Token;
class ConfirmCreateTokenTx implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The Token instance.
     *t
     * @var Note
     */
    protected $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 10.0
        ]);

        $try = 50;

        while ($try > 0) {
            $response = $client->request('GET', 'ico/contract/'.$this->token->user->wallet[0]->address, [
                'http_errors' => false,
                'headers' => [
                    "Authorization" => "API-KEY TESTKEY",
                    "Content-Type" => "application/json"
                ]
            ]);
            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents());
                if ($result->success) {
                    $this->token->crowdsale_address = $result->crowdsale;
                    $this->token->token_address = $result->token;
                    $this->token->status = 1;
                    $this->token->save();
                    break;
                }
            }
            $try--;
            sleep(10);
        }
    }
}
