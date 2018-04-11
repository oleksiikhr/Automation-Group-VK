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
  LOADING_GROUPS (state, bool = true) {
    state.loading = bool
  }
}

const actions = {
  fetchGroups ({commit}) {
    commit('LOADING_GROUPS')

    axios.get('groups')
      .then(res => {
        commit('SET_GROUPS', res.data)
        commit('LOADING_GROUPS', false)
      })
      .catch(() => {
        commit('LOADING_GROUPS', false)
      })
  },
  setSelectedGroup ({commit}, obj) {
    commit('SET_SELECTED_GROUP', obj)
  },
  clearSelectedGroup ({commit}) {
    commit('SET_SELECTED_GROUP', {})
  }
}

export default {
  state, mutations, actions
}
