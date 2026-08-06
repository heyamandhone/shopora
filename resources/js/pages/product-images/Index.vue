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

import {
    Pencil,
    Trash2,
    Plus,
    Search
} from '@lucide/vue'


import {
    index,
    create,
    edit,
    destroy
} from '@/actions/App/Http/Controllers/ProductImageController'


const props = defineProps<{
    images: any
    filters: {
        product_id: string | null
    }
}>()


const search = ref(props.filters.product_id ?? '')


function doSearch() {
    router.get(
        index({ query: { product_id: search.value } }).url,
        {},
        { preserveState: true, replace: true }
    )
}


function deleteImage(id: number) {
    if (!confirm('Delete this image?')) return
    router.delete(destroy(id).url)
}

</script>

<template>
    <Head title="Product Images" />

    <div class="container mx-auto py-6">

        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-3xl font-bold">Product Images</h1>
                <p class="text-muted-foreground">Manage product images</p>
            </div>

            <Link :href="create()">
                <Button>
                    <Plus class="mr-2 h-4 w-4" /> Add Image
                </Button>
            </Link>

        </div>

        <div class="mb-6 flex gap-3">
            <div class="relative w-96">
                <Search class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
                <Input v-model="search" class="pl-10" placeholder="Filter by product id..." @keyup.enter="doSearch" />
            </div>
            <Button variant="secondary" @click="doSearch">Filter</Button>
        </div>

        <div class="rounded-lg border">
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Product</TableHead>
                        <TableHead>Image</TableHead>
                        <TableHead>Alt Text</TableHead>
                        <TableHead>Primary</TableHead>
                        <TableHead>Sort</TableHead>
                        <TableHead class="text-right">Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="img in images.data" :key="img.id">
                        <TableCell>{{ img.product?.name ?? '-' }}</TableCell>
                        <TableCell>{{ img.image }}</TableCell>
                        <TableCell>{{ img.alt_text ?? '-' }}</TableCell>
                        <TableCell>{{ img.is_primary ? 'Yes' : 'No' }}</TableCell>
                        <TableCell>{{ img.sort_order }}</TableCell>
                        <TableCell>
                            <div class="flex justify-end gap-2">
                                <Link :href="edit(img.id).url"><Button variant="outline" size="icon"><Pencil class="h-4 w-4" /></Button></Link>
                                <Button variant="destructive" size="icon" @click="deleteImage(img.id)"><Trash2 class="h-4 w-4" /></Button>
                            </div>
                        </TableCell>
                    </TableRow>

                    <TableRow v-if="images.data.length === 0">
                        <TableCell colspan="6" class="text-center py-10">No images found.</TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

    </div>
</template>
