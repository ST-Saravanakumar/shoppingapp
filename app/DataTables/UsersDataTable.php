<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Carbon\Carbon;
use DataTables;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $datatables = Datatables::of($query)
            ->editColumn('first_name', function ($row) {
                return $row->first_name ? ucfirst($row->first_name) : "";
            })
            ->editColumn('last_name', function ($row) {
                return $row->last_name ? ucfirst($row->last_name) : "";
            })
            ->editColumn('role', function ($row) {
                return $row->role ? ucfirst($row->role) : "User";
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at);
                // return date('Y-m-d H:i:s', $row->created_at);
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $row->updated_at);
                // return date('Y-m-d H:i:s', $row->updated_at);
            })
            ->addColumn('action', function() {
                $buttons = '<a href="" class="btn btn-xs btn-primary">Edit</a>';
                $buttons .= '&nbsp;';
                $buttons .= '<a href="" class="btn btn-xs btn-danger">Delete</a>';
                return $buttons;
            });

        return $datatables->rawColumns(['action'])->make(true);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        // return $model::all();

        return $model->newQuery()->where('role', '!=', 'admin');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('email'),
            Column::make('role'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
