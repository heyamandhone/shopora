<template>
  <Head title="Orders" />

  <div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-3xl font-bold">Orders</h1>
        <p class="text-muted-foreground">Manage orders</p>
      </div>
      <Link :href="create()">
        <Button>
          Add Order
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
            <TableHead>Order #</TableHead>
            <TableHead>Customer</TableHead>
            <TableHead>Total</TableHead>
            <TableHead>Status</TableHead>
            <TableHead>Payment</TableHead>
            <TableHead class="text-right">Actions</TableHead>
          </TableRow>
        </TableHeader>

        <TableBody>
          <TableRow v-for="order in orders.data" :key="order.id">
            <TableCell>{{ order.order_number }}</TableCell>
            <TableCell>{{ order.customer?.first_name }} {{ order.customer?.last_name }}</TableCell>
            <TableCell>{{ order.total }}</TableCell>
            <TableCell><Badge :variant="order.status === 'pending' ? 'secondary' : 'default'">{{ order.status }}</Badge></TableCell>
            <TableCell>{{ order.payment_status }}</TableCell>
            <TableCell class="text-right">
              <div class="flex justify-end gap-2">
                <Link :href="edit(order.id)"><Button size="sm" variant="secondary">Edit</Button></Link>
                <Button size="sm" variant="destructive" @click="deleteOrder(order.id)">Delete</Button>
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
import { index, create, edit, destroy } from '@/actions/App/Http/Controllers/OrderController'

const props = defineProps<{
  orders: any
  filters: { search: string }
}>()

const search = ref(props.filters.search ?? '')

function doSearch() {
  router.get(index({ query: { search: search.value } }).url, {}, { preserveState: true, replace: true })
}

function deleteOrder(id: number) {
  if (!confirm('Delete this order?')) return
  router.delete(destroy(id).url, { preserveScroll: true })
}
</script>
