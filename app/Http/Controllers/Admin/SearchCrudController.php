<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SearchRequest;
use App\Jobs\ProcessSearchGoogle;
use App\Models\Result;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use Dachoagit\Search\Facade\SearchGoogle;

/**
 * Class SearchCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SearchCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Search::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/search');
        CRUD::setEntityNameStrings('search', 'searches');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        $this->crud->addColumn([
            'name'      => 'row_number',
            'type'      => 'row_number',
            'label'     => '#',
            'orderable' => false,
        ])->makeFirstColumn();
        CRUD::column('content');
        $this->crud->addColumn([
            'name' => 'status',
            'label' => "Status",
            'type' => 'closure',
            'attributes' => [
                'style' => 'width: 300px',
            ],
            'function' => function ($row) {
                $status = $row->status;
                $class = '';
                switch ($status) {
                    case 0:
                        $class = 'text-warning';
                        $status = 'Chưa xử lý';
                        break;
                    case 1:
                        $class = 'text-success';
                        $status = 'Đã xử lý';
                        break;
                    case -1:
                        $class = 'text-danger';
                        $status = 'Xử lý thất ';
                        break;
                    default:
                        break;
                }
                return '<span class="' . $class . '">' . $status . '</span>';
            }
        ]);

        $this->crud->query->withCount('results');
        $this->crud->addColumn([
            'name'      => 'results_count', // name of relationship method in the model
            'type'      => 'number',
            'label'     => 'Results', // Table column heading
            'suffix'    => ' results', // to show "123 tags" instead of "123"
        ]);

//        $this->crud->addColumn([
//            'name' => 'count_links',
//            'label' => 'Number of Links',
//            'type' => 'closure',
//            'function' => function ($row) {
//                return Result::where('search_id', $row->id)->count();
//            }
//        ]);
        CRUD::column('updated_at');
        CRUD::column('error');

        $this->crud->addFilter([
            'type' => 'date_range',
            'name' => 'from_to',
            'label' => 'Date range'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                 $dates = json_decode($value);
                 $this->crud->addClause('where', 'updated_at', '>=', $dates->from);
                 $this->crud->addClause('where', 'updated_at', '<=', $dates->to . ' 23:59:59');
            });



        $this->crud->addButtonFromView('line', 'open_google', 'search', 'beginning');
        $this->crud->addFilter([
            'name' => 'status',
            'type' => 'select2',
            'label' => 'Status'
        ], function () {
            return [
                0 => 'Chưa tìm kiếm',
                1 => 'Đã tìm kiếm',
                -1 => 'Có lỗi xảy ra',
            ];
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'status', $value);
        });
    }

    public function searchGoogle()
    {
        $search = $this->crud->getCurrentEntry();
        ProcessSearchGoogle::dispatchSync($search);
        return redirect('/admin/search/' . $search->id . '/show');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SearchRequest::class);

        CRUD::field('content');

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
    public function show($id)
    {
        // custom logic before
        $links = Result::where('search_id', $id)->get();
        $html = '';
        foreach ($links as $each) {
            $html = $html . "<span class='text-danger'>" . $each->link . "</span><br>";
        }
        $this->crud->addColumn(
            [
                'name' => 'Links',
                'label' => 'Links',
                'type' => 'custom_html',
                'value' => $html,

                // OPTIONALS
                // 'escaped' => true // echo using {{ }} instead of {!! !!}
            ],
        );
        CRUD::column('error');

        $this->crud->addColumn(
            [
                'name' => 'Links',
                'label' => 'Links',
                'type' => 'table',
            ],
        );

        $content = $this->traitShow($id);
        // cutom logic after

        return $content;
    }
}
