<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { Search } from '@lucide/vue'
import { Input } from '@/components/ui/input'

const search = ref('')

function submit() {
    router.get('/shop', {
        search: search.value,
    })
}
</script>

<template>
    <form @submit.prevent="submit" class="relative w-full">
        <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />

        <Input v-model="search" class="pl-10" placeholder="Search products..." />
    </form>
</template>