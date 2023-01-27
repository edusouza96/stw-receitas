<template>
    <div class="mt-4 select-ingredients">
        <fieldset>
            <legend>Selecione os Ingredientes</legend>
            <hr>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Ingredientes</label>
                            <select class="form-select" v-model="ingredient">
                                <option value="">Selecione</option>
                                <option v-for="item in ingredients" :key="item.id" :value="item">{{ item.description }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Previsto em Kg</label>
                            <input type="number" class="form-control" v-model="kg">
                        </div>
                    </div>
                </div>
                
                <div class="row my-3">
                    <div class="col-12 text-end">
                        <div class="form-group">
                            <button class="btn btn-dark" type="button" @click="add">
                                Adicionar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover w-100">
                        <thead class="table-dark">
                            <tr>
                                <th>Ordem</th>
                                <th>Descrição</th>
                                <th>Previsto em Kg</th>
                                <th colspan="3" class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="ingredient in selectedIngredients" :key="ingredient.order">
                                <td>{{ ingredient.order }}</td>
                                <td>{{ ingredient.description }}</td>
                                <td>{{ ingredient.kg }}</td>
                                <td>
                                    <button class="btn btn-light" type="button" @click="orderUp(ingredient.order)">
                                        <i class="fas fa-arrow-up"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-light" type="button" @click="orderDown(ingredient.order)">
                                        <i class="fas fa-arrow-down"></i>
                                    </button>
                                </td>
                                
                                <td>
                                    <button class="btn btn-danger" type="button" @click="remove(ingredient.order)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </fieldset>
        
    </div>
</template>

<script>
export default {
    props:{
        value:{
            required: false
        }
    },
    data() {
        return {
            ingredients: [],
            selectedIngredients: [],
            ingredient: '',
            kg: null,
        };
    },
    methods: {
        remove(order){
            this.selectedIngredients = this.selectedIngredients.filter(function(item){
                if(item.order < order){
                    return item;
                }else if(item.order > order){
                    item.order--;
                    return item;
                }
            });

            this.selectedIngredients.sort((a, b) => a.order - b.order);
            this.updated();
        },
        orderUp(order){
            if(this.selectedIngredients.length == 1) return false;
            if(order == 1) return false;

            this.selectedIngredients.map(function(item){
                if(item.order == (order-1)){
                    item.order++;
                }else if(item.order == order){
                    item.order--;
                }
            });

            this.selectedIngredients.sort((a, b) => a.order - b.order);
            this.updated();
        },
        orderDown(order){
            if(this.selectedIngredients.length == 1) return false;
            if(order == this.selectedIngredients[this.selectedIngredients.length-1].order) return false;

            this.selectedIngredients.map(function(item){
                if(item.order == (order+1)){
                    item.order--;
                }else if(item.order == order){
                    item.order++;
                }
            });

            this.selectedIngredients.sort((a, b) => a.order - b.order);
            this.updated();
        },
        add(){
            if(!this.ingredient || !this.kg) return false;

            this.selectedIngredients.push({
                order: this.nextOrder,
                id: this.ingredient.id,
                description: this.ingredient.description,
                kg: this.kg
            });

            this.ingredient = '';
            this.kg = null;
            this.updated();
        },
        updated(){
            this.$emit('updated', this.selectedIngredients);
        },
        get(){
            this.axios
                .get("http://localhost:8000/api/ingredientes")
                .then((response) => {
                    if (response.data.success) {
                        this.ingredients = response.data.data;
                    }
                });
        }
    },
    computed:{
        nextOrder(){
            return this.selectedIngredients.length + 1;
        },
    },
    watch: {
        value(){
            this.selectedIngredients = this.value;
        }
    },
    created() {
        this.get();
    },
};
</script>