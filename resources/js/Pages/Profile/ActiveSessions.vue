<template>
        <div class="bg-white rounded-none shadow-lg overflow-hidden sm:rounded-lg">
          <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-indigo-400 to-indigo-600 text-white border-gray-200">
      <h2 class="text-s font-medium text-white uppercase tracking-wider font-semibold">Active Sessions</h2>
    </div>
    <div class="p-4 sm:p-6">
      <div v-if="loading" class="text-center text-gray-500">Loading sessions...</div>
      <div v-else-if="sessions.length === 0" class="text-center text-gray-500">No active sessions found.</div>
      <div v-else class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device IP</th>
              <th scope="col" class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">OS / Browser</th>
              <th scope="col" class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Activity</th>
              <th scope="col" class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="session in sessions" :key="session.id">
              <td class="px-3 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-sm text-gray-900">
                {{ session.ip_address }}
              </td>
              <td class="px-3 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-sm text-gray-500">
                <div class="flex items-center">
                  <div class="user-agent-icon mr-2" v-html="getUserAgentIcon(session.user_agent)"></div>
                  <span class="hidden sm:inline">{{ session.user_agent ? parseUserAgent(session.user_agent) : 'Unknown' }}</span>
                  <span class="sm:hidden">{{ session.user_agent ? parseUserAgent(session.user_agent).split(' / ')[1] : 'Unknown' }}</span>
                </div>
              </td>
              <td class="px-3 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-sm text-gray-500">
                {{ formatDate(session.last_activity) }}
              </td>
              <td class="px-3 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-sm font-medium">
                <button
                  @click="terminateSession(session.id)"
                  class="text-indigo-600 hover:text-indigo-900"
                  :disabled="terminatingSession === session.id"
                >
                  {{ terminatingSession === session.id ? 'Terminating...' : 'Terminate' }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'

export default {
  setup() {
    const sessions = ref([])
    const loading = ref(true)
    const terminatingSession = ref(null)

    const fetchSessions = async () => {
      try {
        const response = await axios.get('/user/active-sessions')
        sessions.value = response.data
        loading.value = false
      } catch (error) {
        console.error('Error fetching sessions:', error)
        loading.value = false
      }
    }

    const terminateSession = async (sessionId) => {
      try {
        terminatingSession.value = sessionId
        await axios.delete(`/user/active-sessions/${sessionId}`)
        sessions.value = sessions.value.filter(session => session.id !== sessionId)
      } catch (error) {
        console.error('Error terminating session:', error)
        alert('Failed to terminate session. Please try again.')
      } finally {
        terminatingSession.value = null
      }
    }

    const formatDate = (timestamp) => {
      const date = new Date(timestamp * 1000)
      return date.toLocaleString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    }

    const parseUserAgent = (userAgent) => {
      let os = 'Unknown OS'
      let browser = 'Unknown Browser'

      if (userAgent.includes('Win')) os = 'Windows'
      else if (userAgent.includes('Mac')) os = 'MacOS'
      else if (userAgent.includes('Linux')) os = 'Linux'
      else if (userAgent.includes('Android')) os = 'Android'
      else if (userAgent.includes('iOS')) os = 'iOS'

      if (userAgent.includes('Firefox')) browser = 'Firefox'
      else if (userAgent.includes('Chrome')) browser = 'Chrome'
      else if (userAgent.includes('Safari')) browser = 'Safari'
      else if (userAgent.includes('Edge')) browser = 'Edge'
      else if (userAgent.includes('Opera')) browser = 'Opera'

      return `${os} / ${browser}`
    }

    const getUserAgentIcon = (userAgent) => {
      // The getUserAgentIcon function remains the same as in the original code
      // ...
    }

    onMounted(fetchSessions)

    return {
      sessions,
      loading,
      terminateSession,
      formatDate,
      terminatingSession,
      parseUserAgent,
      getUserAgentIcon,
    }
  },
}
</script>

<style scoped>
.user-agent-icon {
  display: inline-flex;
  align-items: center;
}

.user-agent-icon svg {
  width: 16px;
  height: 16px;
}

@media (min-width: 640px) {
  .user-agent-icon svg {
    width: 20px;
    height: 20px;
  }
}
</style>
