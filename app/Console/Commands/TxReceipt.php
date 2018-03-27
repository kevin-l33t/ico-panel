<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\TransactionLog;
use Mail;

class TxReceipt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receipt:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Transaction Receipt and update Tx Status in DB';

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
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 5.0
        ]);

        $this->info("Transaction Receipt Worker is started. Monitoring unconfirmed transactions");
        while(true) {
            $logs = TransactionLog::where('status', 0)
                                    ->whereNotNull('tx_hash')
                                    ->get();
            try {
                foreach($logs as $item) {
                    // create new wallet for the user.

                    $response = $client->request('GET', 'eth/tx/receipt/'.$item->tx_hash, [
                        'http_errors' => false,
                        'headers' => [
                            "Authorization" => "API-KEY TESTKEY"
                        ]
                    ]);

                    if ($response->getStatusCode() == 200) {
                        $result = json_decode($response->getBody()->getContents());
                        if ($result->success) {
                            if ($result->status == 1) {
                                $item->status = 1;
                                if (!empty($result->data)) {
                                    $item->token_value = $result->data;
                                }
                                if ($item->type->name == 'Ethereum') {
                                    Mail::to($item->wallet->user)
                                        ->queue(new \App\Mail\EtherTxApproved($item));
                                }
                                $this->info("tx: $result->tx_hash staus: $result->status success, data: $result->data");
                            } else {
                                $item->status = 2;
                                $this->comment("tx: $result->tx_hash staus: $result->status Failed");
                            }
                            $item->save();
                        }
                    }
                }
            } catch(\Exception $ex) {
                $this->error($ex->getMessage());
            }
            sleep(20);
        }
    }
}
