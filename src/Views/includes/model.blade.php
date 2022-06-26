<v-container class="grey lighten-5 mb-6">
    <v-row>
        <v-col cols="12">
            <v-card class="pa-2">
                <v-main>
                    <form action="{{ route('makeModelAlive') }}" method="POST">
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
                                <v-text-field name="table_name" label="Table Name" outlined>
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                </v-combobox>
                                <v-text-field name="storage_path" label="Storage Path" outlined>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="6">
                                <v-combobox name="fillable_array" label="Fullable Items" multiple chips deletable-chips>

                            </v-col>
                            <v-col cols="6">
                                <v-text-field name="file_name" label="File Name" outlined>
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
