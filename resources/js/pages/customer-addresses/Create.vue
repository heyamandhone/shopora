<template>
    <Head title="Add Customer Address" />

    <div class="container mx-auto max-w-3xl py-6">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Add Customer Address</h1>
            </div>
            <Link :href="index()"><Button variant="outline">Back</Button></Link>
        </div>

        <form @submit.prevent="submit" class="space-y-6 rounded-lg border p-6">
            <div>
                <Label>Customer</Label>
                <Select v-model="form.customer_id">
                    <SelectTrigger><SelectValue placeholder="Select Customer" /></SelectTrigger>
                    <SelectContent>
                        <SelectItem v-for="customer in props.customers" :key="customer.id" :value="customer.id">
                            {{ customer.first_name }} {{ customer.last_name }}
                        </SelectItem>
                    </SelectContent>
                </Select>
                <InputError :message="form.errors.customer_id" />
            </div>

            <div>
                <Label>Label</Label>
                <Input v-model="form.label" />
            </div>

            <div>
                <Label>Full Name</Label>
                <Input v-model="form.full_name" />
            </div>

            <div>
                <Label>Phone</Label>
                <Input v-model="form.phone" />
            </div>

            <div>
                <Label>Address Line 1</Label>
                <Input v-model="form.address_line_1" />
            </div>

            <div>
                <Label>Address Line 2</Label>
                <Input v-model="form.address_line_2" />
            </div>

            <div>
                <Label>City</Label>
                <Input v-model="form.city" />
            </div>

            <div>
                <Label>State</Label>
                <Input v-model="form.state" />
            </div>

            <div>
                <Label>Postal Code</Label>
                <Input v-model="form.postal_code" />
            </div>

            <div>
                <Label>Country</Label>
                <Input v-model="form.country" />
            </div>

            <div class="flex items-center gap-3">
                <Switch v-model:checked="form.is_default" />
                <Label>Default Address</Label>
            </div>

            <div class="flex justify-end gap-3">
                <Link :href="index()"><Button variant="outline">Cancel</Button></Link>
                <Button :disabled="form.processing">Save Address</Button>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Switch } from '@/components/ui/switch'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import InputError from '@/components/InputError.vue'
import { store, index } from '@/actions/App/Http/Controllers/CustomerAddressController'

const props = defineProps<{
    customers: { id: number; first_name: string; last_name: string }[]
}>()

const form = useForm({
    customer_id: null as number | null,
    label: '',
    full_name: '',
    phone: '',
    address_line_1: '',
    address_line_2: '',
    city: '',
    state: '',
    postal_code: '',
    country: 'India',
    is_default: false,
})

function submit() {
    form.post(store().url)
}
</script>
