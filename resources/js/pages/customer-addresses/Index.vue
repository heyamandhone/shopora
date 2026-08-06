<template>
    <Head title="Customer Addresses" />

    <div class="container mx-auto py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">Customer Addresses</h1>
                <p class="text-muted-foreground">Manage customer addresses</p>
            </div>
            <Link :href="create()">
                <Button>
                    Add Address
                </Button>
            </Link>
        </div>

        <div class="mb-6 flex gap-3">
            <div class="relative w-96">
                <Search class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
                <Input v-model="search" class="pl-10" placeholder="Search..." @keyup.enter="doSearch" />
            </div>
            <Button variant="secondary" @click="doSearch">Search</Button>
        </div>

        <div class="rounded-lg border">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Label</TableHead>
                        <TableHead>Customer</TableHead>
                        <TableHead>Phone</TableHead>
                        <TableHead>City</TableHead>
                        <TableHead>Country</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="address in addresses.data" :key="address.id">
                        <TableCell>{{ address.label }}</TableCell>
                        <TableCell>{{ address.customer?.first_name }} {{ address.customer?.last_name }}</TableCell>
                        <TableCell>{{ address.phone }}</TableCell>
                        <TableCell>{{ address.city }}</TableCell>
                        <TableCell>{{ address.country }}</TableCell>
                        <TableCell>
                            <Badge :variant="address.is_default ? 'default' : 'secondary'">
                                {{ address.is_default ? 'Default' : 'Secondary' }}
                            </Badge>
                        </TableCell>
                        <TableCell class="text-right">
                            <div class="flex justify-end gap-2">
                                <Link :href="edit(address.id)"><Button size="sm" variant="secondary">Edit</Button></Link>
                                <Button size="sm" variant="destructive" @click="deleteAddress(address.id)">Delete</Button>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Badge } from '@/components/ui/badge'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { Search } from '@lucide/vue'
import { index, create, edit, destroy } from '@/actions/App/Http/Controllers/CustomerAddressController'

const props = defineProps<{
    addresses: any
    filters: {
        search: string
    }
}>()

const search = ref(props.filters.search ?? '')

function doSearch() {
    router.get(
        index({ query: { search: search.value } }).url,
        {},
        { preserveState: true, replace: true }
    )
}

function deleteAddress(id: number) {
    if (!confirm('Delete this address?')) return

    router.delete(destroy(id).url, { preserveScroll: true })
}
</script>
