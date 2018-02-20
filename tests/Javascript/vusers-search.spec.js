import { mount, createLocalVue } from '@vue/test-utils'
import Vuetify  from 'vuetify'
import expect from 'expect'
import VUsersSearch from '../../resources/assets/js/components/VUsersSearchComponent.vue'

const localVue = createLocalVue()
// localVue.use(Vuetify)

describe('VUsersSearch', () => {
  let component

  const USERS = [
    {
      id: 1,
      name: 'Pepe Pardo Jeans',
      email: 'pepepardojeans@gmail.com',
      givenName: 'Pardo',
      sn1: 'Pardo',
      sn2: 'Jeans',
      formatted_created_at_date: '2 Juliol 2017 14:00:00'
    },
    {
      id: 2,
      name: 'Acacha',
      email: 'sergiturbadenas@gmail.com',
      givenName: 'Sergi',
      sn1: 'Tur',
      sn2: 'Badenas',
      formatted_created_at_date: '3 Juliol 2017 15:00:00'
    },
    {
      id: 3,
      name: 'Foo',
      email: 'foofigtherbar@gmail.com',
      givenName: 'Foo',
      sn1: 'Fighter',
      sn2: 'Bar',
      formatted_created_at_date: '4 Juliol 2017 12:00:00'
    }
  ]

  beforeEach(() => {
    component = mount(VUsersSearch, {
      localVue
    })
  })

  it('see users after setting it via a prop', () => {
    component.setProps({ users: USERS })
    expect(component.vm.users).toEqual(USERS)

    // USERS.forEach(function (user) {
      // expect(component.html()).toContain(user.name)
    //   // expect(component.html()).toContain(user.email)
    //   // expect(component.html()).toContain(user.givenName)
    //   // expect(component.html()).toContain(user.sn1)
    //   // expect(component.html()).toContain(user.sn2)
    //   // expect(component.html()).toContain(user.formatted_created_at_date)
    // })
  })

})