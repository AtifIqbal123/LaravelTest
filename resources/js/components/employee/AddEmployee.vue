<template>
    <div>
        <h4 class="text-center">Add Employee</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addEmployee" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>First name</label>
                        <input type="text" :class="error_class" class="form-control" v-model="employee.f_name">
                        <small class="red-font">{{ error_name }} </small>
                    </div><br>
                    <div class="form-group">
                        <label>Last name</label>
                        <input type="text" :class="error_class" class="form-control" v-model="employee.l_name">
                        <small class="red-font">{{ error_name }} </small>
                    </div><br>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" v-model="employee.email">
                    </div><br>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="url" class="form-control" v-model="employee.phone">
                    </div><br>
                    <button type="submit" class="btn btn-primary">Add employee</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            employee: {
                f_name: '',
                l_name:'',
                email: '',
                phone: ''
            },
            companies:[],
            error_name:'',
            error_class:''
        }
    },
    created() {
            this.fetchCompany()
        },
    methods: {
         fetchCompany() {
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.get('/api/employees')
                        .then(response => {
                             this.companies = response.data
                        });
                });
        },
        addEmployee() {
            let data = new FormData();
            data.append('f_name',this.employee.f_name);
            data.append('l_name',this.employee.l_name);
            data.append('email',this.employee.email);
            data.append('phone',this.employee.phone);
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/employee', data)
                    .then(response => {
                        this.$router.push({name: 'Employee'})
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
