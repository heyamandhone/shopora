<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Textarea } from '@/components/ui/textarea'
import { store, index } from '@/actions/App/Http/Controllers/PaymentController'

const props = defineProps<{ orders: { id: number; order_number: string }[] }>()
const form = useForm({ order_id: null as number | null, payment_method: 'cod', transaction_id: '', amount: 0, status: 'pending', notes: '' })
function submit() { form.post(store().url) }
</script>

<template>
  <Head title="Create Payment" />
  <div class="container mx-auto max-w-3xl py-6">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-3xl font-bold">Create Payment</h1>
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
        <Label>Payment Method</Label>
        <Input v-model="form.payment_method" />
      </div>
      <div>
        <Label>Transaction ID</Label>
        <Input v-model="form.transaction_id" />
      </div>
      <div>
        <Label>Amount</Label>
        <Input v-model="form.amount" type="number" step="0.01" />
      </div>
      <div>
        <Label>Status</Label>
        <Select v-model="form.status">
          <SelectTrigger><SelectValue /></SelectTrigger>
          <SelectContent>
            <SelectItem value="pending">Pending</SelectItem>
            <SelectItem value="paid">Paid</SelectItem>
            <SelectItem value="failed">Failed</SelectItem>
            <SelectItem value="refunded">Refunded</SelectItem>
          </SelectContent>
        </Select>
      </div>
      <div>
        <Label>Notes</Label>
        <Textarea v-model="form.notes" />
      </div>
      <div class="flex justify-end gap-3">
        <Button :disabled="form.processing">Save</Button>
      </div>
    </form>
  </div>
</template>
