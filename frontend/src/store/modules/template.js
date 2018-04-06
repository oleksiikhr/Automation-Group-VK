const state = {
  activeMenuItem: '/'
}

const mutations = {
  SET_ACTIVE_MENU_ITEM (state, str) {
    state.activeMenuItem = str
  }
}

const actions = {
  setActiveMenuItem ({commit}, str) {
    commit('SET_ACTIVE_MENU_ITEM', str)
  }
}

export default {
  state, mutations, actions
}
