<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet" />
    <title>Grace - Add Validation</title>
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
    <div id="validation">
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
                                <form method="POST" action="{{ route('submit_validation') }}">
                                    @foreach ($fields as $field)
                                        <v-card>
                                            <v-container>
                                                <v-card-title>
                                                    {{ $field }}
                                                </v-card-title>

                                                <v-row v-for="(rule, index) in rules" :key="rule.id">
                                                    <v-col cols="12" md="6">
                                                        <v-autocomplete :items="rulesList" outlined name="rule[]">
                                                        </v-autocomplete>
                                                    </v-col>
                                                    <v-col cols="12" md="3">
                                                        <v-btn color="success" @click="addRule">Add Rule</v-btn>
                                                    </v-col>
                                                    <v-col cols="12" md="3">
                                                        <v-btn color="error" @click="deleteRule">Remove Rule</v-btn>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card>
                                    @endforeach
                                    <v-btn type="submit" color="primary">Make Validation Alive</v-btn>
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
        el: "#validation",
        data: () => ({
            rulesList: [
                'rule1',
                'rule2',
                'rule3',
            ],
            rules: [{
                name: "",
                time: ""
            }],
        }),
        methods: {
            addRule() {
                this.id += 1;
                this.rules.push({
                    name: "",
                    time: ""
                });
            },
            deleteRule(fieldIndex) {
                this.rules.splice(fieldIndex, 1)
            },
        },
    });
</script>
