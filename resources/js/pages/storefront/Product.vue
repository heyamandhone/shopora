<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps<{
    product: any;
    cartCount: number;
}>();

function addToCart() {
    router.post(`/cart/add/${props.product.id}`, { quantity: 1 }, { preserveScroll: true });
}
</script>

<template>
    <Head :title="product.name" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <header class="border-b border-white/10">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
                <Link href="/" class="text-xl font-semibold">Shopora</Link>
                <nav class="flex items-center gap-4 text-sm">
                    <Link href="/shop" class="text-slate-300 hover:text-white">Shop</Link>
                    <Link href="/cart" class="text-slate-300 hover:text-white">Cart ({{ cartCount }})</Link>
                    <Link href="/account" class="rounded-full border border-white/10 px-3 py-1.5 hover:border-white/30">Account</Link>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-6 py-16">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">{{ product.category?.name || 'Product' }}</p>
                        <h1 class="mt-2 text-3xl font-semibold">{{ product.name }}</h1>
                    </div>
                    <div class="rounded-full border border-emerald-400/30 bg-emerald-500/10 px-3 py-1 text-sm text-emerald-300">
                        In stock · {{ product.stock }} available
                    </div>
                </div>

                <p class="mt-8 max-w-3xl text-lg leading-8 text-slate-300">{{ product.description }}</p>

                <div class="mt-8 flex flex-wrap items-center justify-between gap-4 border-t border-white/10 pt-6">
                    <div>
                        <p class="text-sm text-slate-400">Price</p>
                        <p class="text-3xl font-semibold">${{ product.price }}</p>
                    </div>
                    <div class="flex gap-3">
                        <button @click="addToCart" class="rounded-full bg-white px-5 py-3 font-medium text-slate-900">Add to cart</button>
                        <Link href="/cart" class="rounded-full border border-white/10 px-5 py-3 font-medium text-slate-100">View cart</Link>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
