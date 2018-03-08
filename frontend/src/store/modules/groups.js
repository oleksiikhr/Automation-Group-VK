import axios from 'axios'

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
    axios.get('groups')
      .then(res => {
        console.log(res.data)
        commit('SET_GROUPS', res.data)
      })
      .catch(err => {
        console.log(err.response.data)
      })
  },
  setCurrentGroup ({commit}, obj) {
    commit('SET_CURRENT_GROUP', obj)
  }
}

export default {
  state, mutations, actions
}
