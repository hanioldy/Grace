<?php

namespace Hani221b\Grace\Controllers\RelationControllers;

use App\Models\Table;
use App\Models\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Hani221b\Grace\Support\Str as GraceStr;

class SubmitRelationController
{

    public $relation_type;
    public $local_table;
    public $foreign_table;
    public $single_foreign_table_name;
    public $foreign_model;
    public $local_key;
    public $foriegn_key;
    public $pivot_table;

    public function __construct(Request $request)
    {
        $this->relation_type = $request->relation_type;
        $this->local_table = $request->local_table;
        $this->foreign_table = $request->foreign_table;
        $this->local_key = $request->local_key;
        $this->foriegn_key = $request->foriegn_key;
        $this->pivot_table = $request->pivot_table;
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
        $local_table = Table::where('table_name', $this->local_table)->first();
        foreach ($this->relation_type as $type) {
            array_push($relations_array, "rt__" . $type . "__rt");
        }
        foreach ($this->foreign_table as $index => $foreign_table) {
            $relations_array[$index] = $relations_array[$index] . "__ft__" . $foreign_table . "__ft";
        //store record in db
        Relation::create([
            'local_table'=>$local_table->table_name,
            'foreign_table'=>$foreign_table
            ]);
        }
        foreach ($this->foriegn_key as $index => $foriegn_key) {
            $relations_array[$index] = $relations_array[$index] . "__fk__" . $foriegn_key . "__fk";
        }
        foreach ($this->local_key as $index => $local_key) {
            $relations_array[$index] = $relations_array[$index] . "__lk__" . $local_key . "__lk";
        }
        if($this->pivot_table)
        {
            foreach ($this->pivot_table as $index => $pivot_table) {
                $relations_array[$index] = $relations_array[$index] . "__pt__" . $pivot_table . "__pt";
            }
        }

        foreach ($relations_array as $arr) {
            $single_relation = [
                'realtion_type' => GraceStr::getBetween($arr, "rt__", "__rt"),
                'foreign_table' => GraceStr::getBetween($arr, "ft__", "__ft"),
                'foreign_key' => GraceStr::getBetween($arr, "fk__", "__fk"),
                'local_key' => GraceStr::getBetween($arr, "lk__", "__lk"),
                'pivot_table' => GraceStr::getBetween($arr, "pt__", "__pt"),
            ];
            switch ($single_relation['realtion_type']) {
                case 'HasOne':
                    $relation_template = self::has_one($single_relation['foreign_table'], $single_relation['foreign_key'], $single_relation['local_key']);
                    break;

                case 'BelongsTo':
                    $relation_template = self::belongs_to($single_relation['foreign_table'], $single_relation['foreign_key'], $single_relation['local_key']);
                    break;

                case 'HasMany':
                    $relation_template = self::has_many($single_relation['foreign_table'], $single_relation['foreign_key'], $single_relation['local_key'], $single_relation['pivot_table']);
                    break;

                case 'BelongsToMany':
                    $relation_template = self::belongs_to_many($single_relation['foreign_table'], $single_relation['foreign_key'], $single_relation['local_key'], $single_relation['pivot_table']);
                    break;
            }
            array_push($template, $relation_template);
        }

        $string_relation_template = '';
        foreach ($template as $index => $tem) {
            $string_relation_template .= $template[$index] . "\n";
        }

        $model_path = base_path() . "/" . $local_table->model . ".php";
        $mdoel_content = file_get_contents($model_path);
        $start_relation_field_marker = "/*<relations>*/";
        $end_relation_field_marker = "/*</relations>*/";
        $relations_field_in_model = GraceStr::getBetween($mdoel_content, $start_relation_field_marker, $end_relation_field_marker);
        $new_model = str_replace(
            $relations_field_in_model,
            $relations_field_in_model .= $string_relation_template,
            $mdoel_content
        );
        file_put_contents($model_path, $new_model);

        //append relation field in create.blade.pho file
        $create_file_content = file_get_contents(base_path()."/resources/views/grace/$local_table->table_name/create.blade.php");
        $create_form = GraceStr::getBetween( $create_file_content, "<!--<$local_table->table_name-form>-->","<!--</$local_table->table_name-form>-->");
        $new_create_form = $create_form . $this->create('categories');
        $new_create_form = preg_replace('/\\\\/', '', $new_create_form);
        $create_file_content = str_replace($create_form, $new_create_form, $create_file_content);
        file_put_contents(base_path()."/resources/views/grace/$local_table->table_name/create.blade.php" ,$create_file_content);

    }

    /**
     * Defining the template of hasOne relation
     * @param $foriegn_table
     * @return String
     */
    public function has_one($foreign_table, $foriegn_key, $local_key)
    {
        $foriegn_model = GraceStr::singularClass($foreign_table);
        $single_foreign_table_name = Str::singular($foreign_table);
        return "
        /*<$this->local_table-$single_foreign_table_name-relation>*/
        public function $single_foreign_table_name()
        {
            return \$this->hasOne($foriegn_model::class, '$foriegn_key', '$local_key');
        }
        /*</$this->local_table-$single_foreign_table_name-relation>*/
        ";
    }

    /**
     * Defining the template of hasMany relation
     * @param $foriegn_table
     * @return String
     */
    public function has_many($foreign_table, $foriegn_key, $local_key, $pivot_table)
    {
        if($pivot_table == null){
            $foriegn_model = GraceStr::singularClass($foreign_table)."::class";
        } else {
            $foriegn_model = "'$pivot_table'";
        }
        return "
        /*<$this->local_table-$foreign_table-relation>*/
        public function $foreign_table()
        {
            return \$this->hasMany($foriegn_model, '$foriegn_key', '$local_key');
        }
        /*</$this->local_table-$foreign_table-relation>*/
        ";
    }

    /**
     * Defining the template of belongsTo relation
     * @param $foriegn_table
     * @return String
     */
    public function belongs_to($foreign_table, $foriegn_key, $local_key)
    {

        $foriegn_model = GraceStr::singularClass($foreign_table);
        $single_foreign_table_name = Str::singular($foreign_table);
        return "
        /*<$this->local_table-$single_foreign_table_name-relation>*/
        public function $single_foreign_table_name()
        {
            return \$this->belongsTo($foriegn_model::class, '$foriegn_key', '$local_key');
        }
        /*</$this->local_table-$single_foreign_table_name-relation>*/
        ";
    }

    /**
     * Defining the template of belongsToMany relation
     * @param $foriegn_table
     * @return String
     */
    public function belongs_to_many($foreign_table, $foriegn_key, $local_key, $pivot_table)
    {
        if($pivot_table == null){
            $foriegn_model = GraceStr::singularClass($foreign_table)."::class";
        } else {
            $foriegn_model = "'$pivot_table'";
        }
        $single_foreign_table_name = Str::singular($foreign_table);
        return "
        /*<$this->local_table-$single_foreign_table_name-relation>*/
        public function $single_foreign_table_name()
        {
            return \$this->belongsToMany($foriegn_model, '$local_key', '$foriegn_key');
        }
        /*</$this->local_table-$single_foreign_table_name-relation>*/
        ";
    }

    public function create($foreign_table){
        $capital_foreign_table = Str::title($foreign_table);
        $singular_foreign_table = Str::singular($foreign_table);
        return "
        <div class='form-group'>
        <label>$capital_foreign_table</label>
        <select class='form-control' id='sel1'>
        @foreach($$foreign_table as $$singular_foreign_table)
            <option value='{{ $$singular_foreign_table->\id }}'>{{ $$singular_foreign_table->\\name }}</option>
        @endforeach
        </select>
    </div>
        ";
    }
}
