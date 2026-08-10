<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <Link href="/" class="flex items-center gap-2">
        <div
            class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary text-lg font-bold text-primary-foreground">
            S
        </div>

        <div>
            <h1 class="text-xl font-bold tracking-tight">
                Shopora
            </h1>

            <p class="text-xs text-muted-foreground">
                Smart Shopping
            </p>
        </div>
    </Link>
</template>