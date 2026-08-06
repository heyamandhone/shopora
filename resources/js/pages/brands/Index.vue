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
} from '@/actions/App/Http/Controllers/BrandController'


const props = defineProps<{
    brands: any,
    filters: {
        search: string
    }
}>()


const search = ref(props.filters.search ?? '')


function doSearch() {

    router.get(
        index({
            query: {
                search: search.value
            }
        }).url,
        {},
        {
            preserveState: true,
            replace: true
        }
    )

}


function deleteBrand(id: number) {

    if (!confirm('Delete this brand?')) {
        return
    }


    router.delete(
        destroy(id).url,
        {
            preserveScroll: true
        }
    )

}

</script>


<template>

    <Head title="Brands" />



        <div class="container mx-auto py-6">


            <div class="flex justify-between items-center mb-6">


                <div>

                    <h1 class="text-3xl font-bold">
                        Brands
                    </h1>

                    <p class="text-muted-foreground">
                        Manage brands
                    </p>

                </div>


                <Link :href="create()">

                    <Button>

                        <Plus class="mr-2 h-4 w-4" />

                        Add Brand

                    </Button>

                </Link>


            </div>



            <div class="mb-6 flex gap-3">


                <div class="relative w-96">

                    <Search class="absolute left-3 top-3 h-4 w-4" />


                    <Input v-model="search" class="pl-10" placeholder="Search..." @keyup.enter="doSearch" />

                </div>


                <Button variant="secondary" @click="doSearch">
                    Search
                </Button>


            </div>



            <div class="rounded-lg border">


                <Table>


                    <TableHeader>

                        <TableRow>

                            <TableHead>Name</TableHead>

                            <TableHead>Slug</TableHead>

                            <TableHead>Status</TableHead>

                            <TableHead>Sort</TableHead>

                            <TableHead class="text-right">
                                Actions
                            </TableHead>

                        </TableRow>

                    </TableHeader>



                    <TableBody>


                        <TableRow v-for="brand in brands.data" :key="brand.id">


                            <TableCell>
                                {{ brand.name }}
                            </TableCell>


                            <TableCell>
                                {{ brand.slug }}
                            </TableCell>


                            <TableCell>

                                <Badge :variant="brand.is_active ? 'default' : 'secondary'">

                                    {{ brand.is_active ? 'Active' : 'Inactive' }}

                                </Badge>

                            </TableCell>


                            <TableCell>
                                {{ brand.sort_order }}
                            </TableCell>



                            <TableCell>


                                <div class="flex justify-end gap-2">


                                    <Link :href="edit(brand.id)">

                                        <Button variant="outline" size="icon">

                                            <Pencil class="h-4 w-4" />

                                        </Button>

                                    </Link>



                                    <Button variant="destructive" size="icon" @click="deleteBrand(brand.id)">

                                        <Trash2 class="h-4 w-4" />

                                    </Button>


                                </div>


                            </TableCell>


                        </TableRow>



                        <TableRow v-if="brands.data.length === 0">

                            <TableCell colspan="5" class="text-center py-10">

                                No brands found.

                            </TableCell>

                        </TableRow>


                    </TableBody>


                </Table>


            </div>


        </div>


</template>