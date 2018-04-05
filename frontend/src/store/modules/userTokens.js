import axios from 'axios'

const state = {
  list: [],
  selected: {},
  loading: true
}

const mutations = {
  SET_USER_TOKENS (state, arr) {
    state.list = arr
  },
  SET_SELECTED_USER_TOKEN (state, obj) {
    state.selected = obj
  },
  LOADING_USER_TOKENS (state, bool = true) {
    state.loading = bool
  }
}

const actions = {
  fetchUserTokens ({commit}) {
    commit('LOADING_USER_TOKENS')

    axios.get('users/tokens')
      .then(res => {
        commit('SET_USER_TOKENS', res.data)
        commit('LOADING_USER_TOKENS', false)
      })
      .catch(() => {
        commit('LOADING_USER_TOKENS', false)
      })
  },
  setSelectedUserToken ({commit}, obj) {
    commit('SET_SELECTED_USER_TOKEN', obj)
  },
  clearSelectedUserToken ({commit}) {
    commit('SET_SELECTED_USER_TOKEN', {})
  }
}

export default {
  state, mutations, actions
}
