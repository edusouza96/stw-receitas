<template>
    <div class="ingredients container">
        <div class="row">
            <div class="col-12 text-end my-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_ingredient_modal">
                    Adicionar
                </button>
            </div>
        </div>
        <div :class="'alert alert-'+typeMessage" role="alert">
            <div v-if="loading" class="text-center">
                <i class="fas fa-spinner fa-spin fa-3x"></i>
            </div>
            {{ message }}
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="table table-striped table-hover w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Código</th>
                            <th>Descrição</th>
                            <th class="col-1" colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="ingredient in ingredients" :key="ingredient.id">
                            <td>{{ ingredient.id }}</td>
                            <td>{{ ingredient.description }}</td>
                            <td>
                                <button class="btn btn-primary" type="button" @click="this.ingredient = ingredient" data-bs-toggle="modal" data-bs-target="#add_ingredient_modal" >
                                    <i class="fas fa-pencil"></i> 
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-danger" type="button" @click="remove(ingredient)">
                                    <i class="fas fa-trash"></i> 
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    
        <SaveIngredient :ingredient="ingredient" @stored="updated"/>
    </div>
</template>

<script>
import SaveIngredient from '../components/SaveIngredient.vue'
export default {
    data() {
        return {
            ingredients: [],
            message: '',
            typeMessage: null,
            loading: false,
            ingredient: null,
            token: null,
        };
    },
    methods: {
        remove(ingredient){
            this.loading = true;
            this.typeMessage = null;
            this.message = null;
            this.axios
                .delete("http://localhost:8000/api/ingredientes/"+ingredient.id+"/remover", {
                    headers: {
                        'Authorization': 'Bearer '+this.token
                    }
                })
                .then((response) => {
                    if (response.data.success) {
                        this.message = response.data.message;
                        this.loading = false;
                        this.typeMessage = 'success';
                        this.get();
                    }
                }).catch((error) => {
                    this.message = error.response.data.message;
                    this.loading = false;
                    this.typeMessage = 'danger';
                });

        },
        updated(data){
            this.get();

            if(data.id){
                this.ingredient = null;
                this.message = data.message;
                this.typeMessage = 'success';
                var modalElement = document.getElementById('add_ingredient_modal');
                var modal = bootstrap.Modal.getInstance(modalElement)
                modal.hide();
            }

        },
        get(){
            this.axios
                .get("http://localhost:8000/api/ingredientes", {
                    headers: {
                        'Authorization': 'Bearer '+this.token
                    }
                })
                .then((response) => {
                    if (response.data.success) {
                        this.ingredients = response.data.data;
                    }
                });
        }
    },
    created() {
        this.token = localStorage.getItem('TOKEN_SWT');
        if(!this.token){
            this.$router.push('/');
        }
        this.get();
    },
    components: {
        SaveIngredient
    }
};
</script>