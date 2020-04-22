<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <h3 class="text-center">Ajouter un projet</h3>
        </nav>

</br>
        <div class="row">
        </div>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addProject">
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
                    <button type="submit" class="btn btn-primary">Ajouter un projet</button>
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
        methods: {
            addProject() {


                console.log(this.project)

                if(this.project.name && this.project.client && this.project.client_addr && this.project.deadline && this.project.total_price) {
                    this.axios
                        .post('http://localhost:8000/api/project/add', this.project)
                        .then(response => (
                            this.$router.push({name: 'home'})
                            // console.log(response.data)
                        ))
                        .catch(error => console.log(error))
                        .finally(() => this.loading = false)
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