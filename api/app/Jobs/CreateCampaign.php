<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
class CreateCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $formobject; // declaring public variabe form object to store the incoming form data
    public function __construct($formdata)
    {
        $this->formobject = $formdata;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

        $client->post('https://www.teezily.com/api/v1/campaigns',[
            'headers' => [
                            "Authorization" => "Bearer ".env('TEEZ_KEY') // The constant Teez Key is uploaded in the .env file
                         ]
            ]);
    }
}
