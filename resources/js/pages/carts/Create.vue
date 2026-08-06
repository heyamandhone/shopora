<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { store, index } from '@/actions/App/Http/Controllers/CartController'

const props = defineProps<{ products: { id: number; name: string }[] }>()
const form = useForm({
  session_id: '',
  customer_id: null as number | null,
  product_id: null as number | null,
  quantity: 1,
  price: 0,
  options: '',
})

function submit() { form.post(store().url) }
</script>

<template>
  <Head title="Create Cart Item" />
  <div class="container mx-auto max-w-3xl py-6">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-3xl font-bold">Create Cart Item</h1>
      <Link :href="index()"><Button variant="outline">Back</Button></Link>
    </div>
    <form @submit.prevent="submit" class="space-y-6 rounded-lg border p-6">
      <div>
        <Label>Session ID</Label>
        <Input v-model="form.session_id" />
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
      <div>
        <Label>Quantity</Label>
        <Input v-model="form.quantity" type="number" />
      </div>
      <div>
        <Label>Price</Label>
        <Input v-model="form.price" type="number" step="0.01" />
      </div>
      <div class="flex justify-end gap-3">
        <Button :disabled="form.processing">Save</Button>
      </div>
    </form>
  </div>
</template>
