<?php

namespace App\Models;

use Illuminate\Http\Client\Request;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = $this->elasticsearch->search('products', $query);

        return response()->json($results['hits']['hits']);
    }
}
