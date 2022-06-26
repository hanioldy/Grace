<v-container class="grey lighten-5 mb-6">
    <v-row>
        <v-col cols="12">
            <v-card class="pa-2">
                <v-main>
                    <form action="{{ route('makeMigrationAlive') }}" method="POST">
                        @csrf
                        <v-row>
                            <v-col cols="6">
                                <v-text-field name="namespace" label="Namespace" outlined value="database\migrations">
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field name="table_name" label="Table Name" outlined>
                                </v-text-field>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12">
                                <v-btn color="success" @click="addField">Add row</v-btn>
                            </v-col>
                        </v-row>
                        <div v-for="item in basic" :key="item.id">
                            <v-row>
                                <v-col cols="6">
                                    <v-text-field name="field_names[]" label="Field Name" outlined>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="6">
                                    <v-autocomplete name="field_types[]" label="Field Type" small-chips
                                        :items="columnTypes"></v-autocomplete>
                                </v-col>
                            </v-row>
                        </div>


                        <v-btn type="submit" color="primary">Make Alive</v-btn>
                    </form>
                </v-main>
            </v-card>
        </v-col>
    </v-row>
</v-container>
