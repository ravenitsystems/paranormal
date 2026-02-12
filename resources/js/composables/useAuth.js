import { ref, computed } from 'vue';
import axios from 'axios';

// Shared state — same refs for every component that uses useAuth()
const userData = ref(null);
const userLoading = ref(false);
const userError = ref(null);

export async function fetchUser() {
  userLoading.value = true;
  userError.value = null;
  try {
    const { data } = await axios.get('/api/user');
    userData.value = data;
  } catch (err) {
    userError.value = err.response?.data?.message || err.message || 'Failed to load user';
    userData.value = null;
  } finally {
    userLoading.value = false;
  }
}

/**
 * Global auth state. Use in any component to read login state and user data.
 * @returns {{ userData: Ref, user: ComputedRef<object|null>, userLoading: Ref, userError: Ref, isLoggedIn: ComputedRef<boolean>, fetchUser: function }}
 */
export function useAuth() {
  const user = computed(() => userData.value?.user ?? null);
  const isLoggedIn = computed(() => !!user.value);

  return {
    userData,
    user,
    userLoading,
    userError,
    isLoggedIn,
    fetchUser,
  };
}
