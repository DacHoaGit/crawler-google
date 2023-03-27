<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProxyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

/**
 * Class ProxyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProxyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation {
        show as traitShow;
    }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Proxy::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/proxy');
        CRUD::setEntityNameStrings('proxy', 'proxies');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('proxy');
        CRUD::column('status');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'select2',
            'label' => 'Status'
        ], function () {
            return [
                0 => 'Chưa sử dụng',
                1 => 'Đang sử dụng',
                -1 => 'Có lỗi xảy ra',
            ];
        }, function ($value) { // if the filter is active
            if ($value == -1) {
                $this->crud->addClause('whereIn', 'status', [-1, -2]);
            } else {
                $this->crud->addClause('where', 'status', $value);
            }
        });
        $this->crud->addColumn([
            'name'      => 'row_number',
            'type'      => 'row_number',
            'label'     => '#',
            'orderable' => false,
        ])->makeFirstColumn();

        
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProxyRequest::class);

        CRUD::field('proxy');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function show($id){

        Widget::add([ 
            'type'       => 'chart',
            'controller' => \App\Http\Controllers\Admin\Charts\LogProxiesChartController::class,
            'data' => [
                'id' => $id 
            ],
            // OPTIONALS
        
            // 'class'   => 'card mb-2',
            'wrapper' => ['class'=> 'w-100'] ,
            // 'content' => [
                 // 'header' => 'New Users', 
                 // 'body'   => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>',
            // ],
        ]);
        $content = $this->traitShow($id);
        // cutom logic after

        return $content;
    }
}
