<template>
    <div class="text-center">
        <v-dialog
            persistent
            v-model="laboratoryOpen"
            width="1200">
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    Doc, please help us solve the missing RNA of the disease {{ referenceDisease.name }}!
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <v-col cols="12" class="pt-5">
                            <p>Disease name: <b>{{referenceDisease.name}}</b></p>
                            <p>Difficulty factor: <b>{{referenceDisease.difficulty}}</b></p>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="1" v-for="(nucleotide, index) in solvedSequence" :key="index">
                            <v-chip :class="{'green' : index === currentNucleotideIndex && solving}" outlined>{{ nucleotide }}</v-chip>
                        </v-col>
                    </v-row>
                </v-card-text>

                <v-divider></v-divider>

                <!-- Laboratory actions -->
                <v-card-actions>
                    <v-btn
                        color="red"
                        text
                        outlined
                        @click="closeLaboratory()"
                        :disabled="solving">
                        <v-icon left>mdi-exit-run</v-icon>
                        Close the laboratory
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        text
                        outlined
                        @click="solveRNASequence()"
                        v-if="!solving && !solved">
                        <v-icon left>mdi-dna</v-icon>
                        Solve RNA
                    </v-btn>
                    <v-btn
                        color="green"
                        text
                        v-if="solved"
                        @click="closeLaboratory()">
                        <v-icon left>mdi-hand-clap</v-icon>
                        The RNA has been solved!
                    </v-btn>

                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>

</template>

<script>
export default {
    props: ["selectedDisease"],
    watch: {
        /** Checks whether the prop has been set from the parent
         * component and initializes important variables based on the prop.
         * **/
        selectedDisease: function () {
            if (this.selectedDisease != null) {
                this.laboratoryOpen = true;
                this.referenceSequence = this.selectedDisease.rna;
                this.referenceDisease = this.selectedDisease;
            } else {
                this.laboratoryOpen = false;
                this.referenceSequence = "";
                this.referenceDisease = {};
            }
        }
    },
    mounted() {
        // Initialize the solvedSequence array
        this.initSolvedSequence();
    },
    data() {
        return {
            laboratoryOpen: false,
            nucleotides: "ACGU",
            solvedSequence: [],
            referenceSequence: "",
            currentNucleotideIndex : 0,
            referenceDisease: {},
            solving: false,
            solved: false
        }
    },
    methods: {
        /** Initialization of the solvedSequence array. **/
        initSolvedSequence() {
            this.solvedSequence = [];

            for (let n = 0; n < 12; n++) {
                Vue.set(this.solvedSequence, n, '');
            }
        },
        /** Closes the laboratory and resets the variables to their initial state **/
        closeLaboratory() {
            this.solved = false;
            this.solving = false;
            this.referenceSequence = "";

            this.initSolvedSequence();

            this.$emit('onLaboratoryClosed');
        },
        /** Solves the RNA sequence based on the reference sequence **/
        async solveRNASequence() {
            this.solving = true;

            // If the reference sequence is present, we can continue.
            // No reason to continue without reference RNA sequence.
            if (this.referenceSequence !== "") {

                // Loop through each nucleotide of the reference sequence
                for (let i = 0; i < this.referenceSequence.length; i++) {

                    // Set the currentNucleotideIndex to the current
                    // local iterator, so we can display nice green
                    // outline in the interface, to make it more appealing.
                    this.currentNucleotideIndex = i;

                    // Loop through all known nucleotides, in this case: ACGU
                    for (let n = 0; n < this.nucleotides.length; n++) {

                        // Set the nucleotide in the solved sequence,
                        // even though at this point we don't know if it is the correct nucleotide.
                        // This is purely cosmetic feature for the user,
                        // so he or she can see, that the sequence is being solved.
                        Vue.set(this.solvedSequence, i, this.nucleotides[n]);

                        // Set timeout as the difficulty in milliseconds before checking
                        // whether we've got the right nucleotide.
                        await new Promise(timeout => setTimeout(timeout, this.selectedDisease.difficulty));

                        // If the nucleotide of the reference sequence matches
                        // the currently looped nucleotide, we can break from the
                        // loop and place the nucleotide to the solvedSequence array.
                        if (this.referenceSequence[i] === this.nucleotides[n]) {
                            Vue.set(this.solvedSequence, i, this.nucleotides[n]);
                            break;
                        }
                    }
                }

            }

            // If we got here, the disease is cured! Yay!
            await this.diseaseCured();
        },

        /** Marks the disease as cured **/
        async diseaseCured() {
            this.solving = false;
            this.solved = true;
            this.selectedDisease.solved = true;

            await axios
            .put('/api/disease/' + parseInt(this.selectedDisease.disease_id), this.selectedDisease)
            .then((response) => {
                console.log("disease cured:");
                console.log(response.data);
                this.$emit('onDiseaseCured');
            });
        }
    }
}
</script>
