<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet" />
    <title>Grace - Add Relation</title>
    <style>
        /* Helper classes */
        .basil {
            background-color: #FFFBE6 !important;
        }

        .basil--text {
            color: #356859 !important;
        }
    </style>
</head>

<body>
    <div id="relations">
        <template>
            <v-app>
                <v-card>
                    <v-card-title class="text-center justify-center py-6">
                        <h3 class="font-weight-bold text-h2 basil--text">
                            GRACE
                        </h3>
                    </v-card-title>
                    <v-container>
                        <v-form>
                            <v-container>
                                <form method="POST" action="{{ route('submit_relations') }}">
                                    <v-container v-for="(relation, index) in relations">
                                        <v-row>
                                            <v-col cols="4">
                                                <h1>Table {{ $table->table_name }}</h1>
                                            </v-col>
                                            <input type="hidden" name="local_table" value="{{ $table->table_name }}">
                                            <v-col cols="4">
                                                <v-autocomplete outlined label="Relatoin Type" :items="relationTypes"
                                                    item-value="key" item-text="label" name="relation_type[]">
                                                </v-autocomplete>
                                            </v-col>
                                            <v-col cols="4">
                                                <v-autocomplete outlined label="Foreign Table" :items="dbTables"
                                                    v-on:change="ForeignTable" name="foreign_table[]">
                                                </v-autocomplete>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col cols="4">
                                                <v-autocomplete outlined label="Local Key" :items="localFields"
                                                    item-value="key" item-text="label" name="local_key[]">
                                                </v-autocomplete>
                                            </v-col>
                                            <v-col cols="4">
                                                <v-autocomplete outlined label="Foreign Key" :items="foriegnKey"
                                                    name="foriegn_key[]">
                                                </v-autocomplete>
                                            </v-col>
                                            <v-col cols="3">
                                                <v-btn color="error" v-on:click="deleteRelation(index)">
                                                    Remove
                                                    Relation</v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                    <v-row>
                                        <v-col cols="3">
                                            <v-btn color="success" v-on:click="addRelation">
                                                Add
                                                Relation</v-btn>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <hr>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-btn type="submit" color="primary" v-on:click="addRelation">Add Relations
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </form>
                            </v-container>
                        </v-form>
                    </v-container>
                </v-card>
            </v-app>
        </template>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

</html>

<script>
    new Vue({
        vuetify: new Vuetify(),
        el: "#relations",
        data() {
            return {
                relations: [{
                    name: "",
                    time: Date.now(),
                }],
                id: 1,
                relationTypes: [{
                    label: 'Has One',
                    key: 'HasOne'
                }, {
                    label: 'Has Many',
                    key: 'HasMany'
                }, {
                    label: 'Belongs To',
                    key: 'BelongsTo'
                }, {
                    label: 'Belongs To Many',
                    key: 'BelongsToMany'
                }],
                localFields: [],
                dbTables: [],
                localKey: [],
                foriegnKey: [],
                dbFields: [],
            }
        },
        methods: {
            ForeignTable(event) {
                this.foriegnKey = Object.values(this.dbFields[event]);
                console.log(this.foriegnKey);
            },
            addRelation() {
                this.id += 1;
                this.relations.push({
                    name: "",
                    time: Date.now(),
                });
            },
            deleteRelation(relationIndex) {
                this.relations.splice(relationIndex, 1)
            },
        },
        created() {
            this.dbTables = <?php echo json_encode($db_tables, JSON_HEX_TAG); ?>;
            this.localFields = <?php echo json_encode($fields, JSON_HEX_TAG); ?>;
            this.dbFields = <?php echo json_encode($db_fields, JSON_HEX_TAG); ?>;
        },
    });
</script>
