import axios from 'axios'

const state = {
  list: [],
  selected: {},
  loading: true
}

const mutations = {
  SET_GROUPS (state, arr) {
    state.list = arr
  },
  SET_SELECTED_GROUP (state, obj) {
    state.selected = obj
  },
  LOADING (state, bool = true) {
    state.loading = bool
  }
}

const actions = {
  fetchGroups ({commit}) {
    commit('LOADING')

    axios.get('groups')
      .then(res => {
        // TODO Delete the sample data
        res.data = [
          {
            id: 1,
            name: 'English',
            screen_name: 'eng_day',
            description: '',
            photo_100: 'https://pp.userapi.com/c637217/v637217600/4560a/WZAKU-dEqcw.jpg',
            secret_key: null,
            deactivated: false,
            vk_closed: false,
            vk_blocked: false,
            vk_users: 5155,
            users_count: 1555,
            updated_at: '2018-03-09 16:05:31',
            created_at: '2016-03-09 16:05:31'
          },
          {
            id: 2,
            name: 'Second group',
            screen_name: 'second_group',
            description: 'Группа посвящена разработке приложений на основе платформы ВКонтакте API и всему, что с ней связано.\n\n' +
            'API позволяет создавать интересные, интерактивные и популярные приложения. Встроенные средства монетизации позволяют приносить доход разработчикам приложений, начиная с первых дней запуска.\n',
            photo_100: 'https://pp.userapi.com/c638629/v638629852/27b32/E1C5NJbopqw.jpg',
            secret_key: 'test',
            deactivated: true,
            vk_closed: true,
            vk_blocked: false,
            vk_users: 15,
            users_count: 0,
            updated_at: '2018-01-21 18:35:47',
            created_at: '2017-11-19 16:05:31'
          }
        ]

        commit('SET_GROUPS', res.data)
        commit('LOADING', false)
      })
      .catch(err => {
        console.log(err.response.data)
      })
  },
  setSelectedGroup ({commit}, obj) {
    commit('SET_SELECTED_GROUP', obj)
  },
  clearSelectedGroup ({commit}) {
    commit('CLEAR_SELECTED_GROUP', {})
  }
}

export default {
  state, mutations, actions
}
