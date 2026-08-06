<template>
  <Head title="Add Order Item" />

  <div class="container mx-auto max-w-3xl py-6">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold">Add Order Item</h1>
      </div>
      <Link :href="index()"><Button variant="outline">Back</Button></Link>
    </div>

    <form @submit.prevent="submit" class="space-y-6 rounded-lg border p-6">
      <div>
        <Label>Order</Label>
        <Select v-model="form.order_id">
          <SelectTrigger><SelectValue placeholder="Select Order" /></SelectTrigger>
          <SelectContent>
            <SelectItem v-for="o in props.orders" :key="o.id" :value="o.id">{{ o.order_number }}</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <div>
        <Label>Product</Label>
        <Select v-model="form.product_id">
          <SelectTrigger><SelectValue placeholder="Select Product" /></SelectTrigger>
          <SelectContent>
            <SelectItem v-for="p in props.products" :key="p.id" :value="p.id">{{ p.name }}</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <div class="grid grid-cols-3 gap-4">
        <Input v-model="form.quantity" type="number" />
        <Input v-model="form.price" />
        <Input v-model="form.total" />
      </div>

      <div class="flex justify-end gap-3">
        <Button :disabled="form.processing">Save Item</Button>
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
import { store, index } from '@/actions/App/Http/Controllers/OrderItemController'

const props = defineProps<{ orders: any[]; products: any[] }>()

const form = useForm({ order_id: null as number | null, product_id: null as number | null, quantity: 1, price: 0, total: 0 })
function submit() { form.post(store().url) }
</script>
