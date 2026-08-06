<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Textarea } from '@/components/ui/textarea'
import { update, index } from '@/actions/App/Http/Controllers/PaymentController'

const props = defineProps<{ payment: any; orders: { id: number; order_number: string }[] }>()
const form = useForm({
  order_id: props.payment.order_id,
  payment_method: props.payment.payment_method,
  transaction_id: props.payment.transaction_id ?? '',
  amount: props.payment.amount,
  status: props.payment.status,
  notes: props.payment.notes ?? '',
})

function submit() { form.put(update(props.payment.id).url) }
</script>

<template>
  <Head title="Edit Payment" />
  <div class="container mx-auto max-w-3xl py-6">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-3xl font-bold">Edit Payment</h1>
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
        <Button :disabled="form.processing">Update</Button>
      </div>
    </form>
  </div>
</template>
