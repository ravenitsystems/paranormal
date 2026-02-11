<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { RouterLink, useRoute } from 'vue-router';

const route = useRoute();
const sidebarOpen = ref(false);

function toggleSidebar() {
  sidebarOpen.value = !sidebarOpen.value;
}

function closeSidebar() {
  sidebarOpen.value = false;
}

function handleKeydown(e) {
  if (e.key === 'Escape') closeSidebar();
}

onMounted(() => {
  window.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown);
});

watch(sidebarOpen, (open) => {
  document.body.style.overflow = open ? 'hidden' : '';
});
</script>

<template>
  <div class="layout min-h-screen bg-[#0d0a0f] text-stone-200">
    <!-- Header -->
    <header
      class="sticky top-0 z-30 flex h-14 items-center justify-between border-b border-amber-900/30 bg-[#0d0a0f]/95 px-4 shadow-[0_0_20px_rgba(180,83,9,0.08)] backdrop-blur-sm md:px-6"
    >
      <button
        type="button"
        aria-label="Toggle menu"
        class="flex h-10 w-10 items-center justify-center rounded-lg text-amber-500/90 transition hover:bg-amber-900/20 hover:text-amber-400 md:hidden"
        @click="toggleSidebar"
      >
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path
            v-if="!sidebarOpen"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"
          />
          <path
            v-else
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </button>
      <RouterLink
        to="/"
        class="flex items-center gap-2.5 font-semibold tracking-wide transition hover:opacity-90"
      >
        <span
          class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-900/30 text-amber-400/95 shadow-[0_0_12px_rgba(251,191,36,0.15)]"
          aria-hidden="true"
        >
          <FontAwesomeIcon icon="ghost" class="h-5 w-5" />
        </span>
        <span class="flex flex-col leading-tight">
          <span class="bg-gradient-to-r from-amber-100 via-amber-300/90 to-amber-500/90 bg-clip-text text-base font-bold text-transparent drop-shadow-[0_0_8px_rgba(251,191,36,0.2)]">
            Paranormal
          </span>
          <span class="text-[10px] font-medium uppercase tracking-[0.2em] text-amber-600/80">
            Database
          </span>
        </span>
      </RouterLink>
      <div class="h-10 w-10 md:hidden" aria-hidden="true" />
    </header>

    <!-- Mobile overlay -->
    <div
      v-show="sidebarOpen"
      class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm transition-opacity md:hidden"
      aria-hidden="true"
      @click="closeSidebar"
    />

    <!-- Sidebar -->
    <aside
      :class="[
        'fixed left-0 top-0 z-50 h-full w-64 border-r border-amber-900/30 bg-[#120f18] shadow-[4px_0_24px_rgba(0,0,0,0.4)] transition-transform duration-300 ease-out md:static md:z-0 md:translate-x-0 md:shadow-none',
        sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0',
      ]"
    >
      <button
        type="button"
        aria-label="Close menu"
        class="absolute right-3 top-3 flex h-10 w-10 items-center justify-center rounded-lg text-amber-500/90 transition hover:bg-amber-900/20 hover:text-amber-400 md:hidden"
        @click="closeSidebar"
      >
        <FontAwesomeIcon icon="times" class="h-5 w-5" />
      </button>
      <nav class="flex flex-col gap-1 p-4 pt-20 md:pt-6" aria-label="Main navigation">
        <RouterLink
          to="/"
          class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
          :class="route.path === '/' ? 'bg-amber-900/25 text-amber-400' : 'text-stone-400 hover:bg-amber-900/15 hover:text-amber-200/90'"
          @click="closeSidebar"
        >
          <span class="text-amber-500/80" aria-hidden="true"><FontAwesomeIcon icon="ghost" /></span>
          Home
        </RouterLink>
        <RouterLink
          to="/search"
          class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
          :class="route.path === '/search' ? 'bg-amber-900/25 text-amber-400' : 'text-stone-400 hover:bg-amber-900/15 hover:text-amber-200/90'"
          @click="closeSidebar"
        >
          <span class="text-amber-500/80" aria-hidden="true"><FontAwesomeIcon icon="ghost" /></span>
          Search
        </RouterLink>
      </nav>

    </aside>

    <!-- Main content -->
    <main class="relative min-h-[calc(100vh-3.5rem)] md:min-h-[calc(100vh-3.5rem)]">
      <div class="mx-auto max-w-5xl px-4 py-6 md:px-6 md:py-8">
        <slot />
      </div>
    </main>
  </div>
</template>

<style scoped>
.layout {
  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: auto 1fr;
}

@media (min-width: 768px) {
  .layout {
    grid-template-columns: 16rem 1fr;
    grid-template-rows: auto 1fr;
  }
}

.layout header {
  grid-column: 1 / -1;
}

.layout aside {
  grid-row: 2;
}

.layout main {
  grid-column: 1 / -1;
}

@media (min-width: 768px) {
  .layout main {
    grid-column: 2;
  }
}
</style>
