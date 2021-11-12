<template>
    <div>
        <h4 class="text-center">All Employees</h4><br/>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Company</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
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

        <button type="button" class="btn btn-info" @click="this.$router.push('/Employees/add')">Add Employee</button>
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
                    this.$axios.get('/api/employees?page=' + page)
                        .then(response => {
                            //return response.json();
                             this.companies = response.data
                            console.log(this.companies.data)
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
