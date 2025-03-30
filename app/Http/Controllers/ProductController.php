<?php

namespace App\Http\Controllers;

use App\Services\ElasticsearchService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $elasticsearchService;
    public function __construct(ElasticsearchService $elasticsearchService)
    {
        $this->elasticsearchService = $elasticsearchService;
    }
    public function search(Request $request)
    {
        $keyword = $request->input('query');
        $query = [
            'query' => [
                'match_phrase' => [
                    'name' => $keyword
                ]
            ]
        ];
        $results = $this->elasticsearchService->search('products', $query);
        return response()->json($results->asArray());
    }
}
