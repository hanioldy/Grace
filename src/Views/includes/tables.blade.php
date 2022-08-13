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
    <div id="tables">
        <v-container>
            <v-simple-table dark>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th>
                                Table
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tables as $table)
                            <tr>
                                <td>{{ $table->table_name }}</td>
                                <td>
                                    <a href="{{ route('delete_table', $table->id) }}">
                                        <v-btn color="error">
                                            Delete
                                        </v-btn>

                                    </a>
                                    <a href="{{ route('add_validation', $table->id) }}">
                                        <v-btn color="error">
                                            Add Validation
                                        </v-btn>

                                    </a>
                                    <a href="{{ route('add_relation', $table->id) }}">
                                        <v-btn color="error">
                                            Add Relation
                                        </v-btn>

                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </template>
            </v-simple-table>
        </v-container>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script>
        new Vue({
            el: "#tables",
            vuetify: new Vuetify(),
        });
    </script>
</body>

</html>
