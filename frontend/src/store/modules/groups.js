const state = {
  current: null
}

const mutations = {
  SET_CURRENT_GROUP (state, obj) {
    state.current = obj
  }
}

const actions = {
  setCurrentGroup ({commit}, obj) {
    commit('SET_CURRENT_GROUP', obj)
  }
}

export default {
  state, mutations, actions
}
