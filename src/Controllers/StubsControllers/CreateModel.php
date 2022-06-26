<?php

namespace Hani221b\Grace\Controllers\StubsControllers;

use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;
use App\Http\Controllers\Controller;
use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
use Illuminate\Http\Request;

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
    protected $fillable_array = [];
    protected $file_name;
    protected $storage_path;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files, Request $request)
    {
        $this->files = $files;
        $this->namespace = $request->namespace;
        $this->class_name = $request->class_name;
        $this->table_name = $request->table_name;
        $this->fillable_array = strip_tags($request->fillable_array);
        $this->file_name = $request->file_name;
        $this->storage_path = $request->storage_path;
    }

    /**
     * Return the Singular Capitalize Name
     * @param $name
     * @return string
     */
    public function getSingularClassName()
    {
        return ucwords(Pluralizer::singular($this->class_name));
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
            'class_name' => MakeStubsAliveHelper::getSingularClassName($this->class_name),
            'table_name' => $this->table_name,
            'fillable_array' => "'" . str_replace(",", "', '", $this->fillable_array) . "'",
            'file_name' => ucwords($this->file_name),
            'storage_path' => $this->storage_path,
        ];
    }

    /**
     * Execute the file creation.
     */
    public function makeModelAlive()
    {
        $path = MakeStubsAliveHelper::getSourceFilePath($this->namespace, $this->class_name, '');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($path));

        $contents = MakeStubsAliveHelper::getSourceFile($this->getStubVariables(), 'model');

        return  MakeStubsAliveHelper::putFilesContent($this->files, $path, $contents);
    }
}
