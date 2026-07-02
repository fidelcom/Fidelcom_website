export default defineNuxtRouteMiddleware(async (to) => {
  const auth = reactive(useAuth())

  if (!auth.isAuthenticated) {
    await auth.fetchUser()
  }

  const isAuthRoute = to.path.startsWith('/auth/')

  if (!auth.isAuthenticated && !isAuthRoute) {
    return navigateTo('/auth/login')
  }

  if (auth.isAuthenticated && isAuthRoute) {
    return navigateTo('/dashboard')
  }
})
