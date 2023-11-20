<?php

namespace App\DataTables;

use App\Models\Video;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class VideoDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            
            
            // ->editColumn('userProfile.country', function($query) {
            //     return $query->userProfile->country ?? '-';
            // })
            // ->editColumn('userProfile.company_name', function($query) {
            //     return $query->userProfile->company_name ?? '-';
            // })
            ->editColumn('status', function($query) {
                $status = 'warning';
                switch ($query->status) {
                    case 'public':
                        $status = 'primary';
                        break;
                    case 'private':
                        $status = 'danger';
                        break;
                }
                return '<span class="text-capitalize badge bg-'.$status.'">'.$query->status.'</span>';
            })
            ->editColumn('created_at', function($query) {
                return date('Y/m/d',strtotime($query->created_at));
            })
            // ->filterColumn('category.name', function($query, $keyword) {
            //     return $query->orWhereHas('category', function($q) use($keyword) {
            //         $q->where('name', 'like', "%{$keyword}%");
            //     });
            // })
            
            ->addColumn('action', 'video.action')
            ->rawColumns(['action','status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = Video::query()->with('category');
        // dd($model);
        return $this->applyScopes($model);
    }
   


    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('dataTable')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('<"row align-items-center"<"col-md-2" l><"col-md-6" B><"col-md-4"f>><"table-responsive my-3" rt><"row align-items-center" <"col-md-6" i><"col-md-6" p>><"clear">')

                    ->parameters([
                        "processing" => true,
                        "autoWidth" => false,
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'id', 'name' => 'id', 'title' => 'id'],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title', 'orderable' => false],
            ['data' => 'thumbnail', 'name' => 'thumbnail', 'title' => 'thumbnail'],
            // ['data' => 'category', 'name' => 'category', 'title' => 'category'],
            ['data' => 'category.name', 'name' => 'category', 'title' => 'Category'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            // ['data' => 'description', 'name' => 'description', 'title' => 'description'],
            // ['data' => 'media', 'name' => 'media', 'title' => 'media'],
            // ['data' => 'cp_id', 'name' => 'cp_id', 'title' => 'cp_id'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->searchable(false)
                  ->width(60)
                  ->addClass('text-center hide-search'),
        ];
    }
    

}
