<template>
    <div v-show="status == 5" class="relative badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="Proses pembuatan HPS">
        Pembuatan HPS
    </div>
    <div v-show="status == 6" class="relative badge badge-outline tooltip tooltip-bottom ml-2" data-tip="Pengecekan HPS oleh PPK">
        Pengajuan HPS
    </div>
    <div v-show="status == 7" class="relative badge badge-secondary badge-outline tooltip tooltip-bottom ml-2" data-tip="HPS ditolak">
        HPS ditolak
    </div>
    <div v-show="status >= 8" class="relative badge text-first border-first badge-outline tooltip tooltip-bottom ml-2" data-tip="HPS diterima">
        HPS selesai
    </div>
</template>
    const is_ApprovalSiren          = 2;
    const is_RABReject              = 3;
    const is_ChoosingHpsExecutor    = 4;
    const is_CreateHPS              = 5;
    const is_ApprovalHPS            = 6;
    const is_HPSReject              = 7;
    const is_ChoosingSupplier       = 8;
    const is_CreateContract         = 9;
    const is_CheckingRealItems      = 10;
<script setup>
    defineProps(['status'])
</script>