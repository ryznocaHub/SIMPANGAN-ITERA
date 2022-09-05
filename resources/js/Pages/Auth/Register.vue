<script setup>
import BreezeButton from "@/Components/Button.vue";
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import BreezeInput from "@/Components/utils/Input.vue";
import BreezeLabel from "@/Components/utils/Label.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import { defineProps } from "vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    unit: "",
    role: "",
    terms: false,
});

const props = defineProps({
    units: Array,
});

const submit = () => {
    console.log(form);
    props.units.forEach(filterUnits);
    // if(form.unit > 30){
    //     alert("tes");
    // }
    // filter((data) => {
    //     if(data.full_name == unit)
    //     console.log(data.full_name)
    //     console.log("form.unit")
    //     });
    console.log(form.unit);
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};

function filterUnits(item) {
    if (item.full_name == form.unit) {
        form.unit = item.id;
    }
}
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Register" />

        <BreezeValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <BreezeLabel for="name" value="Name" />
            <BreezeInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
            />

            <BreezeLabel for="email" value="Email" />
            <BreezeInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="username"
            />

            <BreezeLabel for="password" value="Password" />
            <BreezeInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
                autocomplete="new-password"
            />

            <BreezeLabel for="password_confirmation" value="Confirm Password" />
            <BreezeInput
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password_confirmation"
                required
                autocomplete="new-password"
            />

            <BreezeLabel for="Role" value="Role" />
            <BreezeInput
                id="role"
                type="text"
                class="mt-1 block w-full"
                v-model="form.role"
                required
            />

            <BreezeLabel for="Unit" value="Unit" autocomplete="off" />
            <BreezeInput
                id="unit"
                type="search"
                class="mt-1 block w-full"
                v-model="form.unit"
                placeholder="Pilih Unit"
                list="data"
                required
            />

            <datalist id="data">
                <option
                    v-for="(unit, index) in units"
                    :key="unit.id"
                    :data-value="index"
                >
                    {{ unit.full_name }}
                </option>
            </datalist>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    Sudah memiliki akun?
                </Link>

                <BreezeButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
