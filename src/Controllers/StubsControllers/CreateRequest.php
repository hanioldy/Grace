<?php

namespace Hani221b\Grace\Controllers\StubsControllers;

use Illuminate\Filesystem\Filesystem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hani221b\Grace\Helpers\MakeStubsAliveHelper;

class CreateRequest extends Controller
{
    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;
    protected $namespace;
    protected $class_name;
    /**
     * Create a new command instance.
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files, Request $request)
    {
        $this->files = $files;
        $this->namespace = $request->namespace;
        $this->class_name = $request->class_name;
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
            'namespace' => 'App\\Http\\Requests' . $this->namespace,
            'class_name' => MakeStubsAliveHelper::getSingularClassName($this->class_name),
        ];
    }

    /**
     * Execute the file creation.
     */
    public function makeRequestAlive()
    {
        $path = MakeStubsAliveHelper::getSourceFilePath($this->namespace, $this->class_name, 'Request');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($path));

        $contents = MakeStubsAliveHelper::getSourceFile($this->getStubVariables(), 'request');

        return  MakeStubsAliveHelper::putFilesContent($this->files, $path, $contents);
    }
}
