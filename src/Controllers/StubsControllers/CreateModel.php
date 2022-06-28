<?php

namespace Hani221b\Grace\Controllers\StubsControllers;

use App\Http\Controllers\Controller;
use Hani221b\Grace\Helpers\FactoryHelpers\makeModelAliveHelper;
use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Pluralizer;

class CreateModel extends Controller
{
    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;
    protected $namespace;
    protected $class_name;
    protected $table_name;
    protected $field_names;
    protected $field_types;
    protected $files_fields;
    protected $storage_path;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files, Request $request)
    {
        $this->files = $files;
        $this->namespace = $request->namespace;
        $this->table_name = $request->table_name;
        $this->class_name = $this->getSingularClassName();
        // $this->fillable_array = strip_tags($request->fillable_array);
        // $this->file_name = $request->file_name;
        $this->field_names = $request->field_names;
        $this->files_fields = $request->files_fields;
        $this->files_fields = MakeStubsAliveHelper::isFileValues($request);
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName()
    {
        return ucwords(Pluralizer::singular($this->table_name));
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
            'class_name' => $this->class_name,
            'table_name' => $this->table_name,
            'fillable_array' => makeModelAliveHelper::model_fillable_array($this->field_names),
            'files_fields' => MakeStubsAliveHelper::files_fillable_array($this->field_names, $this->files_fields),
        ];
    }

    /**
     * Execute the file creation.
     */
    public function makeModelAlive()
    {
        $model_path = MakeStubsAliveHelper::getSourceFilePath($this->namespace, $this->table_name, '');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($model_path));

        $model_contents = MakeStubsAliveHelper::getModelSourceFile($this->getStubVariables(), 'model');

        MakeStubsAliveHelper::putFilesContent($this->files, $model_path, $model_contents);
    }
}
