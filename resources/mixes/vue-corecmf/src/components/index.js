import CoreCmfInstall from './install'

const components = [
  CoreCmfInstall
]
const install = function (Vue, opts = {}) {
  components.map(component => {
    Vue.component(component.name, component)
  })
}

export default install
