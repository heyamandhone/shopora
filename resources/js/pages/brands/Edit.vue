<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'


import {
    update,
    index
} from '@/actions/App/Http/Controllers/BrandController'


const props = defineProps<{
    brand: any
}>()



const form = useForm({

    name: props.brand.name,
    slug: props.brand.slug,
    description: props.brand.description ?? '',
    logo: props.brand.logo ?? '',
    is_active: props.brand.is_active,
    sort_order: props.brand.sort_order,
    seo_title: props.brand.seo_title ?? '',
    seo_description: props.brand.seo_description ?? '',

})



function submit() {

    form.put(
        update(props.brand.id).url
    )

}


</script>



<template>


    <Head title="Edit Brand" />

        <div class="container mx-auto py-6">


            <div class="mb-6">


                <h1 class="text-3xl font-bold">
                    Edit Brand
                </h1>


                <p class="text-muted-foreground">
                    Update brand information
                </p>


            </div>



            <form @submit.prevent="submit" class="space-y-6 max-w-2xl">



                <div>

                    <Label>
                        Name
                    </Label>


                    <Input v-model="form.name" />


                    <div v-if="form.errors.name" class="text-sm text-red-500">

                        {{ form.errors.name }}

                    </div>


                </div>




                <div>

                    <Label>
                        Slug
                    </Label>


                    <Input v-model="form.slug" />


                    <div v-if="form.errors.slug" class="text-sm text-red-500">

                        {{ form.errors.slug }}

                    </div>


                </div>




                <div>

                    <Label>
                        Description
                    </Label>


                    <Textarea v-model="form.description" />


                </div>




                <div>

                    <Label>
                        Logo
                    </Label>


                    <Input v-model="form.logo" />


                </div>




                <div>

                    <Label>
                        SEO Title
                    </Label>


                    <Input v-model="form.seo_title" />


                </div>




                <div>

                    <Label>
                        SEO Description
                    </Label>


                    <Textarea v-model="form.seo_description" />


                </div>




                <div class="flex items-center gap-3">


                    <input type="checkbox" v-model="form.is_active" />


                    <Label>
                        Active
                    </Label>


                </div>




                <div>


                    <Label>
                        Sort Order
                    </Label>


                    <Input type="number" v-model="form.sort_order" />


                </div>




                <div class="flex gap-3">


                    <Button type="submit" :disabled="form.processing">

                        Update

                    </Button>



                    <Link :href="index()">

                        <Button type="button" variant="secondary">

                            Cancel

                        </Button>

                    </Link>


                </div>



            </form>


        </div>




</template>