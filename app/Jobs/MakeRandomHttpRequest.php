<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MakeRandomHttpRequest implements ShouldQueue
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
        $endpoint = 'https://randomuser.me/api/';
        $response = Http::get($endpoint);

        if ($response->successful()) {
            $responseData = $response->json('results');
            Log::info('HTTP Request Response Data: ', $responseData);
        } else {
            Log::error('HTTP Request Failed with Status: ' . $response->status());
        }
    }
}
