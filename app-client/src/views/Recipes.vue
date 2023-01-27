<template>
    <div class="recipes container">
        <div class="row">
            <div class="col-12 text-end my-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_recipe_modal">
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
                            <th>Receita</th>
                            <th class="col-2" colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="recipe in recipes" :key="recipe.id">
                            <td>{{ recipe.id }}</td>
                            <td>{{ recipe.name }}</td>
                            <td>
                                <button class="btn btn-dark" type="button" @click="this.recipe = recipe" data-bs-toggle="modal" data-bs-target="#view_recipe_modal" >
                                    <i class="fas fa-eye"></i> 
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-primary" type="button" @click="this.recipe = recipe" data-bs-toggle="modal" data-bs-target="#add_recipe_modal" >
                                    <i class="fas fa-pencil"></i> 
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-danger" type="button" @click="remove(recipe)">
                                    <i class="fas fa-trash"></i> 
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    
        <SaveRecipe :recipe="recipe" @stored="updated"/>
        <ViewRecipe :recipe="recipe"/>
    </div>
</template>

<script>
import SaveRecipe from '../components/SaveRecipe.vue';
import ViewRecipe from '../components/ViewRecipe.vue';
export default {
    data() {
        return {
            recipes: [],
            message: '',
            typeMessage: null,
            loading: false,
            recipe: null
        };
    },
    methods: {
        remove(recipe){
            this.loading = true;
            this.typeMessage = null;
            this.message = null;
            this.axios
                .delete("http://localhost:8000/api/receitas/"+recipe.id+"/remover")
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

            this.recipe = null;
            this.message = data.message;
            this.typeMessage = 'success';
            var modalElement = document.getElementById('add_recipe_modal');
            var modal = bootstrap.Modal.getInstance(modalElement)
            modal.hide();

        },
        get(){
            this.axios
                .get("http://localhost:8000/api/receitas")
                .then((response) => {
                    if (response.data.success) {
                        this.recipes = response.data.data;
                    }
                });
        }
    },
    created() {
        this.get();
    },
    components: {
        SaveRecipe, ViewRecipe
    }
};
</script>