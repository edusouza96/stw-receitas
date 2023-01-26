<script>
export default {
    data() {
        return {
            id: null,
            description: '',
            message: '',
            typeMessage: null,
            loading: false,
        }
    },
    props:{
        ingredient: {
            type: Object,
            required: false,
        }
    },
    methods: {
        submit(){
            this.loading = true;
            this.typeMessage = null;
            this.message = null;
            if(this.id){
                var method = "put";
                var url = "http://localhost:8000/api/ingredientes/"+this.id+"/atualizar";
                
            }else{
                var method = "post";
                var url = "http://localhost:8000/api/ingredientes/salvar";
            }

            this.axios({
                method: method,
                url: url,
                data: {
                    description: this.description
                },
            })
            .then((response) => {
                if (response.data.success) {
                    this.message = response.data.message;
                    this.loading = false;
                    this.typeMessage = 'success';
                    this.$emit('stored', {
                        message: this.message, 
                        id: this.id
                    });
                    this.description = '';
                    this.id = null;
                }
            }).catch((error) => {
                this.message = error.response.data.message;
                this.loading = false;
                this.typeMessage = 'danger';
            });
        }   
    },
    watch: {
        ingredient(){
            this.typeMessage = null;
            this.message = null;
            if(this.ingredient){
                this.id = this.ingredient.id;
                this.description = this.ingredient.description;
            }
        }
    },
}
</script>

<template>
    <div class="add-ingredient-modal">
        <div class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" id="add_ingredient_modal" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-dark bg-gradient">
                        <h5 class="modal-title">Salvar Ingredientes</h5>
                    </div>
                    <div class="modal-body">
                        <div v-if="message">
                            <div :class="'alert alert-'+typeMessage" role="alert">
                                {{ message }}
                            </div>
                        </div>

                        <form v-if="!loading">
                            <label for="description">Descrição</label>
                            <input type="text" class="form-control" v-model="description">
                        </form>

                        <div v-if="loading" class="text-center">
                            <i class="fas fa-spinner fa-spin fa-5x"></i>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
