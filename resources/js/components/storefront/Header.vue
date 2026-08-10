<script setup lang="ts">
import Logo from './Logo.vue'
import SearchBar from './SearchBar.vue'
import CategoryMenu from './CategoryMenu.vue'
import CartButton from './CartButton.vue'
import UserMenu from './UserMenu.vue'
</script>

<template>
    <header class="sticky top-0 z-50 border-b bg-dark">
        <div class="container mx-auto">

            <div class="flex h-16 items-center gap-6">

                <Logo />

                <SearchBar class="flex-1" />

                <CartButton />

                <UserMenu />

            </div>

            <CategoryMenu />

        </div>
    </header>
</template>