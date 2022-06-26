<?php

namespace Hani221b\Grace\Controllers\StubsControllers;

use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
use Illuminate\Filesystem\Filesystem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateResource extends Controller
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
            'namespace' => $this->namespace,
            'class_name' => MakeStubsAliveHelper::getSingularClassName($this->class_name),
        ];
    }

    /**
     * Execute the console command.
     */
    public function makeResourceAlive()
    {
        $path = MakeStubsAliveHelper::getSourceFilePath($this->namespace, $this->class_name, 'Resource');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($path));

        $contents = MakeStubsAliveHelper::getSourceFile($this->getStubVariables(), 'resource');

        return  MakeStubsAliveHelper::putFilesContent($this->files, $path, $contents);
    }
}
