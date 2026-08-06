<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
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
} from '@/actions/App/Http/Controllers/CategoryController'


const props = defineProps<{
    categories: any
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


function deleteCategory(id: number) {

    if (!confirm('Delete this category?')) {
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

    <Head title="Categories" />

        <div class="container mx-auto py-6">


            <div class="flex justify-between items-center mb-6">

                <div>

                    <h1 class="text-3xl font-bold">
                        Categories
                    </h1>

                    <p class="text-muted-foreground">
                        Manage categories
                    </p>

                </div>


                <Link :href="create()">

                    <Button>

                        <Plus class="mr-2 h-4 w-4" />

                        Add Category

                    </Button>

                </Link>


            </div>



            <div class="mb-6 flex gap-3">


                <div class="relative w-96">

                    <Search class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />


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

                            <TableHead>Parent</TableHead>

                            <TableHead>Status</TableHead>

                            <TableHead>Sort</TableHead>

                            <TableHead class="text-right">
                                Actions
                            </TableHead>

                        </TableRow>

                    </TableHeader>



                    <TableBody>


                        <TableRow v-for="category in categories.data" :key="category.id">


                            <TableCell>
                                {{ category.name }}
                            </TableCell>


                            <TableCell>
                                {{ category.slug }}
                            </TableCell>


                            <TableCell>
                                {{ category.parent?.name ?? '-' }}
                            </TableCell>


                            <TableCell>

                                <Badge :variant="category.is_active ? 'default' : 'secondary'">

                                    {{ category.is_active ? 'Active' : 'Inactive' }}

                                </Badge>

                            </TableCell>


                            <TableCell>
                                {{ category.sort_order }}
                            </TableCell>



                            <TableCell>


                                <div class="flex justify-end gap-2">


                                    <Link :href="edit(category.id).url">

                                        <Button variant="outline" size="icon">

                                            <Pencil class="h-4 w-4" />

                                        </Button>

                                    </Link>



                                    <Button variant="destructive" size="icon" @click="deleteCategory(category.id)">

                                        <Trash2 class="h-4 w-4" />

                                    </Button>


                                </div>


                            </TableCell>


                        </TableRow>



                        <TableRow v-if="categories.data.length === 0">

                            <TableCell colspan="6" class="text-center py-10">

                                No categories found.

                            </TableCell>

                        </TableRow>


                    </TableBody>


                </Table>


            </div>


        </div>

</template>