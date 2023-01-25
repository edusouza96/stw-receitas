<template>
    <div class="ingredients">
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="ingredient in ingredients" :key="ingredient.id">
                        <td>{{ ingredient.id }}</td>
                        <td>{{ ingredient.description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style>
@media (min-width: 1024px) {
    .ingredients {
        min-height: 100vh;
        display: flex;
        align-items: center;
    }
}
</style>
<script>
export default {
    data() {
        return {
            ingredients: [],
        };
    },
    created() {
        this.axios
            .get("http://localhost:8000/api/ingredientes")
            .then((response) => {
                if (response.data.success) {
                    this.ingredients = response.data.data;
                }
            });
    },
};
</script>