<?php

namespace App\Http\Controllers;

use App\Services\ElasticsearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $elasticsearch;

    public function __construct(ElasticsearchService $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function index(Request $request)
    {
        $this->elasticsearch->index('posts', [
            'title' => 'Sample Post',
            'content' => 'This is a test post for Elasticsearch.'
        ]);

        return response()->json(['message' => 'Document indexed']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = $this->elasticsearch->search('posts', $query);

        return response()->json($results['hits']['hits']);
    }
}
