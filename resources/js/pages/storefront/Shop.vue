<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    products: Array<any>;
    categories: Array<any>;
    filters: any;
    cartCount: number;
}>();
</script>

<template>
    <Head title="Shop" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <header class="border-b border-white/10">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
                <Link href="/" class="text-xl font-semibold">Shopora</Link>
                <nav class="flex items-center gap-4 text-sm">
                    <Link href="/shop" class="text-white">Shop</Link>
                    <Link href="/cart" class="text-slate-300 hover:text-white">Cart ({{ cartCount }})</Link>
                    <Link href="/account" class="rounded-full border border-white/10 px-3 py-1.5 hover:border-white/30">Account</Link>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-6 py-12">
            <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Storefront</p>
                    <h1 class="text-3xl font-semibold">Browse the active catalog</h1>
                </div>
                <div class="flex flex-wrap gap-3">
                    <span v-for="category in categories" :key="category.id" class="rounded-full border border-white/10 px-3 py-2 text-sm text-slate-300">
                        {{ category.name }}
                    </span>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                <article v-for="product in products.data" :key="product.id" class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <p class="text-sm text-slate-400">{{ product.category?.name || 'Product' }}</p>
                    <h2 class="mt-2 text-xl font-semibold">{{ product.name }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-400">{{ product.description }}</p>
                    <div class="mt-6 flex items-center justify-between">
                        <span class="text-lg font-semibold">${{ product.price }}</span>
                        <Link :href="`/products/${product.slug}`" class="rounded-full border border-white/10 px-3 py-2 text-sm hover:border-white/30">View</Link>
                    </div>
                </article>
            </div>
        </main>
    </div>
</template>
