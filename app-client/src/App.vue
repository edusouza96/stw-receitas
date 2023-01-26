<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div>

    <header>
      <div class="wrapper">
        <nav>
          <RouterLink to="/">About</RouterLink>
          <RouterLink to="/ingredientes">Ingredientes</RouterLink>
        </nav>
      </div>
    </header>

    <main class="">
      <RouterView />
    </main>
  </div>
</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}


nav {
  width: 100%;
  font-size: 12px;
  text-align: center;
  margin-top: 2rem;
}

nav a.router-link-exact-active {
  color: var(--color-text);
}

nav a.router-link-exact-active:hover {
  background-color: transparent;
}

nav a {
  display: inline-block;
  padding: 0 1rem;
  border-left: 1px solid var(--color-border);
}

</style>
