<template>
    <div>
        <h4 class="text-center">All Companies</h4><br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Logo</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                {{data}}
            <tr v-for="(company) in companies.data" :key="company.id">
                <td>{{ company.id }}</td>
                <td>{{ company.name }}</td>
                <td v-if="company.email != 'null'">{{ company.email }}</td>
                <td v-else>-</td>
                <td v-if="company.website != 'null'">{{ company.website }}</td>
                <td v-else>-</td>
                <td v-if="company.logo"><img :src="'thumbnail/'+company.logo" /></td>
                <td v-else>-</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editcompany', params: { id: company.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteCompany(company.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-info" @click="this.$router.push('/companies/add')">Add Company</button>
        <div style="float:right">
            <v-pagination
                    v-model="companies"
                    :pages="companies.last_page"
                    :range-size="2"
                    active-color="#DCEDFF"
                    @update:modelValue="updateHandler"
                />
        </div>
    </div>
</template>

<script>
import VPagination from "@hennge/vue3-pagination";
import "@hennge/vue3-pagination/dist/vue3-pagination.css";
export default {
     components: {
        VPagination
    },
    data() {
        return {
            companies: {}
        }
    },
    created() {
        this.updateHandler()
    },
    methods: {
         updateHandler(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.get('/api/companies?page=' + page)
                        .then(response => {
                            //return response.json();
                             this.companies = response.data
                            console.log(this.companies)
                             //this.data = response.data
                        });
                });
            },
        deleteCompany(id) {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.delete(`/api/companies/${id}`)
                    .then(response => {
                        let i = this.companies.map(item => item.id).indexOf(id); // find index of your object
                        this.companies.splice(i, 1)
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
