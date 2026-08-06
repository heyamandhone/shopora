<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Badge } from '@/components/ui/badge'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Search, Plus, Pencil, Trash2 } from '@lucide/vue'
import { index, create, edit, destroy } from '@/actions/App/Http/Controllers/PaymentController'

const props = defineProps<{ payments: any; filters: { search: string } }>()
const search = ref(props.filters.search ?? '')

function doSearch() {
  router.get(index({ query: { search: search.value } }).url, {}, { preserveState: true, replace: true })
}

function deletePayment(id: number) {
  if (!confirm('Delete this payment?')) return
  router.delete(destroy(id).url, { preserveScroll: true })
}
</script>

<template>
  <Head title="Payments" />
  <div class="container mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-3xl font-bold">Payments</h1>
        <p class="text-muted-foreground">Manage payments</p>
      </div>
      <Link :href="create()"><Button><Plus class="mr-2 h-4 w-4" />Add Payment</Button></Link>
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
            <TableHead>Order</TableHead>
            <TableHead>Method</TableHead>
            <TableHead>Amount</TableHead>
            <TableHead>Status</TableHead>
            <TableHead class="text-right">Actions</TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="payment in payments.data" :key="payment.id">
            <TableCell>{{ payment.order?.order_number ?? '-' }}</TableCell>
            <TableCell>{{ payment.payment_method }}</TableCell>
            <TableCell>{{ payment.amount }}</TableCell>
            <TableCell><Badge :variant="payment.status === 'paid' ? 'default' : 'secondary'">{{ payment.status }}</Badge></TableCell>
            <TableCell class="text-right">
              <div class="flex justify-end gap-2">
                <Link :href="edit(payment.id).url"><Button variant="outline" size="icon"><Pencil class="h-4 w-4" /></Button></Link>
                <Button variant="destructive" size="icon" @click="deletePayment(payment.id)"><Trash2 class="h-4 w-4" /></Button>
              </div>
            </TableCell>
          </TableRow>
          <TableRow v-if="payments.data.length === 0">
            <TableCell colspan="5" class="text-center py-10">No payments found.</TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </div>
</template>
