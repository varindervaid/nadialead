<template>
  <nav class="px-4 flex items-center justify-center sm:px-0">
    <div class="block">
      <button
        type="button"
        :disabled="currentPage <= 1"
        @click="changePage(currentPage - 1)"
        class="flex items-center justify-center text-sm font-medium text-gray-500 hover:text-gray-700 w-8 h-8 rounded-lg bg-body"
        :class="{ 'opacity-20': currentPage <= 1 }"
      >
        <ChevronDoubleLeftIcon class="h-5 w-5 text-white" aria-hidden="true" />
      </button>
    </div>
    <div class="hidden md:-mt-px md:flex">
      <button
        type="button"
        v-for="page in pages"
        :key="page"
        @click="changePage(page)"
        :class="{
          'flex items-center justify-center text-sm text-white font-medium focus:outline-none w-8 h-8 bg-sky-900 rounded-lg hover:bg-sky-400 hover:text-white ml-2':
            page != currentPage,
          'flex items-center justify-center text-sm font-medium focus:outline-none w-8 h-8 bg-sky-500 rounded-lg text-white ml-2':
            page === currentPage,
        }"
      >
        {{ page }}
      </button>
    </div>
    <div class="block ml-2">
      <button
        type="button"
        :disabled="currentPage >= lastPage"
        @click="changePage(currentPage + 1)"
        class="flex items-center justify-center text-sm font-medium text-gray-500 hover:text-gray-700 w-8 h-8 rounded-lg bg-body"
        :class="{ 'opacity-20': currentPage >= lastPage }"
      >
        <ChevronDoubleRightIcon class="h-5 w-5 text-white" aria-hidden="true" />
      </button>
    </div>
  </nav>
</template>

<script>
import { ChevronDoubleLeftIcon, ChevronDoubleRightIcon } from "@heroicons/vue/24/solid";
export default {
  components: {
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
  },
  props: {
    currentPage: Number,
    lastPage: Number,
    total: Number,
    maxVisibleButtons: {
      type: Number,
      default: 10,
    },
  },
  computed: {
    startPage() {
      if (this.currentPage === 1) {
        return 1;
      }

      if (this.currentPage === this.lastPage) {
        return Math.max(1, this.lastPage - this.maxVisibleButtons + 1);
      }
      let min = Math.min(
        this.currentPage - 1,
        this.lastPage - (this.maxVisibleButtons - 1)
      );
      return Math.max(1, min);
    },
    endPage() {
      return Math.min(this.startPage + this.maxVisibleButtons - 1, this.lastPage);
    },
    pages() {
      const range = [];

      for (let i = this.startPage; i <= this.endPage; i += 1) {
        range.push(i);
      }

      return range;
    },
  },
  methods: {
    changePage(page) {
      this.$emit("refreshTable", page);
    },
  },
  data() {
    return {};
  },
};
</script>
