<script setup>
    import HeaderArea from '@/components/Header/HeaderArea.vue';
    import SidebarArea from '@/components/Sidebar/SidebarArea.vue';
</script>

<template>
    <div class="flex h-screen overflow-hidden">

      <SidebarArea />

      <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

        <HeaderArea />

        <main>
          <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
            <!-- <slot></slot> -->
             <router-view></router-view>
          </div>
        </main>

      </div>
    </div>
</template>
