<?php 

namespace App\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Datatable {

    private $request; // collection request default datatable
    private $querymode; // string 'model' atau 'table'
    private $querytarget; // string '\App\Model\NamaModel' atau 'tablename'
    private $where; // multidimensional array [['function' => 'where', 'column' => 'column', 'operator' => '=', 'value' => 'value']]
    private $order; // multidimensional array [['column' => 'column', 'order' => 'DESC']]
    private $with; // array ['with1', 'with2']

    public function __construct(Request $request,array $params)
    {
        $this->request = $request;
        $this->querymode = isset($params['querymode']) ? strtolower($params['querymode']) : 'model';
        $this->querytarget = isset($params['querymode']) ? $params['querytarget'] : '\App\User';
        $this->where = isset($params['where']) ? $params['where'] : null;
        $this->order = isset($params['order']) ? $params['order'] : null;
        $this->with = isset($params['with']) ? $params['with'] : null;
    }

    public function getdatatable(){
        $request = $this->request;
        $querymode =  $this->querymode;
        $querytarget = new $this->querytarget;
        $where = $this->where;
        $order = $this->order;
        $with = $this->with;
        
        /*
        * Definisi mode query berdasarkan nama model atau nama table
        */
        if ($querymode == 'model') {
            $data = $querytarget::active()->select('*');
        }
        elseif ($querymode == 'table') {
            $data = DB::table($querytarget)->select('*')->where('is_active', 1);
        }

        $recordTotal = $querytarget::active()->select('count(*) as allcount')->count();
        $recordFiltered = $querytarget::active()->select('count(*) as allcount')->count();

        /*
        * Request default datatable
        */
        $start = (int) $request->get("start");
        $rowPerpage = (int) $request->get("length");
        $columnIndexArray = $request->get('order');
        $columnIndex = $columnIndexArray[0]['column'];
        $columnNameArray = $request->get('columns');
        $columnName = $columnNameArray[$columnIndex]['data'];
        $orderArray = $request->get('order');
        $columnSortOrder = $orderArray[0]['dir'];
        $searchArray = $request->get('search');
        $searchValue = $searchArray['value'];
        
        /*
        * Definisi kolom yang digunakan pada datatable
        */
        foreach ($request->columns as $key => $column) {
            $columns[] = $column['data'];
        }

        /*
        * Request Pencarian default pada datatable
        */
        if ($searchValue) {
            $data = $data->where(function ($query) use ($columns, $searchValue, $with) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . $searchValue . '%');
                }
            });
        }

        /*
        * Definisi relasi eloquent with()
        */
        if ($with) {
            foreach ($with as $func) {
                $data = $data->with($func);
            }
        }
        
        /*
        * Definisi sortir ascendant atau descendant orderBy()
        */
        if ($order) {
            foreach ($order as $func) {
                if (isset($func['column']) && isset($func['order'])) {
                    $data = $data->orderBy($func['column'], $func['order']);
                }
            }
        }
        else {
            $data = $data->orderBy($columnName, $columnSortOrder);
        }

        /*
        * Definisi kondisi where()
        */
        if ($where) {
            foreach ($where as $func) {
                if (isset($func['function']) && isset($func['column']) && isset($func['operator']) && isset($func['value'])) {
                    if(str_contains($func['column'], '.')){
                        $colexplode = explode('.',$func['column']);
                        $operator = $func['operator'];
                        $val = $func['value'];
                        $function = $func['function'];
                        $data = $data->whereHas($colexplode[0],function($query) use ($colexplode,$operator,$val,$function){
                            $query->{$function}($colexplode[1],$operator,$val);
                        });
                    }
                    else{
                        $data = $data->{$func['function']}($func['column'], $func['operator'], $func['value']);
                    }
                }
                elseif (isset($func['function']) && isset($func['column']) && isset($func['values'])) {
                    $data = $data->{$func['function']}($func['column'], $func['values']);
                }
            }
            $recordTotal = $data->count();
        }

        /*
        * Definisi filter datatable
        */
        $filterfunctions = $request->get('filterFunction');
        $filtercolumns = $request->get('filterColumn');
        $filteroperators = $request->get('filterOperator');
        $filtervalues = $request->get('filterValue');
        if ($filterfunctions && $filtercolumns && $filteroperators && $filtervalues) {
            foreach ($filterfunctions as $index => $function) {
                if($filtervalues[$index] != null){
                    $data = $data->$function($filtercolumns[$index], $filteroperators[$index], $filtervalues[$index]);
                }
            }
        }
        elseif ($filterfunctions && $filtercolumns && $filtervalues) {
            foreach ($filterfunctions as $index => $function) {
                if($filtervalues[$index] != null){
                    $data = $data->$function($filtercolumns[$index], $filtervalues[$index]);
                }
            }
        }
        
        $data = $data->skip($start)->take($rowPerpage);

        // $recordFiltered = $data->count();
        $records = $data->get();

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $recordTotal,
            'recordsFiltered' => $recordFiltered,
            'data' => $records
        ]);
    }
}