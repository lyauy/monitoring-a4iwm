<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <h3 class="text-center">Consulter un projet</h3>
        </nav>
        </br>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProject">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nom du projet</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="project.name">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Client</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="project.client">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Adresse du client</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" v-model="project.client_addr">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Avancement</label>
                        <div class="col-sm-9">
                            <select v-model="project.progress">
                                <option value="0">0</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="60">60</option>
                                <option value="70">70</option>
                                <option value="80">80</option>
                                <option value="90">90</option>
                                <option value="100">100</option>
                            </select>%
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Deadline</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" v-model="project.deadline">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Prix du projet</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" v-model="project.total_price">€
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Informations complémentaires</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" v-model="project.description"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier le projet</button>
                    <input class="btn btn-primary" id="generatedoc" type="button" value="Générer un devis" v-on:click="generate">
                </form>
            </div>
        </div>
    </div>
</template>


<script>
    var jsPDF = require('jspdf');

    export default {
        data() {
            return {
                project: {}
            }
        },
        created() {
            this.axios
                .get(`http://localhost:8000/api/project/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.project = response.data;
                    // console.log(response.data);
                });
        },
        methods: {
            generate() {
                var doc = new jsPDF();

                var contenthtml = '<h1 align="center">Devis démo incomplète</h1>\
                                        </br>\
                                        </br>\
                                        </br>\
                                    <div>\
                                        <p><strong>- Fournisseur:</strong> John Doe, 20 rue test, 12345, oui</p>\
                                        <p><strong>- Client:</strong> '+this.project.client+', '+this.project.client_addr+'</p>\
                                        <p><strong>- Date de livraison:</strong> '+this.project.deadline+'</p>\
                                    </div>\
                                        </br>\
                                        </br>\
                                        </br>\
                                    <div>\
                                        <h2>Récapitulatif</h2>\
                                        <table align="center">\
                                            <tr>\
                                                <td><strong>Projet</strong><br>\
                                                </td>\
                                                <td><strong>Prix</strong><br>\
                                                </td>\
                                            </tr>\
                                            <tr>\
                                                <td>'+this.project.name+'</td>\
                                                <td>'+this.project.total_price+'€</td>\
                                            </tr>\
                                        </table>\
                                    </div>\
                                    <div>\
                                        <p>Hoc inmaturo interitu ipse quoque sui pertaesus excessit e vita aetatis nono anno atque vicensimo cum quadriennio imperasset. natus apud Tuscos in Massa Veternensi, patre Constantio Constantini fratre imperatoris, matreque Galla sorore Rufini et Cerealis, quos trabeae consulares nobilitarunt et praefecturae.</p>\
                                    </div>';

                console.log(contenthtml);
                 
                doc.fromHTML(contenthtml, 5, 5, {
                    width: 130
                  });
                doc.save('devis.pdf');
            },

            updateProject() {

                if(this.project.name && this.project.client && this.project.client_addr && this.project.deadline && this.project.total_price) {
                    this.axios
                        .post(`http://localhost:8000/api/project/update/${this.$route.params.id}`, this.project)
                        .then((response) => {
                            this.$router.push({name: 'home'});
                        });
                }
                else {

                    var missing = "";

                    if(!this.project.name) {
                        missing += '\n' + " Nom du projet";
                    }
                    if(!this.project.client) {
                        missing += '\n' + "- Nom du client";
                    }
                    if(!this.project.client_addr) {
                        missing += '\n' + "- Adresse du client";
                    }
                    if(!this.project.deadline) {
                        missing += '\n' + "- Deadline";
                    }
                    if(!this.project.total_price) {
                        missing += '\n' + "- Prix total";
                    }
                    /*this.$alert("Informations manquantes : \n"+ missing);*/
                    this.$fire({
                        title: "Informations manquantes",
                        text: missing,
                        type: "error"
                    });
                }
            }
        }
    }
</script>