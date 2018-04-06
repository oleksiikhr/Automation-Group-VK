const state = {
  selected: {}
}

const mutations = {
  SET_SELECTED_USER_TOKEN (state, obj) {
    state.selected = obj
  }
}

const actions = {
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
