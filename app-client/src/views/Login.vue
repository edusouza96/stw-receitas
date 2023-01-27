<template>
    <div class="login container">
        <div class="box bg-dark text-light bg-gradient">
            <h3>Login</h3>
            <form>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" v-model="email">
                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" name="password" class="form-control" v-model="password">
                        </div>
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="form-group d-grid gap-2 col-6 mx-auto">
                           <button class="btn btn-primary" type="button" @click="login">Entrar</button>
                        </div>
                    </div>
                </div>
                <div v-if="loading" class="text-center">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                </div>
                <div class="alert alert-danger mt-2" role="alert" v-if="message">
                    {{ message }}
                </div>
            </form>

        </div>
        
    </div>
</template>

<style scoped>
.box{
    margin-top: 10vh;
    width: 100%;
    padding: 5em;
    height: 50vh;
}
</style>

<script>

export default {
    data() {
        return {
            email: null,
            password: null,
            message: '',
            loading: false,
        };
    },
    methods: {
       
        login(){
            this.loading = true;
            this.message = null;
            this.axios
                .post("http://localhost:8000/api/auth/login", {
                    email: this.email,
                    password: this.password
                })
                .then((response) => {
                    if (response.data.success) {
                        localStorage.setItem('TOKEN_SWT', response.data.data);
                        this.$router.push('/ingredientes');
                    }
                }).catch((error) => {
                    this.loading = false;
                    this.message = error.response.statusText;
                });
        }
    },
    created() {
        localStorage.removeItem('TOKEN_SWT');
    },
};
</script>