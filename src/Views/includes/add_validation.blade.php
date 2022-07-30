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
                                    @foreach ($fields as $index =>  $field)
                                        <v-card>
                                            <v-container>
                                                <v-card-title>
                                                    {{ $field }}
                                                </v-card-title>
                                                <v-row v-for="(rule, index) in rules" :key="rule.id">
                                                    <v-row v-if="rule.field === {{json_encode($field)}}">
                                                        <input type="hidden" name="validation[{{$index}}][field]" value="{{$field}}">
                                                        <v-col cols="12" md="6">
                                                            <v-autocomplete :items="rulesList" outlined name="validation[{{$index}}][rules][]">
                                                            </v-autocomplete>
                                                        </v-col>
                                                        <v-col cols="12" md="3">
                                                            <v-btn color="error" v-on:click="deleteRule(index)">Remove Rule</v-btn>
                                                        </v-col>
                                                    </v-row>
                                                </v-row>
                                                <v-row>
                                                    <v-col cols="12" md="3">
                                                        <v-btn color="success" v-on:click="addRule({{json_encode($field)}})">Add Rule</v-btn>
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
            rules: [],
        }),
        methods: {
            addRule(field) {
                console.log('rules',field);
                this.rules.push({
                    field: field,
                    time: Date.now()
                });
            },
            deleteRule(fieldIndex) {
                 this.rules.splice(fieldIndex, 1)
            },
        },
        created(){
           let fields = <?php echo json_encode($fields, JSON_HEX_TAG);  ?>;
          for (const [key, value] of Object.entries(fields)) {
                this.rules.push({field:value, time:Date.now()});
          }
        }
    });
</script>
