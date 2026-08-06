<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import { Switch } from '@/components/ui/switch'

import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

import InputError from '@/components/InputError.vue'
import { update, index } from '@/actions/App/Http/Controllers/CategoryController'


interface Category {
    id: number
    parent_id: number | null
    name: string
    slug: string
    description: string | null
    image: string | null
    icon: string | null
    is_active: boolean
    sort_order: number
    seo_title: string | null
    seo_description: string | null
}


interface ParentCategory {
    id: number
    name: string
}


const props = defineProps<{
    category: Category
    parents: ParentCategory[]
}>()


const form = useForm({
    parent_id: props.category.parent_id,
    name: props.category.name,
    slug: props.category.slug,
    description: props.category.description ?? '',
    image: props.category.image ?? '',
    icon: props.category.icon ?? '',
    is_active: props.category.is_active,
    sort_order: props.category.sort_order,
    seo_title: props.category.seo_title ?? '',
    seo_description: props.category.seo_description ?? '',
})


function submit() {

    form.put(update(props.category.id).url)
}

</script>


<template>

    <Head title="Edit Category" />


    
        <div class="container mx-auto max-w-5xl py-6">


            <div class="mb-6 flex items-center justify-between">


                <div>

                    <h1 class="text-3xl font-bold">
                        Edit Category
                    </h1>

                    <p class="text-muted-foreground">
                        Update category information.
                    </p>

                </div>


                <Link :href="index()">

                    <Button variant="outline">
                        Back
                    </Button>

                </Link>


            </div>



            <form @submit.prevent="submit" class="space-y-6 rounded-lg border p-6">



                <!-- Parent Category -->

                <div>

                    <Label>
                        Parent Category
                    </Label>


                    <Select v-model="form.parent_id">


                        <SelectTrigger>

                            <SelectValue placeholder="Select Parent" />

                        </SelectTrigger>


                        <SelectContent>


                            <SelectItem :value="null">
                                None
                            </SelectItem>


                            <SelectItem v-for="parent in parents" :key="parent.id" :value="parent.id">

                                {{ parent.name }}

                            </SelectItem>


                        </SelectContent>


                    </Select>


                    <InputError :message="form.errors.parent_id" />


                </div>





                <!-- Name -->

                <div>

                    <Label>
                        Name
                    </Label>


                    <Input v-model="form.name" />


                    <InputError :message="form.errors.name" />


                </div>





                <!-- Slug -->

                <div>

                    <Label>
                        Slug
                    </Label>


                    <Input v-model="form.slug" />


                    <InputError :message="form.errors.slug" />


                </div>





                <!-- Description -->

                <div>

                    <Label>
                        Description
                    </Label>


                    <Textarea v-model="form.description" rows="4" />


                    <InputError :message="form.errors.description" />


                </div>





                <!-- Image -->

                <div>

                    <Label>
                        Image
                    </Label>


                    <Input v-model="form.image" />


                    <InputError :message="form.errors.image" />


                </div>





                <!-- Icon -->

                <div>

                    <Label>
                        Icon
                    </Label>


                    <Input v-model="form.icon" />


                    <InputError :message="form.errors.icon" />


                </div>





                <!-- Sort -->

                <div>

                    <Label>
                        Sort Order
                    </Label>


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





                <!-- SEO -->

                <div>

                    <Label>
                        SEO Title
                    </Label>


                    <Input v-model="form.seo_title" />


                    <InputError :message="form.errors.seo_title" />


                </div>



                <div>

                    <Label>
                        SEO Description
                    </Label>


                    <Textarea v-model="form.seo_description" rows="4" />


                    <InputError :message="form.errors.seo_description" />


                </div>





                <div class="flex justify-end gap-3">


                    <Link :href="index()">

                        <Button type="button" variant="outline">

                            Cancel

                        </Button>

                    </Link>



                    <Button :disabled="form.processing">

                        Update Category

                    </Button>


                </div>




            </form>



        </div>
</template>