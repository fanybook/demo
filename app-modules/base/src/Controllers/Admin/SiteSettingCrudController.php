<?php

namespace Modules\Base\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

class SiteSettingCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        $this->crud->setModel("Modules\Base\Models\SiteSetting");
        $this->crud->setEntityNameStrings(trans('backpack::settings.setting_singular'), trans('backpack::settings.setting_plural'));
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/site-setting');
//        $this->crud->denyAccess(['create', 'delete']);
        $this->crud->setColumns([
            [
                'name'  => 'key',
                'label' => trans('backpack::settings.key'),
            ],
//            [
//                'name'  => 'name',
//                'label' => trans('backpack::settings.name'),
//            ],
            [
                'name'  => 'value',
                'label' => trans('backpack::settings.value'),
            ],
            [
                'name'  => 'memo',
                'label' => trans('backpack::settings.description'),
            ],
        ]);
    }

    /**
     * Display all rows in the database for this entity.
     * This overwrites the default CrudController behaviour:
     * - instead of showing all entries, only show the "active" ones.
     *
     * @return Response
     */
    public function index()
    {
//        $this->crud->addClause('where', 'active', 1);

        return parent::index();
    }

    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();

        $this->crud->addField([
            'name'       => 'key',
            'label'      => trans('backpack::settings.key'),
            'type'       => 'text',
        ]);
        $this->crud->addField([
            'name'       => 'value',
            'label'      => trans('backpack::settings.value'),
            'type'       => 'textarea',
        ]);
        $this->crud->addField([
            'name'       => 'memo',
            'label'      => trans('backpack::settings.description'),
            'type'       => 'textarea',
        ]);

        return view($this->crud->getCreateView(), $this->data);
    }

    public function store()
    {
        return parent::storeCrud();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        $this->data['entry'] = $this->crud->getEntry($id);
        //$this->crud->addField((array) json_decode($this->data['entry']->field)); // <---- this is where it's different
        $this->crud->addField([
            'name'       => 'key',
            'label'      => trans('backpack::settings.key'),
            'type'       => 'text',
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);
        $this->crud->addField([
            'name'       => 'value',
            'label'      => trans('backpack::settings.value'),
            'type'       => 'textarea',
        ]);
        $this->crud->addField([
            'name'       => 'memo',
            'label'      => trans('backpack::settings.description'),
            'type'       => 'textarea',
        ]);

        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;

        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
    }

    public function update()
    {
        return parent::updateCrud();
    }
}
