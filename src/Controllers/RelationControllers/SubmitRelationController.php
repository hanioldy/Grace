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
        $template = array();
        $relation_template = '';
        $relation_type_foriegn_table = array_combine($this->relation_type, $this->foreign_table);
        $local_key_foriegn_key = array_combine($this->local_key, $this->foriegn_key );
        foreach($relation_type_foriegn_table as $relation_type => $foriegn_table){
            foreach($local_key_foriegn_key as $local_key => $foriegn_key){
                echo "$relation_type". "<br>";
            switch ($relation_type) {
                case 'HasOne':
                    $relation_template = self::has_one($foriegn_table, $foriegn_key, $local_key);
                    break;

                case 'BelongsTo':
                    $relation_template = self::belongs_to($foriegn_table, $foriegn_key, $local_key);
                    break;

                case 'hasMany':
                    $relation_template = self::has_many($foriegn_table, $foriegn_key, $local_key);
                    break;
            }
            array_push($template, $relation_template);
            }
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
        public function $this->foreign_table()
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
}
