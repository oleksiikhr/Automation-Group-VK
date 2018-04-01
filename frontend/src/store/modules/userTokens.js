import axios from 'axios'

const state = {
  list: [],
  selected: {},
  isLoading: true
}

const mutations = {
  SET_USER_TOKENS (state, arr) {
    state.list = arr
  },
  SET_SELECTED_USER_TOKEN (state, obj) {
    state.selected = obj
  },
  LOADING (state, bool = true) {
    state.loading = bool
  }
}

const actions = {
  fetchUserTokens ({commit}) {
    commit('LOADING')

    axios.get('users/tokens')
      .then(res => {
        commit('SET_USER_TOKENS', res.data)
        commit('LOADING', false)
      })
      .catch(err => {
        console.log(err.response.data)
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
