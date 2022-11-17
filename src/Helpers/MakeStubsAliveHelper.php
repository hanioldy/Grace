<?php

namespace Hani221b\Grace\Helpers;

use Hani221b\Grace\Helpers\FactoryHelpers\makeModelAliveHelper;
use Illuminate\Support\Pluralizer;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;

class MakeStubsAliveHelper
{
    /**
     * Return the Singular Capitalize Name
     * @param $class_name
     * @return string
     */
    public static function getSingularClassName($class_name)
    {
        return ucwords(Pluralizer::singular($class_name));
    }

    /**
     * Return the PLural Lower Case Name
     * @param $table_name
     * @return string
     */
    public static function getPluralLowerName($table_name)
    {
        return strtolower(Pluralizer::plural($table_name));
    }

    /**
     * Get the full path of generate class
     *
     * @return string
     */
    public static function getSourceFilePath($namespace, $class_name, $suffix)
    {
        return base_path($namespace) . '/' . self::getSingularClassName($class_name) . $suffix . '.php';
    }

    /**
     * Get the full path of generate migration class
     *
     * @return string
     */
    public static function getMigrationSourceFilePath($namespace, $table_name)
    {
        return base_path($namespace) . '/' . date("Y_m_d") . "_" . $_SERVER['REQUEST_TIME']
        . "_create_" . self::getPluralLowerName($table_name) . "_table" . '.php';
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  object  $files
     * @param  string  $path
     * @return string
     */
    public static function makeDirectory($files, $path)
    {
        if (!$files->isDirectory($path)) {
            $files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Return the stub file path
     * @return string
     *
     */
    public static function getStubPath($type)
    {
        return __DIR__ . "/../Stubs/{$type}.stub";
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public static function getSourceFile($StubVariables, $type)
    {
        return self::getStubContents(MakeStubsAliveHelper::getStubPath($type), $StubVariables);
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public static function getMigrationSourceFile($StubVariables, $type)
    {
        return self::getMigrationStubContents(MakeStubsAliveHelper::getStubPath($type), $StubVariables);
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public static function getModelSourceFile($StubVariables, $type)
    {
        return self::getModelStubContents(MakeStubsAliveHelper::getStubPath($type), $StubVariables);
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public static function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {

            $contents = str_replace('{{ ' . $search . ' }}', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public static function getModelStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        $string_mutators_template = makeModelAliveHelper::appendMutatorToModel($stubVariables);

        if($stubVariables['files_fields']  === ""){
            $contents = str_replace('{{ mutatators }}', "", $contents);
        } else {
            $contents = str_replace('{{ mutatators }}', $string_mutators_template, $contents);
        }

        foreach ($stubVariables as $search => $replace) {

            $contents = str_replace('{{ ' . $search . ' }}', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public static function getMigrationStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        $field_names = $stubVariables['field_names'];
        $field_types = $stubVariables['field_types'];

        $tabels_types_and_names = array_combine($field_names, $field_types);

        unset($stubVariables["field_names"]);
        unset($stubVariables["field_types"]);

        $template = array();

        foreach ($tabels_types_and_names as $key => $value) {
            array_push($template, "table->$value('$key')");
        }
        $tables_template = '';
        foreach ($template as $index => $tem) {
            $tables_template .= "$" . $template[$index] . ";" . "\n";
        }

        $contents = str_replace('{{ content }}', $tables_template, $contents);

        foreach ($stubVariables as $search => $replace) {

            $contents = str_replace('{{ ' . $search . ' }}', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Combine fields names and files fileds value to return files fillable array
     * @return array
     */
    public static function files_fillable_array($field_names, $files_fields)
    {
        $files_fillable_array = [];
        if ($field_names !== null && $files_fields !== null) {
            $files_array = array_combine($field_names, $files_fields);
            foreach ($files_array as $field_name => $file_filed) {
                if ($file_filed === '1') {
                    array_push($files_fillable_array, $field_name);
                }
            }
        }
        return implode(",", $files_fillable_array);
    }

    /**
     * Mapping the value of field names and filter files fields
     * @return string
     */

    public static function fillable_array($field_names, $files_fields)
    {
        $fillable_array = [];
        $all_fields = array_combine($field_names, $files_fields);
        foreach ($all_fields as $name => $value) {
            if ($value === "0") {
                array_push($fillable_array, $name);
            }
        }
        return "'" . str_replace(",", "', '", implode(",", $fillable_array)) . "'";
    }

    /**
     * Map the values of isFile checkbox
     * @param Illuminate\Http\Request
     * @return array
     */
    public static function isFileValues($request)
    {
        $files_fields = $request->isFile;
        if ($files_fields !== null) {
            foreach ($files_fields as $key => $value) {
                if ($value === '1') {
                    unset($files_fields[$key + 1]);
                }
            }
        }
        return $files_fields;
    }

    /**
     * Gets a string between two characters. Used to delete or modefiy the code
     * @param String string
     * @param String start
     * @param String end
     * @return String
     */

    public static function getStringBetween($string, $start, $end)
    {
        $string = " " . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) {
            return "";
        }

        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * Delete a directory with its content
     * @param String dirPath
     * @return void
     */

    public static function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    /**
     * Searching a class for a method an returns its code as string
     * @param $class
     * @param $method
     * @return String
     */

    public static function getMethodSourceCode($class, $method)
    {
        $func = new ReflectionMethod($class, $method);
        $filename = $func->getFileName();
        $start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
        $end_line = $func->getEndLine();
        $length = $end_line - $start_line;
        $source = file($filename);
        $body = implode("", array_slice($source, $start_line, $length));
        $source_code = self::getStringBetween($body, "{\n", "}\n");
        return $source_code;
    }

    /**
     * Searching a class for a method an returns its code as string
     * @param $class
     * @param $method
     * @return String
     */

    public static function getClassSourceCode($class)
    {
        $func = new ReflectionClass($class);
        $filename = $func->getFileName();
        $start_line = $func->getStartLine() - 1; // it's actually - 1, otherwise you wont get the function() block
        $end_line = $func->getEndLine();
        $length = $end_line - $start_line;
        $source = file($filename);
        $body = implode("", array_slice($source, $start_line, $length));
        $source_code = self::getStringBetween($body, "{", "// The end of the class [DO NOT REMOVE THIS COMMENT]");
        return $source_code;
    }

    /**
     * Undocumented function
     *
     * @param String $namespace
     * @return string
     */
    public static function correctionForNamespace($namespace)
    {
        $namespace = str_replace("app", "App", $namespace);
        $namespace = str_replace("/","\\", $namespace);
        return $namespace;
    }


    /**
     * Put the requested data inside the files have just created
     *
     * @param $files
     * @param string $path
     * @param string $contents
     * @return bool|mixed|string
     */
    public static function putFilesContent($files, $path, $contents)
    {
        if (!$files->exists($path)) {
            $files->put($path, $contents);
            // $this->info("File : {$path} created");
            return "File : {$path} created";
        } else {
            // $this->info("File : {$path} already exits");
            return "File : {$path} already exits";
        }
    }
}
