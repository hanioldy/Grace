<?php

namespace Hani221b\Grace\Controllers\StubsControllers;

use Illuminate\Filesystem\Filesystem;
use App\Http\Controllers\Controller;
use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
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
    protected $fillable_array;
    protected $fillable_files_array;

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
        $this->model_path = $request->model_path;
        $this->resource_path = $request->resource_path;
        $this->fillable_array = $request->fillable_array;
        $this->fillable_files_array = $request->fillable_files_array;
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
            'class_name' => MakeStubsAliveHelper::getSingularClassName($this->class_name) . 'Controller',
            'table_name' => $this->table_name,
            'model_path' => $this->model_path,
            'resource_path' => $this->resource_path,
            'fillable_array' => $this->fillable_array,
            'fillable_files_array' => $this->fillable_files_array,
        ];
    }

    /**
     * Execute the file creation.
     */
    public function makeControllerAlive()
    {
        $path = MakeStubsAliveHelper::getSourceFilePath($this->namespace, $this->class_name, 'Controller');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($path));

        $contents = MakeStubsAliveHelper::getSourceFile($this->getStubVariables(), 'controller');

        return  MakeStubsAliveHelper::putFilesContent($this->files, $path, $contents);
    }
}
