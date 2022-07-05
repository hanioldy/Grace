<?php

namespace Hani221b\Grace\Controllers\StubsControllers;

use App\Http\Controllers\Controller;
use Hani221b\Grace\Helpers\FactoryHelpers\MakeDiskAliveHelper;
use Hani221b\Grace\Helpers\FactoryHelpers\MakeRoutesAliveHelper;
use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

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
        $this->files_fields = $this->isFileValues($request);
        $this->field_names = $request->field_names;
        $this->fillable_files_array = $this->files_fillable_array($request);
        //filetr null values
        $this->field_types = array_filter($request->field_types, fn($value) => !is_null($value) && $value !== '');
        $this->storage_path = $request->storage_path;
        $this->single_record_table = $request->single_record_table;
    }

    /**
     * Execute the file creation.
     */
    public function makeFullResourceAlive()
    {
        //migration
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
     * Map the values of isFile checkbox
     * @param Illuminate\Http\Request
     * @return array
     */
    public function isFileValues($request)
    {
        $files_fields = $request->isFile;
        foreach ($files_fields as $key => $value) {
            if ($value === '1') {
                unset($files_fields[$key + 1]);
            }
        }
        return $files_fields;
    }
    /**
     * Combine fields names and files fileds value to return files fillable array
     * @return array
     */
    public function files_fillable_array()
    {
        $files_fillable_array = [];
        $files_array = array_combine($this->field_names, $this->files_fields);
        foreach ($files_array as $field_name => $file_filed) {
            if ($file_filed === '1') {
                array_push($files_fillable_array, $field_name);
            }
        }
        return implode(",", $files_fillable_array);
    }

    /**
     * Mapping the value of field names and filter files fields
     * @return string
     */

    public function fillable_array()
    {
        $fillable_array = [];
        $all_fields = array_combine($this->field_names, $this->files_fields);
        foreach ($all_fields as $name => $value) {
            if ($value === "0") {
                array_push($fillable_array, $name);
            }
        }
        return "'" . str_replace(",", "', '", implode(",", $fillable_array)) . "'";
    }

    /**
     * Mapping the value of field names and files fields
     * @return string
     */

    public function model_fillable_array()
    {
        return "'" . str_replace(",", "', '", implode(",", $this->field_names)) . "'";
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
            'fillable_array' => $this->model_fillable_array(),
            // 'file_name' => ucwords(str_replace(",", "', '", $this->fillable_files_array)),
            'storage_path' => $this->storage_path,
            'files_fields' => $this->files_fillable_array(),
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
            'fillable_array' => $this->fillable_array(),
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
     * Create Migration
     * @return viod
     */

    public function makeMigration()
    {
        $path = MakeStubsAliveHelper::getMigrationSourceFilePath($this->migration_namespace, $this->table_name, '');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($path));

        $contents = MakeStubsAliveHelper::getMigrationSourceFile($this->getMigrationVariables(), 'migration');

        MakeStubsAliveHelper::putFilesContent($this->files, $path, $contents);
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
        return MakeStubsAliveHelper::makeViews($this->table_name);
    }
}
