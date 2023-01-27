<script>
export default {
    props:{
        recipe: {
            type: Object,
            required: false,
        }
    },
}
</script>

<template>
    <div class="view-recipe-modal">
        <div class="modal fade" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" id="view_recipe_modal" >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white bg-dark bg-gradient">
                        <h5 class="modal-title">Visualizar Receita</h5>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive" v-if="recipe">
                            <table class="table table-hover w-100">
                                <thead>
                                    <tr class="table-dark">
                                        <th colspan="2"> Código: {{recipe.id}}</th>
                                        <th colspan="2"> Receita: {{recipe.name}}</th>
                                    </tr>
                                    <tr class="table-dark">
                                        <th colspan="4">Ingredientes</th>
                                    </tr>
                                    <tr class="table-secondary">
                                        <th>Ordem</th>
                                        <th>Código</th>
                                        <th>Descrição</th>
                                        <th>Previsto em Kg</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(ingredient) in recipe.ingredients" :key="ingredient.id">
                                        <td>{{ ingredient.order }}</td>
                                        <td>{{ ingredient.id }}</td>
                                        <td>{{ ingredient.description }}</td>
                                        <td>{{ ingredient.kg }}</td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
