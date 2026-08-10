<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
</script>

<template>
    <section class="rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 px-8 py-20 text-white">
        <div class="max-w-2xl">
            <p class="mb-3 text-primary font-semibold uppercase tracking-widest">
                Welcome to Shopora
            </p>

            <h1 class="text-5xl font-bold leading-tight">
                Discover Products You'll Love
            </h1>

            <p class="mt-6 text-lg text-slate-300">
                Shop thousands of products with fast delivery and secure checkout.
            </p>

            <div class="mt-8 flex gap-4">
                <Link href="/shop">
                    <Button size="lg">
                        Shop Now
                    </Button>
                </Link>

                <Link href="/shop">
                    <Button size="lg" variant="secondary">
                        Explore
                    </Button>
                </Link>
            </div>
        </div>
    </section>
</template>