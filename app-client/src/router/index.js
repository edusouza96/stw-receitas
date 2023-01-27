import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: () => import('../views/Login.vue')
    },
    {
      path: '/receitas',
      name: 'receitas',
      component: () => import('../views/Recipes.vue')
    },
    {
      path: '/ingredientes',
      name: 'ingredient',
      component: () => import('../views/Ingredients.vue')
    },
  ]
})

export default router
