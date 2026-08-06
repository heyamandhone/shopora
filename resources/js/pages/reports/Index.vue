<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import { Badge } from '@/components/ui/badge'

const props = defineProps<{ stats: any; recent_orders: any[] }>()
</script>

<template>
  <Head title="Reports" />
  <div class="container mx-auto py-6 space-y-6">
    <div>
      <h1 class="text-3xl font-bold">Reports</h1>
      <p class="text-muted-foreground">Overview of store performance</p>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
      <div class="rounded-lg border p-4">
        <p class="text-sm text-muted-foreground">Orders</p>
        <p class="text-2xl font-semibold">{{ props.stats.orders }}</p>
      </div>
      <div class="rounded-lg border p-4">
        <p class="text-sm text-muted-foreground">Customers</p>
        <p class="text-2xl font-semibold">{{ props.stats.customers }}</p>
      </div>
      <div class="rounded-lg border p-4">
        <p class="text-sm text-muted-foreground">Products</p>
        <p class="text-2xl font-semibold">{{ props.stats.products }}</p>
      </div>
      <div class="rounded-lg border p-4">
        <p class="text-sm text-muted-foreground">Revenue</p>
        <p class="text-2xl font-semibold">{{ props.stats.revenue }}</p>
      </div>
    </div>

    <div class="rounded-lg border p-4">
      <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
      <div class="space-y-2">
        <div v-for="order in props.recent_orders" :key="order.id" class="flex items-center justify-between rounded-md border p-3">
          <div>
            <p class="font-medium">{{ order.order_number }}</p>
            <p class="text-sm text-muted-foreground">{{ order.customer?.first_name }} {{ order.customer?.last_name }}</p>
          </div>
          <Badge>{{ order.status }}</Badge>
        </div>
      </div>
    </div>
  </div>
</template>
