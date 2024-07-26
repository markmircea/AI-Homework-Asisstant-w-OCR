<template>
  <div class="bg-white rounded-md shadow overflow-hidden">
    <div class="px-8 py-4 bg-white border-b border-gray-200">
      <h2 class="text-xl font-semibold">Active Sessions</h2>
      </div>
    <div class="p-8">

      <div v-if="loading" class="text-center text-gray-500">Loading sessions...</div>
      <div v-else-if="sessions.length === 0" class="text-center text-gray-500">No active sessions found.</div>
      <table v-else class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device IP</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">OS / Browser</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Activity</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="session in sessions" :key="session.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              {{ session.ip_address }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    <div class="flex items-center">
      <div class="user-agent-icon mr-2" v-html="getUserAgentIcon(session.user_agent)"></div>
      <span>{{ session.user_agent ? parseUserAgent(session.user_agent) : 'Unknown' }}</span>
    </div>
  </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ formatDate(session.last_activity) }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
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
      return new Date(timestamp * 1000).toLocaleString()
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
  if (!userAgent) return ''

  let iconSvg = ''
  if (userAgent.includes('Win')) {
    iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
      <path d="M0 3.449L9.75 2.1v9.451H0m10.949-9.602L24 0v11.4H10.949M0 12.6h9.75v9.451L0 20.699M10.949 12.6H24V24l-12.9-1.801" fill="#0078D4"/>
    </svg>`
  } else if (userAgent.includes('Mac')) {
    iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
      <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z" fill="#999999"/>
    </svg>`
  } else if (userAgent.includes('Linux')) {
    iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
      <path d="M12.504 0c-.155 0-.315.008-.48.021-4.226.333-3.105 4.807-3.17 6.298-.076 1.092-.3 1.953-1.05 3.02-.885 1.051-2.127 2.75-2.716 4.521-.278.832-.41 1.684-.287 2.489a.424.424 0 00-.11.135c-.26.268-.45.6-.663.839-.199.199-.485.267-.797.4-.313.136-.658.269-.864.68-.09.189-.136.394-.132.602 0 .199.027.4.055.536.058.399.116.728.04.97-.249.68-.28 1.145-.106 1.484.174.334.535.47.94.601.81.2 1.91.135 2.774.6.926.466 1.866.67 2.616.47.526-.116.97-.464 1.208-.946.587-.003 1.23-.269 2.26-.334.699-.058 1.574.267 2.577.2.025.134.063.198.114.333l.003.003c.391.778 1.113 1.132 1.884 1.071.771-.06 1.592-.536 2.257-1.306.631-.765 1.683-1.084 2.378-1.503.348-.199.629-.469.649-.853.023-.4-.2-.811-.714-1.376v-.097l-.003-.003c-.17-.2-.25-.535-.338-.926-.085-.401-.182-.786-.492-1.046h-.003c-.059-.054-.123-.067-.188-.135a.357.357 0 00-.19-.064c.431-1.278.264-2.55-.173-3.694-.533-1.41-1.465-2.638-2.175-3.483-.796-1.005-1.576-1.957-1.56-3.368.026-2.152.236-6.133-3.544-6.139zm.529 3.405h.013c.213 0 .396.062.584.198.19.135.33.332.438.533.105.259.158.459.166.724 0-.02.006-.04.006-.06v.105a.086.086 0 01-.004-.021l-.004-.024a1.807 1.807 0 01-.15.706.953.953 0 01-.213.335.71.71 0 00-.088-.042c-.104-.045-.198-.064-.284-.133a1.312 1.312 0 00-.22-.066c.05-.06.146-.133.183-.198.053-.128.082-.264.088-.402v-.02a1.21 1.21 0 00-.061-.4c-.045-.134-.101-.2-.183-.333-.084-.066-.167-.132-.267-.132h-.016c-.093 0-.176.03-.262.132a.8.8 0 00-.205.334 1.18 1.18 0 00-.09.4v.019c.002.089.008.179.02.267-.193-.067-.438-.135-.607-.202-.01-.065-.016-.132-.018-.199v-.02a1.19 1.19 0 01.188-.747c.138-.2.277-.4.368-.533.16-.213.35-.4.533-.533.18-.135.397-.2.608-.2zm-2.74.133c-.213 0-.396.062-.584.198-.19.135-.33.332-.438.533-.105.259-.158.459-.166.724 0-.02-.006-.04-.006-.06v.105a.086.086 0 00.004-.021l.004-.024a1.807 1.807 0 00.15.706c.07.134.15.2.247.334.03.022.058.034.088.042a.953.953 0 00.213.335c.104.045.198.064.284.133.027.023.054.045.081.066-.05-.06-.146-.133-.183-.198a1.17 1.17 0 01-.088-.402v-.02a1.21 1.21 0 01.061-.4c.045-.134.101-.2.183-.333.084-.066.167-.132.267-.132h.016c.093 0 .176.03.262.132.076.089.152.2.205.334.058.134.09.267.09.4v.019a1.532 1.532 0 01-.02.267c.193-.067.438-.135.607-.202.01-.065.016-.132.018-.199v-.02a1.19 1.19 0 00-.188-.747c-.138-.2-.277-.4-.368-.533-.16-.213-.35-.4-.533-.533-.18-.135-.397-.2-.608-.2zm1.678 1.697c-.147.008-.324.016-.448.256-.124.2-.11.469-.2.469-.09 0-.112-.185-.35-.221-.079-.008-.155-.008-.193-.064-.054-.083-.072-.162-.187-.17h-.016c-.071 0-.117.048-.172.112l-.067.069-.018.015a.694.694 0 00-.243.27.613.613 0 00.133.534.629.629 0 00.475.248h.006c.214 0 .442-.07.643-.2.2-.134.33-.332.438-.534.105-.259.158-.459.166-.724 0 .02.006.04.006.06v-.105l-.004.024a1.807 1.807 0 00-.15-.706l-.018-.04zM9.19 9.52c-.024.134-.127.267-.185.401-.115.268-.216.47-.347.734-.266.535-.497 1.033-.715 1.502-.265.592-.488 1.185-.503 1.778 0 .186.01.351.033.533.023.186.073.374.13.59.095.352.208.703.33 1.051.073.218.15.449.232.68-3.346.577-5.964 3.617-5.964 7.204 0 4.107 3.382 7.444 7.55 7.444s7.551-3.337 7.551-7.444c0-3.645-2.704-6.724-6.125-7.26.087-.239.17-.47.249-.695.127-.352.243-.704.34-1.057.058-.213.107-.4.13-.59.023-.186.033-.367.033-.552-.015-.592-.237-1.185-.502-1.777-.218-.47-.45-.967-.715-1.502-.131-.264-.232-.466-.347-.734-.058-.134-.161-.267-.185-.401-.026-.135-.016-.267-.016-.4.011-.185.038-.4.082-.618.047-.22.098-.41.18-.629.063-.2.15-.4.258-.602.075-.134.132-.268.242-.401.127-.135.282-.203.471-.203.29 0 .525.134.654.4l.006.01v.006c.078.133.155.267.22.334.096.134.208.2.33.3.12.098.264.184.396.2.15 0 .301-.06.44-.133.135-.067.256-.134.376-.2.12-.064.24-.2.36-.334.137-.133.271-.334.405-.534.134-.2.24-.401.373-.602.057-.088.14-.184.18-.265.03-.06.07-.12.116-.184.044-.06.098-.124.162-.185.062-.05.15-.106.232-.106.085 0 .15.041.232.106.064.06.118.124.162.185.047.064.086.124.116.184.04.081.123.177.18.265.133.2.239.401.373.602.134.2.267.4.405.534.12.134.24.27.36.334.12.066.241.133.376.2.14.072.29.133.44.133.132-.016.276-.102.396-.2.122-.1.234-.166.33-.3.065-.067.142-.2.22-.334v-.006l.006-.01c.13-.266.364-.4.654-.4.19 0 .344.068.471.203.11.133.167.267.242.401.109.2.195.4.258.602.082.22.133.409.18.629.044.218.071.433.082.618 0 .133.01.265-.016.4z" fill="#000000"/>
    </svg>`
  } else if (userAgent.includes('Android')) {
    iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
      <path d="M6 18c0 .55.45 1 1 1h1v3.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5V19h2v3.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5V19h1c.55 0 1-.45 1-1V8H6v10zM3.5 8C2.67 8 2 8.67 2 9.5v7c0 .83.67 1.5 1.5 1.5S5 17.33 5 16.5v-7C5 8.67 4.33 8 3.5 8zm17 0c-.83 0-1.5.67-1.5 1.5v7c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5v-7c0-.83-.67-1.5-1.5-1.5zm-4.97-5.84l1.3-1.3c.2-.2.2-.51 0-.71-.2-.2-.51-.2-.71 0l-1.48 1.48C13.85 1.23 12.95 1 12 1c-.96 0-1.86.23-2.66.63L7.85.15c-.2-.2-.51-.2-.71 0-.2.2-.2.51 0 .71l1.31 1.31C6.97 3.26 6 5.01 6 7h12c0-1.99-.97-3.75-2.47-4.84zM10 5H9V4h1v1zm5 0h-1V4h1v1z" fill="#A4C639"/>
    </svg>`
  } else if (userAgent.includes('iOS')) {
    iconSvg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
      <path d="M17.05 20.28c-.98 1.09-2.12.9-3.23.45-1.15-.46-2.19-.47-3.4 0-1.55.62-2.36.43-3.23-.48-4.99-5.74-3.13-14.26 3.11-14.25 1.99.01 3.35 1.13 4.24 1.13 1.01 0 2.58-1.16 4.1-1.13 2.29.04 3.98 1.25 4.93 3.13-4.51 2.74-3.86 9.52.48 11.15zm-6.31-17.5c-.17 1.33-.55 2.43-1.23 3.32-1.08 1.39-2.61 1.8-3.21 1.8.01-1.28.5-2.55 1.41-3.46 1.06-1.09 2.68-1.71 3.03-1.66z" fill="#999999"/>
    </svg>`
  }

  return iconSvg
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
  width: 20px;
  height: 20px;
}
</style>
