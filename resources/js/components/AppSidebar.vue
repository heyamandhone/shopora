<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, FolderGit2, LayoutGrid, FolderTree } from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Categories',
        href: '/categories',
        icon: FolderTree,
    },
    {
        title: 'Products',
        href: '/products',
        icon: FolderGit2,
    },
    {
        title: 'Customers',
        href: '/customers',
        icon: FolderTree,
    },
    {
        title: 'Customer Addresses',
        href: '/customer-addresses',
        icon: FolderTree,
    },
    {
        title: 'Product Images',
        href: '/product-images',
        icon: FolderTree,
    },
    {
        title: 'Orders',
        href: '/orders',
        icon: FolderGit2,
    },
    {
        title: 'Order Items',
        href: '/order-items',
        icon: FolderTree,
    },
    {
        title: 'Brands',
        href: '/brands',
        icon: FolderGit2,
    },
    {
        title: 'Cart',
        href: '/carts',
        icon: FolderTree,
    },
    {
        title: 'Wishlist',
        href: '/wishlists',
        icon: FolderTree,
    },
    {
        title: 'Coupons',
        href: '/coupons',
        icon: FolderTree,
    },
    {
        title: 'Payments',
        href: '/payments',
        icon: FolderGit2,
    },
    {
        title: 'Reviews',
        href: '/reviews',
        icon: FolderTree,
    },
    {
        title: 'Reports',
        href: '/reports',
        icon: FolderGit2,
    },
];

/* const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
]; */
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
