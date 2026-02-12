<script setup>
import { ref, onMounted, onUnmounted, watch } from 'vue';
import { RouterLink, useRoute } from 'vue-router';
import { useAuth } from '../composables/useAuth';

const route = useRoute();
const sidebarOpen = ref(false);
const userMenuOpen = ref(false);
const userMenuRef = ref(null);

const { userData, userLoading, userError, fetchUser } = useAuth();

function toggleSidebar() {
  sidebarOpen.value = !sidebarOpen.value;
}

function closeSidebar() {
  sidebarOpen.value = false;
}

function toggleUserMenu() {
  userMenuOpen.value = !userMenuOpen.value;
}

function closeUserMenu() {
  userMenuOpen.value = false;
}

function handleKeydown(e) {
  if (e.key === 'Escape') {
    closeSidebar();
    closeUserMenu();
  }
}

function handleClickOutside(e) {
  if (userMenuRef.value && !userMenuRef.value.contains(e.target)) {
    closeUserMenu();
  }
}

onMounted(() => {
  fetchUser();
  window.addEventListener('keydown', handleKeydown);
  window.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeydown);
  window.removeEventListener('click', handleClickOutside);
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
      <div ref="userMenuRef" class="relative flex h-10 w-10 items-center justify-center">
        <button
          type="button"
          aria-label="User menu"
          :aria-expanded="userMenuOpen"
          aria-haspopup="true"
          class="flex h-10 w-10 items-center justify-center rounded-lg text-amber-500/90 transition hover:bg-amber-900/20 hover:text-amber-400"
          :class="{ 'bg-amber-900/20 text-amber-400': userMenuOpen }"
          @click.stop="toggleUserMenu"
        >
          <FontAwesomeIcon icon="user" class="h-5 w-5" />
        </button>
        <Transition
          enter-active-class="transition duration-150 ease-out"
          enter-from-class="opacity-0 scale-95"
          enter-to-class="opacity-100 scale-100"
          leave-active-class="transition duration-100 ease-in"
          leave-from-class="opacity-100 scale-100"
          leave-to-class="opacity-0 scale-95"
        >
          <div
            v-show="userMenuOpen"
            class="absolute right-0 top-full z-50 mt-2 w-48 origin-top-right rounded-lg border border-amber-900/30 bg-[#120f18] py-1 shadow-xl"
            role="menu"
          >
            <!-- Loading -->
            <div
              v-if="userLoading"
              class="flex items-center gap-2 px-3 py-4 text-sm text-stone-400"
            >
              <FontAwesomeIcon icon="spinner" class="h-4 w-4 animate-spin text-amber-500/80" />
              Loading…
            </div>

            <!-- Error -->
            <template v-else-if="userError">
              <div class="border-b border-amber-900/20 px-3 py-2">
                <p class="text-xs text-amber-600/90">Could not load user</p>
                <p class="mt-0.5 text-xs text-stone-500">{{ userError }}</p>
              </div>
              <button
                type="button"
                class="flex w-full items-center gap-2 px-3 py-2 text-sm text-stone-400 transition hover:bg-amber-900/15 hover:text-amber-200/90"
                @click="fetchUser"
              >
                <FontAwesomeIcon icon="arrows-rotate" class="h-4 w-4 text-amber-500/70" />
                Retry
              </button>
            </template>

            <!-- Signed in -->
            <template v-else-if="userData?.user">
              <div class="border-b border-amber-900/20 px-3 py-2">
                <p class="truncate text-xs font-medium text-amber-400/90">Signed in as</p>
                <p class="truncate text-sm text-stone-300">{{ userData.user.name || userData.user.email }}</p>
              </div>
              <a
                href="#"
                class="flex items-center gap-2 px-3 py-2 text-sm text-stone-400 transition hover:bg-amber-900/15 hover:text-amber-200/90"
                role="menuitem"
                @click.prevent="closeUserMenu"
              >
                <FontAwesomeIcon icon="cog" class="h-4 w-4 text-amber-500/70" />
                Settings
              </a>
              <a
                href="#"
                class="flex items-center gap-2 px-3 py-2 text-sm text-stone-400 transition hover:bg-amber-900/15 hover:text-amber-200/90"
                role="menuitem"
                @click.prevent="closeUserMenu"
              >
                <FontAwesomeIcon icon="right-from-bracket" class="h-4 w-4 text-amber-500/70" />
                Sign out
              </a>
            </template>

            <!-- Guest -->
            <template v-else>
              <div class="border-b border-amber-900/20 px-3 py-2">
                <p class="text-xs text-stone-500">Not signed in</p>
              </div>
              <a
                href="#"
                class="flex items-center gap-2 px-3 py-2 text-sm text-stone-400 transition hover:bg-amber-900/15 hover:text-amber-200/90"
                role="menuitem"
                @click.prevent="closeUserMenu"
              >
                <FontAwesomeIcon icon="right-to-bracket" class="h-4 w-4 text-amber-500/70" />
                Sign in
              </a>
              <a
                href="#"
                class="flex items-center gap-2 px-3 py-2 text-sm text-stone-400 transition hover:bg-amber-900/15 hover:text-amber-200/90"
                role="menuitem"
                @click.prevent="closeUserMenu"
              >
                <FontAwesomeIcon icon="user-plus" class="h-4 w-4 text-amber-500/70" />
                Register
              </a>
            </template>
          </div>
        </Transition>
      </div>
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
    <main class="relative min-h-[calc(100vh-3.5rem)] overflow-x-hidden md:min-h-[calc(100vh-3.5rem)]">
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
