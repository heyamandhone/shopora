<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const categories = page.props.categories ?? []
</script>

<template>
    <nav class="flex h-12 items-center gap-6 overflow-x-auto border-t">
        <Link href="/shop" class="font-medium hover:text-primary">
            All Products
        </Link>

        <Link v-for="category in categories" :key="category.id" :href="`/shop?category=${category.slug}`"
            class="whitespace-nowrap hover:text-primary">
            {{ category.name }}
        </Link>
    </nav>
</template>