<?php

namespace App\DataTables;

use App\Models\Seller;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SellerDataTable extends DataTable
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
            ->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Seller $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Seller $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('seller-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
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
            Column::make('id'),
            Column::make('user_id'),
            Column::make('seller_package_id'),
            Column::make('remaining_uploads'),
            Column::make('remaining_digital_uploads'),
            Column::make('invalid_at'),
            Column::make('verification_status'),
            Column::make('verification_info'),
            Column::make('cash_on_delivery_status'),
            Column::make('admin_to_pay'),
            Column::make('bank_name'),
            Column::make('bank_acc_name'),
            Column::make('bank_acc_no'),
            Column::make('bank_routing_no'),
            Column::make('bank_payment_status'),
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
        return 'Seller_' . date('YmdHis');
    }
}
