<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3'

import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Switch } from '@/components/ui/switch'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import InputError from '@/components/InputError.vue'
import { store, index } from '@/actions/App/Http/Controllers/ProductController'

interface Option {
    id: number
    name: string
}

const props = defineProps<{
    categories: Option[]
    brands: Option[]
}>()

const form = useForm({
    category_id: null as number | null,
    brand_id: null as number | null,
    name: '',
    slug: '',
    sku: '',
    description: '',
    price: '',
    sale_price: '',
    stock: 0,
    thumbnail: '',
    is_active: true,
    is_featured: false,
    sort_order: 0,
    seo_title: '',
    seo_description: '',
})

function submit() {
    form.post(store().url)
}
</script>

<template>

    <Head title="Create Product" />

    <div class="container mx-auto max-w-5xl py-6">

        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Create Product</h1>
                <p class="text-muted-foreground">Add a new product.</p>
            </div>

            <Link :href="index()">
                <Button variant="outline">Back</Button>
            </Link>
        </div>

        <form @submit.prevent="submit" class="space-y-6 rounded-lg border p-6">

            <div>
                <Label>Category</Label>
                <Select v-model="form.category_id">
                    <SelectTrigger>
                        <SelectValue placeholder="Select Category" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem :value="null">None</SelectItem>
                        <SelectItem v-for="c in props.categories" :key="c.id" :value="c.id">{{ c.name }}</SelectItem>
                    </SelectContent>
                </Select>
                <InputError :message="form.errors.category_id" />
            </div>

            <div>
                <Label>Brand</Label>
                <Select v-model="form.brand_id">
                    <SelectTrigger>
                        <SelectValue placeholder="Select Brand" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem :value="null">None</SelectItem>
                        <SelectItem v-for="b in props.brands" :key="b.id" :value="b.id">{{ b.name }}</SelectItem>
                    </SelectContent>
                </Select>
                <InputError :message="form.errors.brand_id" />
            </div>

            <div>
                <Label>Name</Label>
                <Input v-model="form.name" />
                <InputError :message="form.errors.name" />
            </div>

            <div>
                <Label>Slug</Label>
                <Input v-model="form.slug" />
                <InputError :message="form.errors.slug" />
            </div>

            <div>
                <Label>SKU</Label>
                <Input v-model="form.sku" />
                <InputError :message="form.errors.sku" />
            </div>

            <div>
                <Label>Description</Label>
                <Textarea rows="4" v-model="form.description" />
                <InputError :message="form.errors.description" />
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <Label>Price</Label>
                    <Input v-model="form.price" />
                    <InputError :message="form.errors.price" />
                </div>
                <div>
                    <Label>Sale Price</Label>
                    <Input v-model="form.sale_price" />
                    <InputError :message="form.errors.sale_price" />
                </div>
                <div>
                    <Label>Stock</Label>
                    <Input type="number" v-model="form.stock" />
                    <InputError :message="form.errors.stock" />
                </div>
            </div>

            <div>
                <Label>Thumbnail</Label>
                <Input v-model="form.thumbnail" />
                <InputError :message="form.errors.thumbnail" />
            </div>

            <div class="flex items-center gap-3">
                <Switch v-model:checked="form.is_active" />
                <Label>Active</Label>
            </div>

            <div class="flex items-center gap-3">
                <Switch v-model:checked="form.is_featured" />
                <Label>Featured</Label>
            </div>

            <div>
                <Label>Sort Order</Label>
                <Input type="number" v-model="form.sort_order" />
                <InputError :message="form.errors.sort_order" />
            </div>

            <div>
                <Label>SEO Title</Label>
                <Input v-model="form.seo_title" />
                <InputError :message="form.errors.seo_title" />
            </div>

            <div>
                <Label>SEO Description</Label>
                <Textarea rows="4" v-model="form.seo_description" />
                <InputError :message="form.errors.seo_description" />
            </div>

            <div class="flex justify-end gap-3">
                <Link :href="index()">
                    <Button variant="outline" type="button">Cancel</Button>
                </Link>
                <Button :disabled="form.processing">Save Product</Button>
            </div>

        </form>

    </div>

</template>
