<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/utils/Input.vue";
import BreezeLabel from "@/Components/utils/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import Notification from "@/Components/composables/Notification"

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const toast = Notification() 

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onStart: () => {
            form.reset("password")
            form.clearErrors()
        },
        onSuccess: (e) => {
            toast('success', 'Login Berhasil')
        },
        onError: (e) => {
            toast('error', 'Login Gagal')
        }
    });
};

</script>

<template>
    <BreezeGuestLayout>
        <Head title="Log in" />
        
        <BreezeValidationErrors class="mb-4" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="email" value="Email" />
                <BreezeInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    :status="form.errors.email"
                    required
                    autofocus
                    autocomplete="username"
                />
            </div>

            <div class="mt-4">
                <BreezeLabel for="password" value="Password" />
                <BreezeInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    :status="form.errors.password"
                    required
                    autocomplete="current-password"
                />
            </div>

            <!-- <div class="block mt-4">
                <label class="flex items-center">
                    <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div> -->

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-sec hover:font-bold"
                >
                    Forgot your password?
                </Link>
                <!-- <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </BreezeButton> -->
                <button
                    class="btn ml-4 bg-first border-0 hover:opacity-75"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </button>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
