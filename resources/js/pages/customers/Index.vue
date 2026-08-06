<template>
  <div>
    <Head title="Customers" />

    <div class="container mx-auto py-6">
      <div class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-3xl font-bold">Customers</h1>
          <p class="text-muted-foreground">Manage customers</p>
        </div>

        <Link :href="create()">
          <Button>
            <Plus class="mr-2 h-4 w-4" />
            Add Customer
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
              <TableHead>Name</TableHead>
              <TableHead>Email</TableHead>
              <TableHead>Phone</TableHead>
              <TableHead>Status</TableHead>
              <TableHead class="text-right">Actions</TableHead>
            </TableRow>
          </TableHeader>

          <TableBody>
            <TableRow v-for="customer in customers.data" :key="customer.id">
              <TableCell>{{ customer.first_name }} {{ customer.last_name }}</TableCell>
              <TableCell>{{ customer.email }}</TableCell>
              <TableCell>{{ customer.phone ?? '-' }}</TableCell>
              <TableCell>
                <Badge :variant="customer.is_active ? 'default' : 'secondary'">
                  {{ customer.is_active ? 'Active' : 'Inactive' }}
                </Badge>
              </TableCell>
              <TableCell class="text-right">
                <div class="flex items-center justify-end gap-2">
                  <Link :href="edit(customer.id)">
                    <Button size="sm" variant="secondary">Edit</Button>
                  </Link>
                  <Button size="sm" variant="destructive" @click="deleteCustomer(customer.id)">Delete</Button>
                </div>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
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
import { Pencil, Trash2, Plus, Search } from '@lucide/vue'
import { index, create, edit, destroy } from '@/actions/App/Http/Controllers/CustomerController'

const props = defineProps<{
  customers: any
  filters: {
    search: string
  }
}>()

const search = ref(props.filters.search ?? '')

function doSearch() {
  router.get(
    index({
      query: {
        search: search.value,
      },
    }).url,
    {},
    {
      preserveState: true,
      replace: true,
    }
  )
}

function deleteCustomer(id: number) {
  if (!confirm('Delete this customer?')) {
    return
  }

  router.delete(destroy(id).url, {
    preserveScroll: true,
  })
}
</script>
