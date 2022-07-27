<?php

namespace Hani221b\Grace\Controllers\StubsControllers;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Exception;
use Hani221b\Grace\Helpers\FactoryHelpers\MakeDiskAliveHelper;
use Hani221b\Grace\Helpers\FactoryHelpers\makeModelAliveHelper;
use Hani221b\Grace\Helpers\FactoryHelpers\MakeRoutesAliveHelper;
use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
use Hani221b\Grace\Helpers\ViewsHelpers\MakeCreateViewHelper;
use Hani221b\Grace\Helpers\ViewsHelpers\MakeEditViewHelper;
use Hani221b\Grace\Helpers\ViewsHelpers\MakeIndexViewHelper;
use Hani221b\Grace\Helpers\ViewsHelpers\SidebarViewHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateFullResource extends Controller
{
    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;
    protected $table_name;
    protected $controller_namespace;
    protected $model_namespace;
    protected $request_namespace;
    protected $migration_namespace;
    protected $resource_namespace;
    protected $field_names;
    protected $field_types;
    protected $storage_path;
    protected $single_record_table;
    protected $select_options;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files, Request $request)
    {
        $this->files = $files;
        $this->table_name = $request->table_name;
        $this->controller_namespace = $request->controller_namespace;
        $this->model_namespace = $request->model_namespace;
        $this->request_namespace = $request->request_namespace;
        $this->migration_namespace = $request->migration_namespace;
        $this->resource_namespace = $request->resource_namespace;
        $this->files_fields = MakeStubsAliveHelper::isFileValues($request);
        $this->field_names = $request->field_names;
        $this->fillable_files_array = MakeStubsAliveHelper::files_fillable_array($this->field_names, $this->files_fields);
        //filtering null values
        if ($request->field_types !== null) {
            $this->field_types = array_filter($request->field_types, fn($value) => !is_null($value) && $value !== '');
        }
        //filtering null values
        if ($request->input_types !== null) {
            $this->input_types = array_filter($request->input_types, fn($value) => !is_null($value) && $value !== '');
        }
        $this->storage_path = $request->storage_path;
        $this->single_record_table = $request->single_record_table;
        $this->select_options = $request->select_options;
    }

    /**
     * Execute the file creation.
     */

    public function excuteFileCreation()
    {
        // migration
        $this->makeMigration();
        //model
        $this->makeModel();
        // controller
        $this->makeController();
        //request
        $this->makeRequest();
        //resource
        $this->makeResource();
        //routes
        $this->makeRoutes();
        //disk
        $this->makeDisk();
        //views
        if (config('grace.mode') === 'blade') {
            $this->makeViews();
        }
    }

    /**
     * Execute the file creation.
     */

    public function makeFullResourceAlive()
    {

        $new_table_to_be_registered = Table::where('table_name', $this->table_name)->first();
        if ($new_table_to_be_registered !== null) {
            return 'Table already exist';
        } else {
            try {
                $this->excuteFileCreation();

                Table::create([
                    'table_name' => $this->table_name,
                    'controller' => $this->controller_namespace . '\\' . MakeStubsAliveHelper::getSingularClassName($this->table_name) . 'Controller',
                    'model' => $this->model_namespace . '\\' . MakeStubsAliveHelper::getSingularClassName($this->table_name),
                    'request' => $this->request_namespace . '\\' . MakeStubsAliveHelper::getSingularClassName($this->table_name) . 'Request',
                    'resource' => $this->resource_namespace . '\\' . MakeStubsAliveHelper::getSingularClassName($this->table_name) . "Resource",
                    'migration' => $this->migration_namespace . '\\' . date("Y_m_d") . "_" . $_SERVER['REQUEST_TIME']
                    . "_create_" . MakeStubsAliveHelper::getPluralLowerName($this->table_name) . "_table",
                    'views' => config('grace.views_folder_name') . '\\' . $this->table_name,
                ]);
                return 'Resource has been created successfully';
            } catch (Exception $exception) {
                return 'Something went worng please try again later!';
            }
        }

    }

    /**
     * Mapping the value of migrtaion stubs variables
     * @return array
     */
    public function getMigrationVariables()
    {
        return [
            'table_name' => $this->table_name,
            'namespace' => $this->migration_namespace,
            'field_types' => $this->field_types,
            'field_names' => $this->field_names,
        ];
    }

    /**
     * Mapping the value of model stubs variables
     * @return array
     */
    public function getModelVariables()
    {
        return [
            'namespace' => $this->model_namespace,
            'class_name' => MakeStubsAliveHelper::getSingularClassName($this->table_name),
            'table_name' => $this->table_name,
            'fillable_array' => makeModelAliveHelper::model_fillable_array($this->field_names),
            // 'file_name' => ucwords(str_replace(",", "', '", $this->fillable_files_array)),
            'storage_path' => $this->storage_path,
            'files_fields' => MakeStubsAliveHelper::files_fillable_array($this->field_names, $this->files_fields),
        ];
    }

    /**
     * Mapping the value of controller stubs variables
     * @return array
     */
    public function getControllerVariables()
    {
        return [
            'namespace' => $this->controller_namespace,
            'model_path' => $this->model_namespace . "\\" . MakeStubsAliveHelper::getSingularClassName($this->table_name),
            'resource_path' => $this->resource_namespace . "\\" . MakeStubsAliveHelper::getSingularClassName($this->table_name) . "Resource",
            'class_name' => MakeStubsAliveHelper::getSingularClassName($this->table_name) . 'Controller',
            'table_name' => $this->table_name,
            'fillable_array' => MakeStubsAliveHelper::fillable_array($this->field_names, $this->files_fields),
            'fillable_files_array' => "'" . str_replace(",", "', '", $this->fillable_files_array) . "'",
        ];
    }

    /**
     * Mapping the value of request stubs variables
     * @return array
     */
    public function getRequestVariables()
    {
        return [
            'namespace' => $this->request_namespace,
            'class_name' => MakeStubsAliveHelper::getSingularClassName($this->table_name) . 'Request',

        ];
    }

    /**
     * Mapping the value of resource stubs variables
     * @return array
     */
    public function getResourceVariables()
    {
        return [
            'namespace' => $this->resource_namespace,
            'class_name' => MakeStubsAliveHelper::getSingularClassName($this->table_name) . "Resource",

        ];
    }

    /**
     * Mapping the value of routes stubs variables
     * @return array
     */
    public function getRoutesVariables()
    {
        return [
            'table_name' => $this->table_name,
            'controller_name' => MakeStubsAliveHelper::getSingularClassName($this->table_name) . "Controller",
            'controller_namespace' => $this->controller_namespace,
        ];
    }

    /**
     * Mapping the value of disk stubs variables
     * @return array
     */
    public function getDiskVariables()
    {
        return [
            'table_name' => $this->table_name,
            'storage_path' => $this->storage_path,
        ];
    }

    /**
     * Mapping the value of create view stubs variables
     * @return array
     */
    public function getCreateViewVariables()
    {
        return [
            'field_names' => $this->field_names,
            'input_types' => $this->input_types,
            'table_name' => $this->table_name,
            'url' => "{{ route('grace.$this->table_name.store') }}",
            'select_options'=>$this->select_options,
        ];
    }

    /**
     * Mapping the value of edit view stubs variables
     * @return array
     */
    public function getEditViewVariables()
    {
        return [
            'field_names' => $this->field_names,
            'input_types' => $this->input_types,
            'table_name' => $this->table_name,
            'key' => Str::singular($this->table_name),
            'url' => "{{ route('grace.$this->table_name.update', " . "$" . ". Str::singular($this->table_name)->id) }}",
        ];
    }

    /**
     * Mapping the value of create index stubs variables
     * @return array
     */
    public function getIndexViewVariables()
    {
        return [
            'field_names' => $this->field_names,
            'input_types' => $this->input_types,
            'table_name' => $this->table_name,
            'title' => Str::ucfirst($this->table_name),
            'key' => Str::singular($this->table_name),
        ];
    }

    /**
     * Mapping the value of create side stubs variables
     * @return array
     */
    public function getSidebarViewVariables()
    {
        return [
            'table_name' => $this->table_name,
            'single_record_table' => $this->single_record_table,
        ];
    }

    /**
     * Create Migration
     * @return viod
     */

    public function makeMigration()
    {
        $path = MakeStubsAliveHelper::getMigrationSourceFilePath($this->migration_namespace, $this->table_name, '');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($path));

        $contents = MakeStubsAliveHelper::getMigrationSourceFile($this->getMigrationVariables(), 'migration');

        MakeStubsAliveHelper::putFilesContent($this->files, $path, $contents);

        if (config('grace.auto_migrate') === true) {
            $base_path = base_path();

            $file_name = str_replace($base_path, '', $path);

            Artisan::call('migrate', ['--path' => $file_name]);
        }
    }

    /**
     * Create Model
     * @return viod
     */

    public function makeModel()
    {
        $model_path = MakeStubsAliveHelper::getSourceFilePath($this->model_namespace, $this->table_name, '');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($model_path));

        $model_contents = MakeStubsAliveHelper::getModelSourceFile($this->getModelVariables(), 'model');

        MakeStubsAliveHelper::putFilesContent($this->files, $model_path, $model_contents);
    }

    /**
     * Create Controller
     * @return viod
     */

    public function makeController()
    {
        $controller_path = MakeStubsAliveHelper::getSourceFilePath($this->controller_namespace, $this->table_name, 'Controller');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($controller_path));

        if ($this->single_record_table === null) {
            $type = 'controller';
        } else if ($this->single_record_table === "1") {
            $type = 'controller.single.record';
        }
        $controller_contents = MakeStubsAliveHelper::getSourceFile($this->getControllerVariables(), $type);

        MakeStubsAliveHelper::putFilesContent($this->files, $controller_path, $controller_contents);
    }

    /**
     * Create Request
     * @return viod
     */

    public function makeRequest()
    {
        $request_path = MakeStubsAliveHelper::getSourceFilePath($this->request_namespace, $this->table_name, 'Request');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($request_path));

        $request_contents = MakeStubsAliveHelper::getSourceFile($this->getRequestVariables(), 'request');

        MakeStubsAliveHelper::putFilesContent($this->files, $request_path, $request_contents);
    }

    /**
     * Create Resource
     * @return viod
     */

    public function makeResource()
    {
        $resource_path = MakeStubsAliveHelper::getSourceFilePath($this->resource_namespace, $this->table_name, 'Resource');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($resource_path));

        $resource_contents = MakeStubsAliveHelper::getSourceFile($this->getResourceVariables(), 'resource');

        MakeStubsAliveHelper::putFilesContent($this->files, $resource_path, $resource_contents);
    }

    /**
     * Create Routes
     * @return viod
     */

    public function makeRoutes()
    {
        MakeRoutesAliveHelper::appendRoutes($this->getRoutesVariables());
    }

    /**
     * Create Disk
     * @return viod
     */

    public function makeDisk()
    {
        return MakeDiskAliveHelper::appendDisk($this->getDiskVariables());
    }

    /**
     * Create Disk
     * @return viod
     */

    public function makeViews()
    {
        MakeCreateViewHelper::makeCreate($this->table_name, $this->getCreateViewVariables());
        MakeEditViewHelper::makeEdit($this->table_name, $this->getEditViewVariables());
        MakeIndexViewHelper::makeCreate($this->table_name, $this->getIndexViewVariables());
        SidebarViewHelper::appendSidebarRow($this->getSidebarViewVariables());
    }
}
