<?php

namespace App\DataTables;

use App\Models\Properties;
use Yajra\DataTables\Services\DataTable;
use Request;
use App\Http\Helpers\Common;

class PropertyDataTable extends DataTable
{
    public function ajax()
    {
        $properties = $this->query();
        return datatables()
            ->of($properties)
            ->addColumn('action', function ($properties) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_properties')) {
                    $edit = '<a href="' . url('admin/listing/' . $properties->id) . '/basics" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_property')) {
                    $delete = '<a href="' . url('admin/delete-property/' . $properties->id) . '" class="btn btn-xs     btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>';
                }
                return $edit . $delete;
            })
  
            ->addColumn('created_at', function ($properties) {
                return dateFormat($properties->created_at);
            })
            ->addColumn('username', function ($properties) {
                return $properties->owners->username ?? "";
            })
            ->addColumn('recomended', function ($properties) {

                if ($properties->recomended == 1) {
                    return 'Yes';
                }
                return 'No';

            })
            ->rawColumns(['username', 'action'])
            ->make(true);
    }

    public function query()
    {
        $user_id    = Request::segment(4);
        $status     = isset(request()->status) ? request()->status : null;
        $from = isset(request()->from) ? setDateForDb(request()->from) : null;
        $to = isset(request()->to) ? setDateForDb(request()->to) : null;
        $space_type = isset(request()->to) ? setDateForDb(request()->to) : null;

        $query = Properties::with('owners');
        
        if (isset($user_id)) {
            $query->where('host_id', '=', $user_id);
        }


        if ($from) {
             $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
             $query->whereDate('created_at', '<=', $to);
        }
        if ($status) {
            $query->where('status', '=', $status);
        }
        if ($space_type) {
            $query->where('space_type', '=', $space_type);
        }
// dd($query->toSql());
        return $this->applyScopes($query);
    }

    public function html()
    {
        // dd($this->builder());
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
            ->addColumn(['data' => 'name', 'name' => 'ame', 'title' => 'Name'])
            ->addColumn(['data' => 'username', 'name' => 'username', 'title' => 'User Name'])
            ->addColumn(['data' => 'space_type_name', 'name' => 'space_type_name', 'title' => 'Space Type'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status'])
            ->addColumn(['data' => 'recomended', 'name' => 'recomended', 'title' => 'Recomended'])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Date'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }


    protected function filename()
    {
        return 'propertydatatables_' . time();
    }
}
