<?php

namespace App\Jobs;

use App\Models\Order;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $client = new Client();
        $apiEndpoint = 'https://wibip.free.beeceptor.com/order';
        $postData = [
            'Order_ID' => sprintf('%04d', $this->order->id),
            'Customer_Name' => $this->order->customer_name,
            'Order_Value' => $this->order->order_value,
            'Order_Date' => $this->order->created_at->toDateTimeString(),
            'Order_Status' => 'Processing',
            'Process_ID' => (string) $this->order->process_id,
        ];

        try {
            
            $response = $client->post($apiEndpoint, [
                'json' => $postData,
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to send data to 3rd party API', ['error' => $e->getMessage()]);
        }
    }
}
