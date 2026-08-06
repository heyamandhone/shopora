<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

defineProps<{
    cartItems: Array<any>;
    subtotal: number;
    cartCount: number;
}>();

function removeItem(itemId: number) {
    router.post(`/cart/remove/${itemId}`);
}
</script>

<template>
    <Head title="Cart" />

    <div class="min-h-screen bg-slate-950 text-slate-100">
        <header class="border-b border-white/10">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-5">
                <Link href="/" class="text-xl font-semibold">Shopora</Link>
                <nav class="flex items-center gap-4 text-sm">
                    <Link href="/shop" class="text-slate-300 hover:text-white">Shop</Link>
                    <Link href="/cart" class="text-white">Cart ({{ cartCount }})</Link>
                    <Link href="/account" class="rounded-full border border-white/10 px-3 py-1.5 hover:border-white/30">Account</Link>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-5xl px-6 py-16">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Cart</p>
                        <h1 class="mt-2 text-3xl font-semibold">Your selected items</h1>
                    </div>
                    <Link href="/checkout" class="rounded-full bg-white px-5 py-3 font-medium text-slate-900">Checkout</Link>
                </div>

                <div v-if="cartItems.length" class="mt-8 space-y-4">
                    <div v-for="item in cartItems" :key="item.id" class="flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-white/10 p-4">
                        <div>
                            <p class="font-medium">{{ item.product?.name }}</p>
                            <p class="text-sm text-slate-400">Qty {{ item.quantity }} · ${{ item.price }}</p>
                        </div>
                        <button @click="removeItem(item.id)" class="rounded-full border border-white/10 px-3 py-2 text-sm hover:border-white/30">Remove</button>
                    </div>
                </div>

                <div v-else class="mt-8 rounded-2xl border border-dashed border-white/10 p-8 text-center text-slate-400">
                    Your cart is empty. Add a product to begin the checkout flow.
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-white/10 pt-6">
                    <p class="text-slate-400">Subtotal</p>
                    <p class="text-2xl font-semibold">${{ subtotal }}</p>
                </div>
            </div>
        </main>
    </div>
</template>
