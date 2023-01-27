<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <div>
        <header>
            <div class="wrapper">
                <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">STW</a>
                        <button
                            class="navbar-toggler"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarNavAltMarkup"
                            aria-controls="navbarNavAltMarkup"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                        >
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div
                            class="collapse navbar-collapse"
                            id="navbarNavAltMarkup"
                        >
                            <div class="navbar-nav">
                                <RouterLink class="nav-link" to="/receitas">Receitas</RouterLink>
                                <RouterLink class="nav-link" to="/ingredientes">Ingredientes</RouterLink>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <main class="">
            <RouterView />
        </main>
    </div>
</template>
