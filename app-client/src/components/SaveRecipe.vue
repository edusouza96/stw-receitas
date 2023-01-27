<template>
    <div class="add-recipe-modal">
        <div class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" id="add_recipe_modal" >
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-dark bg-gradient">
                        <h5 class="modal-title">Salvar Receita</h5>
                    </div>
                    <div class="modal-body">
                        <div v-if="message">
                            <div :class="'alert alert-'+typeMessage" role="alert">
                                {{ message }}
                            </div>
                        </div>

                        <form v-if="!loading">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nome da receita</label>
                                        <input type="text" class="form-control" v-model="name">
                                    </div>
                                </div>
                            </div>
                            
                            <SelectIngredients @updated="updated" :value="selectedIngredients"/>
                        
                        </form>

                        <div v-if="loading" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-5x"></i>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="clear" data-bs-dismiss="modal">
                            Fechar
                        </button>
                        <button type="button" class="btn btn-primary" @click="submit">
                            Salvar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SelectIngredients from '../components/SelectIngredients.vue';
export default {
    data() {
        return {
            id: null,
            name: '',
            message: '',
            typeMessage: null,
            loading: false,
            selectedIngredients: [],
            token: null,
        }
    },
    props:{
        recipe: {
            type: Object,
            required: false,
        }
    },
    methods: {
        updated(selectedIngredients) {
            this.selectedIngredients = selectedIngredients;
        },
        clear(){
            this.typeMessage = null;
            this.message = null;
            this.name = '';
            this.id = null;
            this.selectedIngredients = null;
        },
        submit(){
            this.loading = true;
            this.typeMessage = null;
            this.message = null;
            if(this.id){
                var method = "put";
                var url = "http://localhost:8000/api/receitas/"+this.id+"/atualizar";
                
            }else{
                var method = "post";
                var url = "http://localhost:8000/api/receitas/salvar";
            }

            this.axios({
                method: method,
                url: url,
                data: {
                    name: this.name,
                    ingredients: this.selectedIngredients,
                },
                headers: {
                    'Authorization': 'Bearer '+this.token
                }
            })
            .then((response) => {
                if (response.data.success) {
                    this.loading = false;
                    this.$emit('stored', {
                        message:  response.data.message
                    });
                    this.clear();
                }
            }).catch((error) => {
                this.message = error.response.data.message;
                this.loading = false;
                this.typeMessage = 'danger';
            });
        }   
    },
    watch: {
        recipe(){
            this.typeMessage = null;
            this.message = null;
            if(this.recipe){
                this.id = this.recipe.id;
                this.name = this.recipe.name;
                this.selectedIngredients = this.recipe.ingredients;
            }
        }
    },
    created() {
        this.token = localStorage.getItem('TOKEN_SWT');
        if(!this.token){
            this.$router.push('/');
        }
    },
    components:{
        SelectIngredients
    }
}
</script>