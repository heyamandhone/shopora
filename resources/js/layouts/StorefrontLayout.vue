<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import Header from '@/components/storefront/Header.vue'

import type { BreadcrumbItem } from '@/types';

const { breadcrumbs = [] } = defineProps<{
    breadcrumbs?: BreadcrumbItem[];
}>();
</script>

<template>
    <div class="min-h-screen bg-background">
        

        <main>
            <slot />
        </main>
    </div>
</template>
