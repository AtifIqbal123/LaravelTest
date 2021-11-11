<template>
    <div>
        <h4 class="text-center">Edit Company</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateBook">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="company.name">
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
                name: null,
                email: null,
                website: null,
                logo: null
            },
            file:''
        }
    },
    created() {
        this.$axios.get('/sanctum/csrf-cookie').then(response => {
            this.$axios.get(`/api/companies/edit/${this.$route.params.id}`)
                .then(response => {
                    console.log(response.data.website)
                    if(response.data.website == 'null')
                    {
                        response.data.website = ''
                    }
                    if(response.data.email == 'null')
                    {
                        response.data.email = ''
                    }
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

            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post(`/api/companies/update/${this.$route.params.id}`, data, config)
                    .then(response => {
                        this.$router.push({name: 'Companies'});
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
