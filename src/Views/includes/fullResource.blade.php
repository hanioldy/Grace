<v-container class="grey lighten-5 mb-6">
    <v-row>
        <v-col cols="12">
            <v-card class="pa-2">
                <v-main>
                    <form action="{{ route('makeFullResourceAlive') }}" method="POST">
                        @csrf
                        <v-row>
                            <v-col cols="6">
                                <v-text-field name="table_name" label="Table Name" outlined>
                                </v-text-field>
                            </v-col>
                            {{-- <v-col cols="6">
                                <v-text-field value="storage\path\" name="storage_path" label="Storage Path" outlined>
                                </v-text-field>
                            </v-col> --}}
                        </v-row>
                        <div v-for="(item, index) in basic" :key="item.id">
                            <v-row>
                                <v-col>
                                    <h3>Field #<span v-html="index + 1"></span></h3>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="5">
                                    <v-text-field name="field_names[]" label="Field Name" outlined>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="5">
                                    <v-autocomplete name="field_types[]" label="Field Type" small-chips
                                        :items="columnTypes"></v-autocomplete>
                                </v-col>
                                <v-col cols="2">
                                    <v-checkbox name="isFile[]" label="File?" value="1"></v-checkbox>
                                    <input style="display:none" id='testNameHidden' type='checkbox' value='0'
                                        name='isFile[]' checked>
                            </v-row>
                        </div>
                        <v-row>
                            <v-col cols="12">
                                <v-btn color="success" @click="addField">Add Field</v-btn>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <hr>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field value="{{ config('grace.model_namespace') }}" name="model_namespace" label="Model Namespace"
                                    outlined>
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                </v-combobox>
                                <v-text-field value="{{ config('grace.request_namespace') }}" name="request_namespace"
                                    label="Request Namespace" outlined>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field value="{{ config('grace.migration_namespace') }}" name="migration_namespace"
                                    label="Migration Namespace" outlined>
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                </v-combobox>
                                <v-text-field value="{{ config('grace.resource_namespace') }}" name="resource_namespace"
                                    label="Resource Namespace" outlined>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field value="{{ config('grace.controller_namespace') }}" name="controller_namespace"
                                    label="Controller Namespace" outlined>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-btn type="submit" color="primary">Make Alive</v-btn>

                            </v-col>
                        </v-row>
                    </form>
                </v-main>
            </v-card>
        </v-col>
    </v-row>
</v-container>
