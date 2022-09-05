<template>
	<component :is="tag" class="file-preview ">
		<div class="grid place-items-center">
			<img class="max-w-full min-h-80 max-h-80" :src="file.url" :alt="file.file.name" :title="file.file.name" />
			<button @click="$emit('remove', file);" class="close-icon">&times;</button>
		</div>
	</component>
</template>

<script setup>
defineProps({
	file: { type: Object, required: true },
	tag: { type: String, default: 'li' },
})

defineEmits(['remove'])
</script>