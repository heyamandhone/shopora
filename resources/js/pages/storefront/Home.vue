<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Header from '@/components/storefront/Header.vue'
import Hero from '@/components/storefront/Hero.vue'

defineProps<{
    featuredProducts: Array<any>;
    categories: Array<any>;
    cartCount: number;
}>();
</script>

<template>
    <Head title="Shopora" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <Header />

        <main class="mx-auto max-w-7xl px-6 py-16">
            <Hero />
            <section class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                <div>
                    <p class="mb-4 inline-flex rounded-full border border-emerald-400/30 bg-emerald-500/10 px-3 py-1 text-sm text-emerald-300">
                        Lightweight commerce flow
                    </p>
                    <h1 class="text-4xl font-semibold tracking-tight sm:text-6xl">
                        Showcase a real customer journey without overbuilding the storefront.
                    </h1>
                    <p class="mt-6 max-w-2xl text-lg text-slate-400">
                        Browse products, add them to a cart, complete a checkout, and keep the resulting order visible to the admin panel.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <Link href="/shop" class="rounded-full bg-white px-5 py-3 font-medium text-slate-900">Explore products</Link>
                        <Link href="/cart" class="rounded-full border border-white/10 px-5 py-3 font-medium text-slate-100">View cart</Link>
                    </div>
                </div>

                <div class="rounded-3xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/20">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Included modules</p>
                    <ul class="mt-6 space-y-3 text-sm text-slate-300">
                        <li>• Sign in or register with the existing auth flow</li>
                        <li>• Browse featured products and category pages</li>
                        <li>• Cart and checkout with order/payment creation</li>
                        <li>• Account area showing completed orders</li>
                    </ul>
                </div>
            </section>

            <section class="mt-16">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Featured products</p>
                        <h2 class="text-2xl font-semibold">A curated set of active products</h2>
                    </div>
                    <Link href="/shop" class="text-sm text-slate-300 hover:text-white">Browse all</Link>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <article v-for="product in featuredProducts" :key="product.id" class="rounded-2xl border border-white/10 bg-white/5 p-6">
                        <p class="text-sm text-slate-400">{{ product.category?.name || 'Product' }}</p>
                        <h3 class="mt-2 text-xl font-semibold">{{ product.name }}</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-400">{{ product.description }}</p>
                        <div class="mt-6 flex items-center justify-between">
                            <span class="text-lg font-semibold">${{ product.price }}</span>
                            <Link :href="`/products/${product.slug}`" class="rounded-full border border-white/10 px-3 py-2 text-sm hover:border-white/30">View</Link>
                        </div>
                    </article>
                </div>
            </section>

            <section class="mt-16 rounded-3xl border border-white/10 bg-white/5 p-8">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Categories</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <span v-for="category in categories" :key="category.id" class="rounded-full border border-white/10 px-3 py-2 text-sm text-slate-300">
                        {{ category.name }}
                    </span>
                </div>
            </section>
        </main>
    </div>
</template>
