<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { User } from '@lucide/vue'

const page = usePage()

const user = page.props.auth.user
</script>

<template>
    <Link v-if="user" href="/account" class="flex items-center gap-2">
        <User class="h-5 w-5" />
        <span>{{ user.name }}</span>
    </Link>

    <Link v-else href="/login" class="flex items-center gap-2">
        <User class="h-5 w-5" />
        <span>Login</span>
    </Link>
</template>