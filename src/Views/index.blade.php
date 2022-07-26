<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
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
    <div id="app">
        <template>
            <v-app>
                <v-card>
                    <v-card-title class="text-center justify-center py-6">
                        <a href="{{ route('grace_tables') }}">
                            <v-btn>Show tables</v-btn>
                        </a>
                        <h3 class="font-weight-bold text-h2 basil--text">
                            GRACE
                        </h3>
                    </v-card-title>
                    <v-tabs v-model="tab" background-color="transparent" grow>
                        <v-tab>
                            Create Full Resource
                        </v-tab>
                        <v-tab>
                            Create Migration
                        </v-tab>
                        <v-tab>
                            Create Model
                        </v-tab>
                        <v-tab>
                            Create Controller
                        </v-tab>
                        <v-tab>
                            Create Reauest Class
                        </v-tab>
                        <v-tab>
                            Create Resource Class
                        </v-tab>
                    </v-tabs>

                    <v-tabs-items v-model="tab">
                        <v-tab-item>
                            <v-card color="basil" flat>
                                @include('Grace::includes.fullResource')
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card color="basil" flat>
                                @include('Grace::includes.migration')
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card color="basil" flat>
                                @include('Grace::includes.model')
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card color="basil" flat>
                                @include('Grace::includes.controller')
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card color="basil" flat>
                                @include('Grace::includes.request')
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card color="basil" flat>
                                @include('Grace::includes.resource')
                            </v-card>
                        </v-tab-item>
                    </v-tabs-items>
                </v-card>

            </v-app>
        </template>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script>
        new Vue({
            el: "#app",
            vuetify: new Vuetify(),
            data: () => ({
                columnTypes: ['bigIncrements', 'bigInteger', 'binary', 'boolean', 'char', 'dateTimeTz',
                    'dateTime', 'date', 'decimal', 'double', 'enum', 'float', 'foreignId', 'foreignId',
                    'foreignIdFor', 'foreignUuid', 'geometryCollection', 'geometry', 'id', 'increments',
                    'integer', 'ipAddress', 'json', 'jsonb', 'lineString', 'longText ', 'macAddress',
                    'mediumIncrements', 'mediumInteger', 'mediumText', 'morphs', 'morphs', 'multiPoint',
                    'multiPolygon', 'nullableTimestamps', 'nullableMorphs', 'nullableUuidMorphs',
                    'point', 'polygon', 'rememberToken', 'set', 'smallIncrements', 'smallInteger',
                    'softDeletesTz', 'softDeletes', 'string', 'text', 'timeTz', 'time', 'timestampTz',
                    'timestamp', 'timestampsTz', 'timestamps', 'tinyIncrements', 'tinyInteger',
                    'tinyText', 'unsignedBigInteger', 'unsignedDecimal', 'unsignedInteger',
                    'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger',
                    'uuidMorphs', 'uuid', 'year'
                ],
                inputTypes: ['text', 'select', 'textarea', 'file'],
                tab: null,
                id: 1,
                fields: [{
                    name: "",
                    time: ""
                }],
                isSelect: false,
            }),
            methods: {
                addField() {
                    this.id += 1;
                    this.fields.push({
                        name: "",
                        time: ""
                    });
                },
                deleteField(fieldIndex) {
                    this.fields.splice(fieldIndex, 1)
                },
                inputType(event) {
                    if (event == 'select') {
                        return this.isSelect = true;
                    } else {
                        return this.isSelect = false;
                    }
                }
            },
        });
    </script>
</body>

</html>
