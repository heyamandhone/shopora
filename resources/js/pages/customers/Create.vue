<template>
  <div>
    <h1 class="text-2xl font-semibold mb-4">Create Customer</h1>

    <form @submit.prevent="submit">
      <div class="grid grid-cols-2 gap-4">
        <Input v-model="form.first_name" label="First name" />
        <Input v-model="form.last_name" label="Last name" />
        <Input v-model="form.email" label="Email" />
        <Input v-model="form.phone" label="Phone" />
        <Input v-model="form.date_of_birth" label="Date of birth" type="date" />
        <Select v-model="form.gender" :options="[{ label: 'Male', value: 'male' }, { label: 'Female', value: 'female' }]" label="Gender" />
        <Switch v-model="form.is_active" label="Active" />
      </div>

      <div class="mt-4">
        <Button type="submit">Save</Button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'
import { Select } from '@/components/ui/select'
import { Switch } from '@/components/ui/switch'
import { Button } from '@/components/ui/button'
import { store } from '@/actions/App/Http/Controllers/CustomerController'

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  date_of_birth: '',
  gender: '',
  is_active: true,
})

function submit() {
  form.post(store().url)
}
</script>
