<template>
    <div class="projects-style">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <h3>Mes projets</h3>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="input form-control mr-sm-2" type="text" v-model="search" placeholder="Filtrer les projets"
                           @input="resetPagination()" style="width: 250px;">
                </form>
              </div>
        </nav>
        <br>
        <div class="table-style">
            <div class="control">
                
                <div class="select">
                    <span>Montrer
                    <select v-model="length" @change="resetPagination()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                    projets
                    </span>
                </div>
                
            </div>
        </div>
        <table class="table table-bordered table-responsive">
            <thead style="background-color: #eae9e9 ;">
                <tr>
                    <th v-for="column in columns" :key="column.name" @click="sortBy(column.name)"
                        :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                        style="width: 18%; cursor:pointer;">
                        {{column.label}}
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody  style="background-color: white;">
                <tr v-for="project in paginatedProjects" :key="project.id">
                    <td>#{{ project.id }}</td>
                    <td><router-link :to="{name: 'edit', params: { id: project.id }}" title="Consulter/Modifier">{{ project.name }}
                        </router-link></td>
                    <td>{{ project.client }}</td>
                    <td>
                        <div class="progress">
                          <div class="progress-bar" role="progressbar" :style="{width: project.progress + '%'}" :aria-valuenow="project.progress" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <td>{{ project.deadline }}</td>
                    <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-danger" @click="deleteProject(project.id)">Supprimer</button>
                    </div>
                </td>
                </tr>
            </tbody>
        </table>
        <div>
            <nav class="pagination" v-if="!tableShow.showdata">
                <span class="page-stats">{{pagination.from}} - {{pagination.to}} of {{pagination.total}}</span>
                <a v-if="pagination.prevPageUrl" class="btn btn-sm btn-primary pagination-previous" @click="--pagination.currentPage">
                    Prev
                </a>
                <a class="btn btn-sm btn-primary pagination-previous" v-else disabled>
                Prev
                </a>
                <a v-if="pagination.nextPageUrl" class="btn btn-sm pagination-next" @click="++pagination.currentPage">
                    Next
                </a>
                <a class="btn btn-sm btn-primary pagination-next" v-else disabled>
                    Next
                </a>
            </nav>
            <nav class="pagination" v-else>
                <span class="page-stats">
                    {{pagination.from}} - {{pagination.to}} of {{filteredProjects.length}}
                    <span v-if="`filteredProjects.length < pagination.total`"></span>
                </span>
                <a v-if="pagination.prevPage" class="btn btn-sm btn-primary pagination-previous" @click="--pagination.currentPage">
                    Prev
                </a>
                <a class="btn btn-sm pagination-previous btn-primary" v-else disabled>
                Prev
                </a>
                <a v-if="pagination.nextPage" class="btn btn-sm btn-primary pagination-next" @click="++pagination.currentPage">
                    Next
                </a>
                <a class="btn btn-sm pagination-next btn-primary"  v-else disabled>
                    Next
                </a>
            </nav>
        </div>
    </div>
</template>

<script>

export default {
    created() {
        this.getProjects();/*
        Fire.$on('reloadProjects', () => {
            this.getProjects();
        })*/
    },
    data() {
        let sortOrders = {};
        let columns = [
            {label: 'Numéro', name: 'id' },
            {label: 'Nom du projet', name: 'name'},
            {label: 'Client', name: 'client' },
            {label: 'Progression', name: 'progress'},
            {label: 'Deadline', name: 'deadline' },
        ];
        columns.forEach((column) => {
           sortOrders[column.name] = -1;
        });
        
        return {
            projects: [],
            columns: columns,
            sortKey: 'id',
            sortOrders: sortOrders,
            length: 10,
            search: '',
            tableShow: {
                showdata: true,
            },
            pagination: {
                currentPage: 1,
                total: '',
                nextPage: '',
                prevPage: '',
                from: '',
                to: ''
            },
        }
    },
    methods: {

        
        deleteProject(id) {
            this.$confirm("Supprimer ce projet ?").then(() => {
                this.axios
                    .delete(`http://localhost:8000/api/project/delete/${id}`)
                    .then(response => {
                        let i = this.projects.map(item => item.id).indexOf(id); 
                        this.projects.splice(i, 1)
                    });
            });
        },
        
        getProjects() {
            this.axios
                .get('http://localhost:8000/api/projects')
                .then(response => {
                    this.projects = response.data;
                });
        },
        paginate(array, length, pageNumber) {
            this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
            this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
            this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
            this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
            return array.slice((pageNumber - 1) * length, pageNumber * length);
        },
        resetPagination() {
            this.pagination.currentPage = 1;
            this.pagination.prevPage = '';
            this.pagination.nextPage = '';
        },
        sortBy(key) {
            this.resetPagination();
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
        },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value)
        },
    },
    computed: {
        filteredProjects() {
            let projects = this.projects;
            if (this.search) {
                projects = projects.filter((row) => {
                    return Object.keys(row).some((key) => {
                        return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                    })
                });
            }
            let sortKey = this.sortKey;
            let order = this.sortOrders[sortKey] || 1;
            if (sortKey) {
                projects = projects.slice().sort((a, b) => {
                    let index = this.getIndex(this.columns, 'name', sortKey);
                    a = String(a[sortKey]).toLowerCase();
                    b = String(b[sortKey]).toLowerCase();
                    if (this.columns[index].type && this.columns[index].type === 'date') {
                        return (a === b ? 0 : new Date(a).getTime() > new Date(b).getTime() ? 1 : -1) * order;
                    } else if (this.columns[index].type && this.columns[index].type === 'number') {
                        return (+a === +b ? 0 : +a > +b ? 1 : -1) * order;
                    } else {
                        return (a === b ? 0 : a > b ? 1 : -1) * order;
                    }
                });
            }
            return projects;
        },
        paginatedProjects() {
            return this.paginate(this.filteredProjects, this.length, this.pagination.currentPage);
        }
    }
};
</script>

