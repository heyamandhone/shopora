<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { ShoppingCart } from '@lucide/vue'

const page = usePage()

const count = page.props.cartCount ?? 0
</script>

<template>
    <Link href="/cart" class="relative">
        <ShoppingCart class="h-6 w-6" />

        <span v-if="count"
            class="absolute -right-2 -top-2 flex h-5 w-5 items-center justify-center rounded-full bg-primary text-xs text-white">
            {{ count }}
        </span>
    </Link>
</template>