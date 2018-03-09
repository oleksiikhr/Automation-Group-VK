// import axios from 'axios'

const state = {
  list: [],
  current: {}
}

const mutations = {
  SET_GROUPS (state, arr) {
    state.list = arr
  },
  SET_CURRENT_GROUP (state, obj) {
    state.current = obj
  }
}

const actions = {
  fetchGroups ({commit}) {
    // TODO Delete the sample data
    // TODO Description (+ backend)
    commit('SET_GROUPS', [
      {
        id: 1,
        name: 'English',
        photo_50: null,
        secret_key: null,
        deactivated: false,
        vk_closed: false,
        vk_blocked: false
      },
      {
        id: 2,
        name: 'Second group',
        photo_50: null,
        secret_key: 'test',
        deactivated: true,
        vk_closed: true,
        vk_blocked: true
      }
    ])
    // axios.get('groups')
    //   .then(res => {
    //     console.log(res.data)
    //     commit('SET_GROUPS', res.data)
    //   })
    //   .catch(err => {
    //     console.log(err.response.data)
    //   })
  },
  setCurrentGroup ({commit}, obj) {
    commit('SET_CURRENT_GROUP', obj)
  }
}

export default {
  state, mutations, actions
}
