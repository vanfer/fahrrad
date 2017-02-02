<?php

namespace App\Http\Controllers;

use App\Fahrer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * @return mixed
     */
    public function autocompleteName(){
        $term = Input::get('term');

        $results = [];

        $queries = DB::table('fahrer')->where('name', 'LIKE', '%'.$term.'%')->take(5)->get();
        foreach ($queries as $query){
            $results[] = [ 'id' => $query->id, 'value' => $query->name ];
        }

        return Response::json($results);
    }

}
