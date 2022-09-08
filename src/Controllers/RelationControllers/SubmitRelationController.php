<?php

namespace Hani221b\Grace\Controllers\RelationControllers;

use Hani221b\Grace\Helpers\MakeStubsAliveHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubmitRelationController
{

    public $relation_type;
    public $local_table;
    public $foreign_table;
    public $single_foreign_table_name;
    public $foreign_model;
    public $local_key;
    public $foriegn_key;

    public function __construct(Request $request)
    {
        // dd($request);
        $this->relation_type = $request->relation_type;
        $this->local_table = $request->local_table;
        $this->foreign_table = $request->foreign_table;
        $this->local_key = $request->local_key;
        $this->foriegn_key = $request->foriegn_key;
    }
    /**
     * Adding desired relation for the named model
     * @return void
     */
    public function submit_relations()
    {
        $relations_array = array();
        $template = array();
        $relation_template = '';
        foreach($this->relation_type as $type){
            array_push($relations_array, "rt__".$type."__rt");
        }
        foreach($this->foreign_table as $index => $foreign_table){
            $relations_array[$index] = $relations_array[$index]. "__ft__". $foreign_table."__ft";
        }
        foreach($this->foriegn_key as $index => $foriegn_key){
            $relations_array[$index] = $relations_array[$index]. "__fk__". $foriegn_key."__fk";
        }
        foreach($this->local_key as $index => $local_key){
            $relations_array[$index] = $relations_array[$index]. "__lk__". $local_key."__lk";
        }
        // dd($relations_array);
        foreach($relations_array as $arr){
            $single_relation = [
                'realtion_type'=>MakeStubsAliveHelper::getStringBetween($arr, "rt__", "__rt"),
                'foreign_table'=>MakeStubsAliveHelper::getStringBetween($arr, "ft__", "__ft"),
                'foreign_key'=>MakeStubsAliveHelper::getStringBetween($arr, "fk__", "__fk"),
                'local_key'=>MakeStubsAliveHelper::getStringBetween($arr, "lk__", "__lk"),
            ];
            echo $single_relation['realtion_type'] . "<br>";
            switch ($single_relation['realtion_type']) {
                case 'HasOne':
                    $relation_template = self::has_one($single_relation['foreign_table'], $single_relation['foreign_key'], $single_relation['local_key']);
                    break;

                case 'BelongsTo':
                    $relation_template = self::belongs_to($single_relation['foreign_table'], $single_relation['foreign_key'], $single_relation['local_key']);
                    break;

                case 'HasMany':
                    $relation_template = self::has_many($single_relation['foreign_table'], $single_relation['foreign_key'], $single_relation['local_key']);
                    break;

                case 'BelongsToMany':
                    $relation_template = self::belongs_to_many($single_relation['foreign_table'], $single_relation['foreign_key'], $single_relation['local_key']);
                    break;
            }
            array_push($template, $relation_template);
        }

        $string_relation_template = '';
        foreach ($template as $index => $tem) {
            $string_relation_template .= $template[$index] . "\n";
        }
          dd($string_relation_template);
    }

    /**
     * Defining the template of hasOne relation
     * @param $foriegn_table
     * @return String
     */
    public function has_one($foreign_table, $foriegn_key, $local_key)
    {
        $foriegn_model = MakeStubsAliveHelper::getSingularClassName($foreign_table);
        $single_foreign_table_name = Str::singular($foreign_table);
        return "
        //============= $this->local_table - $single_foreign_table_name relation =============
        public function $this->single_foreign_table_name()
        {
            return \$this->hasOne($foriegn_model::class, '$foriegn_key', '$local_key');
        }
        //========================================================
        ";
    }

    /**
     * Defining the template of hasMany relation
     * @param $foriegn_table
     * @return String
     */
    public function has_many($foreign_table, $foriegn_key, $local_key)
    {
        $foriegn_model = MakeStubsAliveHelper::getSingularClassName($foreign_table);
        // $single_foreign_table_name = Str::singular($foreign_table);
        return "
        //============= $this->local_table - $foreign_table relation =============
        public function $foreign_table()
        {
            return \$this->hasMany($foriegn_model::class, '$foriegn_key', '$local_key');
        }
        //========================================================
        ";
    }

    /**
     * Defining the template of belongsTo relation
     * @param $foriegn_table
     * @return String
     */
    public function belongs_to($foreign_table, $foriegn_key, $local_key)
    {
        $foriegn_model = MakeStubsAliveHelper::getSingularClassName($foreign_table);
        $single_foreign_table_name = Str::singular($foreign_table);
        return "
        //============= $this->local_table - $single_foreign_table_name relation =============
        public function $this->single_foreign_table_name()
        {
            return \$this->belongsTo($foriegn_model::class, '$foriegn_key', '$local_key');
        }
        //========================================================
        ";
    }

    /**
     * Defining the template of belongsToMany relation
     * @param $foriegn_table
     * @return String
     */
    public function belongs_to_many($foreign_table, $foriegn_key, $local_key)
    {
        $foriegn_model = MakeStubsAliveHelper::getSingularClassName($foreign_table);
        $single_foreign_table_name = Str::singular($foreign_table);
        return "
        //============= $this->local_table - $single_foreign_table_name relation =============
        public function $this->single_foreign_table_name()
        {
            return \$this->belongsToMany($foriegn_model::class, 'pivot_table', '$local_key', '$foriegn_key');
        }
        //========================================================
        ";
    }
}
