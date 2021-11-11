<template>
    <div>
        <h4 class="text-center">Add Company</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCompany" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="company.name">
                    </div><br>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" v-model="company.email">
                    </div><br>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="url" class="form-control" v-model="company.website">
                    </div><br>
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" class="form-control" v-on:change="onChange">
                    </div><br>
                    <button type="submit" class="btn btn-primary">Add Company</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            company: {
                name: null,
                email: null,
                website: null
            },
            file :''
        }
    },
    methods: {
        onChange(e) {
            this.file = e.target.files[0];
        },
        addCompany() {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('file', this.file);
            data.append('name',this.company.name);
            data.append('email',this.company.email);
            data.append('website',this.company.website);
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/companies/add', data, config)
                    .then(response => {
                        this.$router.push({name: 'Companies'})
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
