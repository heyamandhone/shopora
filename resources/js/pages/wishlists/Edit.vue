<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { update, index } from '@/actions/App/Http/Controllers/WishlistController'

const props = defineProps<{ item: any; customers: { id: number; first_name: string; last_name: string }[]; products: { id: number; name: string }[] }>()
const form = useForm({ customer_id: props.item.customer_id, product_id: props.item.product_id, notes: props.item.notes ?? '' })

function submit() { form.put(update(props.item.id).url) }
</script>

<template>
  <Head title="Edit Wishlist Item" />
  <div class="container mx-auto max-w-3xl py-6">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-3xl font-bold">Edit Wishlist Item</h1>
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
        <Label>Product</Label>
        <Select v-model="form.product_id">
          <SelectTrigger><SelectValue placeholder="Select Product" /></SelectTrigger>
          <SelectContent>
            <SelectItem v-for="p in props.products" :key="p.id" :value="p.id">{{ p.name }}</SelectItem>
          </SelectContent>
        </Select>
      </div>
      <div>
        <Label>Notes</Label>
        <Textarea v-model="form.notes" />
      </div>
      <div class="flex justify-end gap-3">
        <Button :disabled="form.processing">Update</Button>
      </div>
    </form>
  </div>
</template>
