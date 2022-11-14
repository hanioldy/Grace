<?php

namespace Hani221b\Grace\Controllers\StubsControllers;

use App\Http\Controllers\Controller;
use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;
    protected $class_name;
    protected $namespace;
    protected $table_name;
    protected $model_path;
    protected $resource_path;
    protected $field_names;
    protected $field_types;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files, Request $request)
    {
        $this->files = $files;
        $this->class_name = $request->class_name;
        $this->namespace = $request->namespace;
        $this->table_name = $request->table_name;
        $this->model_path = $request->model_namespace;
        $this->resource_path = $request->resource_namespace;
        $this->files_fields = MakeStubsAliveHelper::isFileValues($request);
        $this->field_names = $request->field_names;
        $this->fillable_files_array = MakeStubsAliveHelper::files_fillable_array($this->field_names, $this->files_fields);
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        return [
            'namespace' => $this->namespace,
            'class_name' => MakeStubsAliveHelper::getSingularClassName($this->table_name) . 'Controller',
            'table_name' => $this->table_name,
            'model_path' => $this->model_path . "/" . MakeStubsAliveHelper::getSingularClassName($this->table_name),
            'resource_path' => $this->resource_path . "/" . MakeStubsAliveHelper::getSingularClassName($this->table_name) . 'Resource',
            'fillable_array' => MakeStubsAliveHelper::fillable_array($this->field_names, $this->files_fields),
            'fillable_files_array' => "'" . str_replace(",", "', '", $this->fillable_files_array) . "'",
        ];
    }

    /**
     * Execute the file creation.
     */
    public function makeControllerAlive()
    {
        $controller_path = MakeStubsAliveHelper::getSourceFilePath($this->namespace, $this->table_name, 'Controller');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($controller_path));

        $controller_contents = MakeStubsAliveHelper::getSourceFile($this->getStubVariables(), 'controller');

        MakeStubsAliveHelper::putFilesContent($this->files, $controller_path, $controller_contents);
    }
}
