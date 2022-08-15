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
        dd($request);
        $this->relation_type = MakeStubsAliveHelper::filteringArray($request->relation_type);
        $this->local_table = $request->local_table;
        $this->foreign_table = MakeStubsAliveHelper::filteringArray($request->foreign_table);
        // $this->foreign_model = MakeStubsAliveHelper::getSingularClassName($request->foreign_table);
        // $this->single_foreign_table_name = Str::singular($request->foreign_table);
        $this->local_key = MakeStubsAliveHelper::filteringArray($request->local_key);
        $this->foriegn_key = MakeStubsAliveHelper::filteringArray($request->foriegn_key);

    }
    /**
     * Adding desired relation for the named model
     * @return void
     */
    public function submit_relations()
    {
        dd($this->foreign_table);
    }

    /**
     * Defining the template of hasOne relation
     * @param $foriegn_table
     * @return String
     */
    public function has_one()
    {
        // $foriegn_model = MakeStubsAliveHelper::getSingularClassName($this->foreign_table);
        return "
        //============= $this->local_table - $this->single_foreign_table_name relation =============
        public function $this->single_foreign_table_name()
        {
            return \$this->hasOne($this->foreign_model::class, '$this->foriegn_key', '$this->local_key');
        }
        //========================================================
        ";
    }

    /**
     * Defining the template of belongsTo relation
     * @param $foriegn_table
     * @return String
     */
    public function belongs_to()
    {
        // $foriegn_model = MakeStubsAliveHelper::getSingularClassName($this->foreign_table);
        return "
        //============= $this->local_table - $this->single_foreign_table_name relation =============
        public function $this->single_foreign_table_name()
        {
            return \$this->belongsTo($this->foreign_model::class, '$this->foriegn_key', '$this->local_key');
        }
        //========================================================
        ";
    }
}
