<?php

/**
 * AdminuserDataTable Data Table
 *
 * AdminuserDataTable Data Table handles AdminuserDataTable datas.
 *
 * @category   AdminuserDataTable
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.7
 * @link       http://techvill.net
 * @since      Version 1.3
 * @deprecated None
 */

namespace App\DataTables;


use App\Models\Owner;
use Yajra\DataTables\Services\DataTable;

class AdminownerDataTable extends DataTable
{
    public function ajax()
    {
        $owner = $this->query();

        return datatables()
            ->of($owner)
            ->addColumn('action', function ($owner) {
                $edit = '<a href="' . url('admin/edit-owner/' . $owner->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/delete-owner/' . $owner->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="glyphicon glyphicon-trash"></i></a>';
                return $edit . $delete;
            })
            ->addColumn('username', function ($owner) {
                return '<a href="' . url('admin/edit-owner/' . $owner->id) . '">' . $owner->username . '</a>';
            })
            ->rawColumns(['username','action'])
            ->make(true);
    }

    public function query()
    {
        $admin = Owner::join('role_owner', function ($join) {
                                $join->on('role_owner.owner_id', '=', 'owners.id');
        })
                        ->join('roles', function ($join) {
                                $join->on('roles.id', '=', 'role_owner.role_id');
                        })
                        ->select(['owners.id as id', 'username', 'email', 'roles.display_name as role_name', 'status']);

        return $this->applyScopes($admin);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'username', 'name' => 'owners.username', 'title' => 'Username'])
            ->addColumn(['data' => 'email', 'name' => 'owners.email', 'title' => 'Email'])
            ->addColumn(['data' => 'role_name', 'name' => 'roles.display_name', 'title' => 'Role Name'])
            ->addColumn(['data' => 'status', 'name' => 'owners.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function getColumns()
    {
        return [
            'id',
            'created_at',
            'updated_at',
        ];
    }

    protected function filename()
    {
        return 'admindatatables_' . time();
    }
}
