<template>
    <div>
        <h4 class="text-center">Edit Company</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateBook">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" :class="error_class" class="form-control" v-model="company.name">
                        <small class="red-font">{{ error_name }} </small>
                    </div><br>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="company.email">
                    </div><br>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" class="form-control" v-model="company.website">
                    </div><br>
                    <div class="form-group">
                        <label>Logo</label>
                        <input type="file" class="form-control" v-on:change="onChange">
                    </div><br>
                    <button type="submit" class="btn btn-primary">Update Company</button>
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
                website: '',
                logo: ''
            },
            file:'',
            error_name:''
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/companies/${this.$route.params.id}/edit`)
                .then(response => {
                    this.company = response.data;
                })
                .catch(function (error) {
                    console.error(error);
                });
        })
    },
    methods: {
        onChange(e) {
            this.file = e.target.files[0];
        },
        updateBook() {
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            if(this.file == "")
            {
                this.file = this.company.logo
            }
            let data = new FormData();
            data.append('file', this.file);
            data.append('name',this.company.name);
            data.append('email',this.company.email);
            data.append('website',this.company.website);
            data.append("_method", "put");
            console.log(this.company)
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/companies/${this.$route.params.id}`, data, config)
                    .then(response => {
                        this.$router.push({name: 'Companies'});
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