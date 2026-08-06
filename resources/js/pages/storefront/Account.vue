<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

defineProps<{
    user: any;
    customer: any;
    orders: Array<any>;
    cartCount: number;
}>();
</script>

<template>
    <Head title="Account" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <header class="border-b border-white/10">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
                <Link href="/" class="text-xl font-semibold">Shopora</Link>
                <nav class="flex items-center gap-4 text-sm">
                    <Link href="/shop" class="text-slate-300 hover:text-white">Shop</Link>
                    <Link href="/cart" class="text-slate-300 hover:text-white">Cart ({{ cartCount }})</Link>
                    <Link href="/account" class="text-white">Account</Link>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-6 py-16">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">My account</p>
                        <h1 class="mt-2 text-3xl font-semibold">{{ user?.name || customer?.full_name || 'Customer' }}</h1>
                    </div>
                    <Link href="/logout" class="rounded-full border border-white/10 px-4 py-2 text-sm hover:border-white/30">Log out</Link>
                </div>

                <div class="mt-8 rounded-2xl border border-white/10 p-6">
                    <h2 class="text-xl font-semibold">Recent orders</h2>
                    <div v-if="orders.length" class="mt-6 space-y-4">
                        <div v-for="order in orders" :key="order.id" class="rounded-2xl border border-white/10 p-4">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div>
                                    <p class="font-medium">{{ order.order_number }}</p>
                                    <p class="text-sm text-slate-400">Status: {{ order.status }}</p>
                                </div>
                                <p class="text-lg font-semibold">${{ order.total }}</p>
                            </div>
                            <div class="mt-3 text-sm text-slate-400">
                                <span v-for="item in order.items" :key="item.id">{{ item.product?.name }} x{{ item.quantity }} </span>
                            </div>
                        </div>
                    </div>
                    <div v-else class="mt-6 rounded-2xl border border-dashed border-white/10 p-8 text-center text-slate-400">
                        No orders yet. Complete a checkout to see your first order here.
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
