<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Switch } from '@/components/ui/switch'
import { update, index } from '@/actions/App/Http/Controllers/CouponController'

const props = defineProps<{ coupon: any }>()
const form = useForm({
  code: props.coupon.code,
  type: props.coupon.type,
  value: props.coupon.value,
  minimum_amount: props.coupon.minimum_amount,
  expiry_date: props.coupon.expiry_date ?? '',
  is_active: props.coupon.is_active,
})

function submit() { form.put(update(props.coupon.id).url) }
</script>

<template>
  <Head title="Edit Coupon" />
  <div class="container mx-auto max-w-3xl py-6">
    <div class="mb-6 flex items-center justify-between">
      <h1 class="text-3xl font-bold">Edit Coupon</h1>
      <Link :href="index()"><Button variant="outline">Back</Button></Link>
    </div>
    <form @submit.prevent="submit" class="space-y-6 rounded-lg border p-6">
      <div>
        <Label>Code</Label>
        <Input v-model="form.code" />
      </div>
      <div>
        <Label>Type</Label>
        <Select v-model="form.type">
          <SelectTrigger><SelectValue /></SelectTrigger>
          <SelectContent>
            <SelectItem value="fixed">Fixed</SelectItem>
            <SelectItem value="percent">Percent</SelectItem>
          </SelectContent>
        </Select>
      </div>
      <div>
        <Label>Value</Label>
        <Input v-model="form.value" type="number" step="0.01" />
      </div>
      <div>
        <Label>Minimum Amount</Label>
        <Input v-model="form.minimum_amount" type="number" step="0.01" />
      </div>
      <div>
        <Label>Expiry Date</Label>
        <Input v-model="form.expiry_date" type="date" />
      </div>
      <div class="flex items-center gap-3">
        <Switch v-model:checked="form.is_active" />
        <Label>Active</Label>
      </div>
      <div class="flex justify-end gap-3">
        <Button :disabled="form.processing">Update</Button>
      </div>
    </form>
  </div>
</template>
