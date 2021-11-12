<template>
    <div>
        <h4 class="text-center">Add Company</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addCompany" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" :class="error_class" class="form-control" v-model="company.name">
                        <small class="red-font">{{ error_name }} </small>
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
                name: '',
                email: '',
                website: ''
            },
            file :'',
            error_name:'',
            error_class:''
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
                this.$axios.post('/api/companies', data, config)
                    .then(response => {
                        this.$router.push({name: 'Companies'})
                    })
                    .catch(error => {
                        if (error.response.status == 401){
                            this.error_name = error.response.data.error.name[0]
                            this.error_class = "error"
                        }
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
<style>
.error {
    border: 1px solid red;
}
.red-font {
    color:red;
}
</style>
