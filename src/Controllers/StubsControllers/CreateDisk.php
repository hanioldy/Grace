<?php

namespace Hani221b\Grace\Controllers\StubsControllers;

use App\Http\Controllers\Controller;
use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
use Illuminate\Http\Request;

class CreateDisk extends Controller
{
    /**
     * Class properties
     * @return string
     */
    protected $table_name;

    /**
     * Create a new command instance.
     * @param Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->table_name = $request->table_name;
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
            'table_name' => $this->table_name,
        ];
    }

    /**
     * Execute the file creation.
     */
    public function makeDiskAlive()
    {
        $path = MakeStubsAliveHelper::getSourceFilePath($this->namespace, $this->class_name, '');

        MakeStubsAliveHelper::makeDirectory($this->files, dirname($path));

        $contents = MakeStubsAliveHelper::getSourceFile($this->getStubVariables(), 'model');

        return MakeStubsAliveHelper::putFilesContent($this->files, $path, $contents);
    }
}
