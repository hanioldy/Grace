<v-container class="grey lighten-5 mb-6">
    <v-row>
        <v-col cols="12">
            <v-card class="pa-2">
                <v-main>
                    <form action="{{ route('makeControllerAlive') }}" method="POST">
                        @csrf
                        <v-row>
                            <v-col cols="6">
                                <v-text-field name="namespace" label="Namespace" outlined>
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field name="class_name" label="Class Name" outlined>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>

                            <v-col cols="6">
                                <v-text-field name="resource_path" label="Resource Path" outlined>
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field name="model_path" label="Model Path" outlined>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-combobox name="fillable_array" label="Fullable Items" multiple chips>
                                </v-combobox>
                            </v-col>
                            <v-col cols="6">
                                <v-combobox name="fillable_files_array" label="Fullable Files Items" multiple chips>
                                </v-combobox>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-text-field name="key_and_disk" label="Key and Disk" outlined>
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field name="array_key" label="Array Key" outlined>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-btn type="submit" color="primary">Make Alive</v-btn>

                    </form>
                </v-main>
            </v-card>
        </v-col>
    </v-row>
</v-container>
