<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';

defineProps<{
    cartItems: Array<any>;
    subtotal: number;
    cartCount: number;
}>();

function placeOrder() {
    router.post('/checkout');
}
</script>

<template>
    <Head title="Checkout" />

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
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Checkout</p>
                    <h1 class="mt-2 text-3xl font-semibold">Complete your order</h1>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_0.8fr]">
                    <div class="space-y-3">
                        <div v-for="item in cartItems" :key="item.id" class="rounded-2xl border border-white/10 p-4">
                            <p class="font-medium">{{ item.product?.name }}</p>
                            <p class="text-sm text-slate-400">Qty {{ item.quantity }} · ${{ item.price }}</p>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-white/10 p-6">
                        <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Summary</p>
                        <div class="mt-4 space-y-3 text-sm text-slate-300">
                            <div class="flex justify-between"><span>Subtotal</span><span>${{ subtotal }}</span></div>
                            <div class="flex justify-between"><span>Shipping</span><span>$5.00</span></div>
                            <div class="flex justify-between"><span>Tax</span><span>${{ (subtotal * 0.10).toFixed(2) }}</span></div>
                        </div>
                        <div class="mt-6 flex items-center justify-between border-t border-white/10 pt-4 text-lg font-semibold">
                            <span>Total</span>
                            <span>${{ (subtotal + 5 + subtotal * 0.10).toFixed(2) }}</span>
                        </div>
                        <button @click="placeOrder" class="mt-8 w-full rounded-full bg-white px-5 py-3 font-medium text-slate-900">Place order</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
