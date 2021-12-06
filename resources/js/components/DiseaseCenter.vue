<template>
    <v-app>
        <v-main>
            <v-container>
                <!-- Snackbar after new disease has been discovered -->
                <v-snackbar
                    v-if="diseases.length > 0"
                    top
                    color="warning"
                    v-model="newDiseaseDiscovered">
                    <p>Beware! New disease has been discovered: <b>{{ diseases.slice(-1)[0].name }}</b></p>
                </v-snackbar>

                <!-- Snackbar to show after new vaccine has been developed -->
                <v-snackbar
                    bottom
                    color="green"
                    v-model="vaccineDeveloped">
                    <p>New mRNA vaccine has been developed: <b>{{ newVaccine.name }}</b></p>
                </v-snackbar>

                <!-- Laboratory -->
                <laboratory
                    :selectedDisease="selectedDisease"
                    @onLaboratoryClosed="closeLaboratory()"
                    @onDiseaseCured="onDiseaseCured()">
                </laboratory>

                <!-- DISEASE CENTER -->
                <v-row>
                    <v-col cols="12">
                        <v-card>
                            <v-card-title>Hey Doc! Please help us fight these newly discovered diseases!</v-card-title>
                            <v-card-text>
                                They are currently causing concern among the world population:
                                <v-simple-table v-if="diseases.length > 0">
                                    <template v-slot:default>
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                Disease
                                            </th>
                                            <th class="text-center">
                                                RNA Sequence
                                            </th>
                                            <th class="text-center">
                                                Laboratory
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="disease in diseases" :key="disease.rna">
                                            <td class="text-center"><v-icon>mdi-virus</v-icon> {{ disease.name }}</td>
                                            <td class="text-center" v-if="disease.solved">{{ disease.rna }}</td>
                                            <td class="text-center font-italic" v-else>UNKNOWN</td>
                                            <td class="text-center pt-3 pb-3">
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-btn v-bind="attrs" v-on="on" fab @click="openLaboratory(disease)" :disabled="disease.solved">
                                                            <v-icon color="green" large>mdi-test-tube</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Enter the laboratory to solve RNA of the virus!</span>
                                                </v-tooltip>
                                                <v-tooltip bottom>
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-btn
                                                            fab
                                                            @click="makeVaccine(disease)"
                                                            v-bind="attrs"
                                                            v-on="on"
                                                           :disabled="!disease.solved || disease.has_vaccine">
                                                            <v-icon color="red" large>mdi-needle</v-icon>
                                                        </v-btn>
                                                    </template>
                                                    <span>Make new mRNA vaccine based on the RNA of the virus.</span>
                                                </v-tooltip>
                                            </td>
                                        </tr>
                                    </tbody>
                                    </template>
                                </v-simple-table>
                                <h4 v-else class="bold">There are no diseases yet! Hurray!</h4>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
    export default {
        mounted() {
            this.getDiseases();

            window.setInterval(() => {
                this.discoverNewDiseases();
            }, 5000);
        },
        data() {
            return {
                selectedDisease : {name : '', rna : '', solved : false, has_vaccine : false},
                diseases : [],
                newDiseaseDiscovered : false,
                vaccineDeveloped : false,
                newVaccine : {}
            }
        },
        methods : {
            async discoverNewDiseases() {
                await axios
                    .post('/api/disease')
                    .then(response => {
                        if(response.data)
                        {
                            this.newDiseaseDiscovered = true;
                        }
                    });

                await this.getDiseases();
            },
            openLaboratory(disease) {
                this.selectedDisease = disease;
            },
            closeLaboratory() {
                this.selectedDisease = null;
            },
            selectDisease(disease) {
                this.selectedDisease = disease;
            },
            async getDiseases() {
                await axios
                .get('/api/disease?has_vaccine=0')
                .then(response => {
                    this.diseases = response.data;
                });
            },
            async makeVaccine(disease) {
                await axios.post('/api/vaccine', disease)
                .then(response => {
                    this.newVaccine = response.data;
                    this.vaccineDeveloped = true;
                    this.getDiseases();
                });
            },
            onDiseaseCured() {
                this.getDiseases();
            }
        }
    }
</script>
