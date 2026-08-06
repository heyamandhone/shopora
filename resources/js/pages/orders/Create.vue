<template>
  <Head title="Create Order" />

  <div class="container mx-auto max-w-3xl py-6">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold">Create Order</h1>
      </div>
      <Link :href="index()"><Button variant="outline">Back</Button></Link>
    </div>

    <form @submit.prevent="submit" class="space-y-6 rounded-lg border p-6">
      <div>
        <Label>Customer</Label>
        <Select v-model="form.customer_id">
          <SelectTrigger><SelectValue placeholder="Select Customer" /></SelectTrigger>
          <SelectContent>
            <SelectItem v-for="c in props.customers" :key="c.id" :value="c.id">{{ c.first_name }} {{ c.last_name }}</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <div>
        <Label>Order Number</Label>
        <Input v-model="form.order_number" />
      </div>

      <div class="grid grid-cols-2 gap-4">
        <Input v-model="form.subtotal" label="Subtotal" />
        <Input v-model="form.total" label="Total" />
      </div>

      <div>
        <Label>Status</Label>
        <Select v-model="form.status">
          <SelectTrigger><SelectValue /></SelectTrigger>
          <SelectContent>
            <SelectItem value="pending">Pending</SelectItem>
            <SelectItem value="processing">Processing</SelectItem>
            <SelectItem value="shipped">Shipped</SelectItem>
            <SelectItem value="delivered">Delivered</SelectItem>
            <SelectItem value="cancelled">Cancelled</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <div class="flex justify-end gap-3">
        <Button :disabled="form.processing">Save Order</Button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { store, index } from '@/actions/App/Http/Controllers/OrderController'

const props = defineProps<{ customers: { id: number; first_name: string; last_name: string }[] }>()

const form = useForm({
  order_number: '',
  customer_id: null as number | null,
  subtotal: 0,
  discount: 0,
  tax: 0,
  shipping_charge: 0,
  total: 0,
  status: 'pending',
  payment_status: 'pending',
  notes: '',
})

function submit() { form.post(store().url) }
</script>
