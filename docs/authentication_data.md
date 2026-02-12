Summary of changes:
fetchUser() runs in onMounted
The /api/user request is made when the Layout component mounts (on initial page load).
toggleUserMenu() no longer fetches
It only toggles the dropdown; the menu uses the user data that was loaded on mount.
The dropdown still shows loading until the request finishes, then shows the correct state (signed in, guest, or error). The Retry button in the error state still calls fetchUser() so users can retry after a failed load.
is the result of the api call available globally so other components can tell if a user is logged in

Checking the project for an existing global state (e.g. Pinia):
Keeping user state in Layout only. Adding a shared auth composable so any component can read login state and user data.



Summary of what’s in place:
1. Shared auth composable – resources/js/composables/useAuth.js
Keeps one shared state for the app: userData, userLoading, userError are module-level refs, so every component that uses useAuth() sees the same data.
fetchUser() – calls /api/user and updates that shared state (still run on page load from Layout’s onMounted).
useAuth() returns:
userData – { user: { id, name, email } } or { user: null }
user – computed: current user object or null
userLoading – boolean
userError – error message or null
isLoggedIn – computed: true when user is set
fetchUser – function to refetch (e.g. after login/logout)
2. Layout – Uses useAuth() instead of its own refs, so the header dropdown reads from this global state.
3. Using it in other components
Any component can depend on the same state by calling the composable, for example:
<script setup>import { useAuth } from '../composables/useAuth';const { user, isLoggedIn, userLoading } = useAuth();</script><template>  <div v-if="userLoading">Checking auth…</div>  <div v-else-if="isLoggedIn">Hello, {{ user.name }}</div>  <div v-else>Please sign in.</div></template>
So the result of the API call is available globally: any component that calls useAuth() can tell if a user is logged in via isLoggedIn or user, and all of them see the same data.
