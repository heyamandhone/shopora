<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Search, Plus, Pencil, Trash2 } from '@lucide/vue'
import { index, create, edit, destroy } from '@/actions/App/Http/Controllers/WishlistController'

const props = defineProps<{ items: any; filters: { search: string } }>()
const search = ref(props.filters.search ?? '')

function doSearch() {
  router.get(index({ query: { search: search.value } }).url, {}, { preserveState: true, replace: true })
}

function deleteItem(id: number) {
  if (!confirm('Delete this wishlist item?')) return
  router.delete(destroy(id).url, { preserveScroll: true })
}
</script>

<template>
  <Head title="Wishlist" />
  <div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-3xl font-bold">Wishlist</h1>
        <p class="text-muted-foreground">Manage wishlist items</p>
      </div>
      <Link :href="create()"><Button><Plus class="mr-2 h-4 w-4" />Add Item</Button></Link>
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
            <TableHead>Customer</TableHead>
            <TableHead>Product</TableHead>
            <TableHead>Notes</TableHead>
            <TableHead class="text-right">Actions</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="item in items.data" :key="item.id">
            <TableCell>{{ item.customer?.first_name }} {{ item.customer?.last_name }}</TableCell>
            <TableCell>{{ item.product?.name ?? '-' }}</TableCell>
            <TableCell>{{ item.notes }}</TableCell>
            <TableCell class="text-right">
              <div class="flex justify-end gap-2">
                <Link :href="edit(item.id).url"><Button variant="outline" size="icon"><Pencil class="h-4 w-4" /></Button></Link>
                <Button variant="destructive" size="icon" @click="deleteItem(item.id)"><Trash2 class="h-4 w-4" /></Button>
              </div>
            </TableCell>
          </TableRow>
          <TableRow v-if="items.data.length === 0">
            <TableCell colspan="4" class="text-center py-10">No wishlist items found.</TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </div>
</template>
