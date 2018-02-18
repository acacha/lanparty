import {mount} from 'vue-test-utils'
import expect from 'expect'
import Example from '../../resources/assets/js/components/ExampleComponent.vue'

describe('Example', () => {
  let component

  beforeEach(() => {
    component = mount(Example)
  })

  it('contains example', () => {
    expect(component.html()).toContain('Example')
  })

})