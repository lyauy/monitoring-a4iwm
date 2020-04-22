<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <h3 class="text-center">Consulter un projet</h3>
        </nav>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateProject">
                    <div class="form-group">
                        <label>Nom du projet</label>
                        <input type="text" class="form-control" v-model="project.name">
                    </div>
                    <div class="form-group">
                        <label>Client</label>
                        <input type="text" class="form-control" v-model="project.client">
                    </div>
                    <div class="form-group">
                        <label>Adresse du client</label>
                        <input type="text" class="form-control" v-model="project.client_addr">
                    </div>
                    <div class="form-group">
                        <label>Avancement </label>
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
                    <div class="form-group">
                        <label>Deadline</label>
                        <input type="date" class="form-control" v-model="project.deadline">
                    </div>
                    <div class="form-group">
                        <label>Prix du projet</label>
                        <input type="number" class="form-control" v-model="project.total_price">
                    </div>
                    <div class="form-group">
                        <label>Informations complémentaires</label>
                        <input type="textarea" class="form-control" v-model="project.description">
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier le projet</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
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