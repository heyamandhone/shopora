<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Switch } from '@/components/ui/switch'
import InputError from '@/components/InputError.vue'
import { store, index } from '@/actions/App/Http/Controllers/CategoryController'

interface ParentCategory {
    id: number
    name: string
}

const props = defineProps<{
    parents: ParentCategory[]
}>()

const form = useForm({
    parent_id: null as number | null,
    name: '',
    slug: '',
    description: '',
    image: '',
    icon: '',
    is_active: true,
    sort_order: 0,
    seo_title: '',
    seo_description: '',
})

function submit() {
    form.post(store().url)
}
</script>

<template>

    <Head title="Create Category" />

   
        <div class="container mx-auto max-w-5xl py-6">

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">
                        Create Category
                    </h1>

                    <p class="text-muted-foreground">
                        Add a new product category.
                    </p>
                </div>

                <Link :href="index()">
                    <Button variant="outline">
                        Back
                    </Button>
                </Link>
            </div>

            <form @submit.prevent="submit" class="space-y-6 rounded-lg border p-6">

                <!-- Parent -->

                <div>
                    <Label>Parent Category</Label>

                    <Select v-model="form.parent_id">
                        <SelectTrigger>
                            <SelectValue placeholder="Select Parent Category" />
                        </SelectTrigger>

                        <SelectContent>

                            <SelectItem :value="null">
                                None
                            </SelectItem>

                            <SelectItem v-for="parent in props.parents" :key="parent.id" :value="parent.id">
                                {{ parent.name }}
                            </SelectItem>

                        </SelectContent>

                    </Select>

                    <InputError :message="form.errors.parent_id" />
                </div>

                <!-- Name -->

                <div>
                    <Label>Name</Label>

                    <Input v-model="form.name" />

                    <InputError :message="form.errors.name" />
                </div>

                <!-- Slug -->

                <div>
                    <Label>Slug</Label>

                    <Input v-model="form.slug" />

                    <InputError :message="form.errors.slug" />
                </div>

                <!-- Description -->

                <div>

                    <Label>Description</Label>

                    <Textarea rows="4" v-model="form.description" />

                    <InputError :message="form.errors.description" />

                </div>

                <!-- Image -->

                <div>

                    <Label>Image</Label>

                    <Input v-model="form.image" />

                    <InputError :message="form.errors.image" />

                </div>

                <!-- Icon -->

                <div>

                    <Label>Icon</Label>

                    <Input v-model="form.icon" />

                    <InputError :message="form.errors.icon" />

                </div>

                <!-- Sort Order -->

                <div>

                    <Label>Sort Order</Label>

                    <Input type="number" v-model="form.sort_order" />

                    <InputError :message="form.errors.sort_order" />

                </div>

                <!-- Status -->

                <div class="flex items-center gap-3">

                    <Switch v-model:checked="form.is_active" />

                    <Label>
                        Active
                    </Label>

                </div>

                <!-- SEO Title -->

                <div>

                    <Label>SEO Title</Label>

                    <Input v-model="form.seo_title" />

                    <InputError :message="form.errors.seo_title" />

                </div>

                <!-- SEO Description -->

                <div>

                    <Label>SEO Description</Label>

                    <Textarea rows="4" v-model="form.seo_description" />

                    <InputError :message="form.errors.seo_description" />

                </div>

                <div class="flex justify-end gap-3">

                    <Link :href=index()>

                        <Button variant="outline" type="button">
                            Cancel
                        </Button>

                    </Link>

                    <Button :disabled="form.processing">
                        Save Category
                    </Button>

                </div>

            </form>

        </div>
        
</template>