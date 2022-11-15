<template>
    <Master>
        <div class="flex h-full flex-col justify-center">
            <Vue3Lottie :animationData="title[status]" :height="400" :width="500" />
        </div>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import Page404 from "/public/image/status/404.json"

const props = defineProps({
	status: { type: Object, required: true },
})
const title = {
    503: '503: Service ss',
    500: '500: Server Error',
    404: '404: Page Not aaaaaaassss',
    403: Page404,
}
const description = {
    503: 'Sorry, we are doing some maintenance. Please check back soon.',
    500: 'Whoops, something went wrong on our servers.',
    404: 'Sorry, the page you are looking for could not be found.',
    403: 'Sorry, you are forbidden from accessing this page.',
}
//   export default {
//     props: {
//       status: Number,
//     },
//     computed: {
//       function title() {
//         return {
//           503: '503: Service Unavailable',
//           500: '500: Server Error',
//           404: '404: Page Not ssss',
//           403: '403: Forbidden',
//         }[this.status]
//       },
//       description() {
//         return {
//           503: 'Sorry, we are doing some maintenance. Please check back soon.',
//           500: 'Whoops, something went wrong on our servers.',
//           404: 'Sorry, the page you are looking for could not be found.',
//           403: 'Sorry, you are forbidden from accessing this page.',
//         }[this.status]
//       },
//     },
//   }
</script>