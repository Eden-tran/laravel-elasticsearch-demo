<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\ElasticsearchService;

class SyncProductToElasticsearch implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $product;
    protected $index;
    public function __construct(array $product)
    {
        $this->product = $product;
        $this->index = 'products';
    }
    /**
     * Execute the job.
     */
    public function handle(ElasticsearchService $elasticService)
    {
        $elasticService->index($this->index,$this->product);
    }
}
