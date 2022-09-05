<template>
    <div class="drawer">
  <input id="my-drawer" type="checkbox" class="drawer-toggle" />
  <div class="drawer-content bg-gray-100">
    <!-- Page content here -->
    <slot/>
  </div> 
  <div class="drawer-side">
    <label for="my-drawer" class="drawer-overlay"></label>
    <ul class="menu p-4 overflow-y-auto w-80 bg-base-100 text-base-content ">
      <!-- Sidebar content here -->
      <li><Link :href="route('procurement.index')" >Daftar Pengadaan</Link></li>
    </ul>
  </div>
</div>
</template>

<script setup>

  import { Link } from '@inertiajs/inertia-vue3'
  </script>