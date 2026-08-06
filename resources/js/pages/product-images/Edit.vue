<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Switch } from '@/components/ui/switch'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import InputError from '@/components/InputError.vue'
import { update, index } from '@/actions/App/Http/Controllers/ProductImageController'

interface Option { id: number; name: string }

const props = defineProps<{
    image: any,
    products: Option[],
}>()

const form = useForm({
    product_id: props.image.product_id,
    image: props.image.image,
    alt_text: props.image.alt_text ?? '',
    is_primary: props.image.is_primary,
    sort_order: props.image.sort_order,
})

function submit() { form.put(update(props.image.id).url) }
</script>

<template>
    <Head title="Edit Product Image" />

    <div class="container mx-auto max-w-3xl py-6">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Edit Product Image</h1>
            </div>
            <Link :href="index()"><Button variant="outline">Back</Button></Link>
        </div>

        <form @submit.prevent="submit" class="space-y-6 rounded-lg border p-6">
            <div>
                <Label>Product</Label>
                <Select v-model="form.product_id">
                    <SelectTrigger><SelectValue placeholder="Select Product" /></SelectTrigger>
                    <SelectContent>
                        <SelectItem :value="null">None</SelectItem>
                        <SelectItem v-for="p in props.products" :key="p.id" :value="p.id">{{ p.name }}</SelectItem>
                    </SelectContent>
                </Select>
                <InputError :message="form.errors.product_id" />
            </div>

            <div>
                <Label>Image URL</Label>
                <Input v-model="form.image" />
                <InputError :message="form.errors.image" />
            </div>

            <div>
                <Label>Alt Text</Label>
                <Input v-model="form.alt_text" />
            </div>

            <div class="flex items-center gap-3">
                <Switch v-model:checked="form.is_primary" />
                <Label>Primary</Label>
            </div>

            <div>
                <Label>Sort Order</Label>
                <Input type="number" v-model="form.sort_order" />
            </div>

            <div class="flex justify-end gap-3">
                <Link :href="index()"><Button variant="outline">Cancel</Button></Link>
                <Button :disabled="form.processing">Update Image</Button>
            </div>
        </form>
    </div>
</template>
