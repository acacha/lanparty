<template>
    <v-navigation-drawer
            fixed
            clipped
            app
            v-model="dataDrawer"
    >
        <v-list dense>
            <template v-for="(item, i) in items">
                <template v-if="checkRoles(item)">
                    <v-layout
                            row
                            v-if="item.heading"
                            align-center
                            :key="i"
                    >
                        <v-flex xs6>
                            <v-subheader v-if="item.heading">
                                {{ item.heading }}
                            </v-subheader>
                        </v-flex>
                    </v-layout>
                    <v-list-group v-else-if="item.children" v-model="item.model" no-action>
                        <v-list-tile slot="item" :href="item.href">
                            <v-list-tile-action>
                                <v-icon>{{ item.model ? item.icon : item['icon-alt'] }}</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ item.text }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                        <v-list-tile
                                v-for="(child, i) in item.children"
                                :key="i"
                                :href="item.href"
                                :target="item.target"
                        >
                            <v-list-tile-action v-if="child.icon">
                                <v-icon>{{ child.icon }}</v-icon>
                            </v-list-tile-action>
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ child.text }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list-group>
                    <v-list-tile v-else :href="item.href" :target="item.target" :style="selectedStyle(item)">
                        <v-list-tile-action>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>
                                {{ item.text }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </template>
            </template>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
export default {
  name: 'MainNavigationDrawer',
  data () {
    return {
      dataDrawer: this.drawer,
      items: [
        { icon: 'home', text: 'Home', href: '/home' },
        { icon: 'contacts', text: 'Col·laboradors', href: '/colaboradors', new: true  },
        { icon: 'favorite_border', text: 'Premis', href: '/premis', new: true },
        { heading: 'Links'},
        { icon: 'link', text: 'Institut de l\'Ebre', href: 'https://www.iesebre.com', new: true },
        { icon: 'link', text: 'Web Lan Party', href: 'http://lanparty.iesebre.com' , new: true },
        { icon: 'link', text: 'Facebook Lan Party', href: 'https://www.facebook.com/LanPartyIesEbre' , new: true },
        { icon: 'link', text: 'Streaming (Twitch)', href: 'https://www.twitch.tv/iesebrelanparty' , new: true },
        { heading: 'Administració', role: 'Manager'},
        { icon: 'face', text: 'Participants', href: '/manage/participants', role: 'Manager' },
        { icon: 'face', text: 'Managers', href: '/manage/managers', role: 'Manager' },
        { icon: 'event', text: 'Events', href: '/manage/events', role: 'Manager' },
        { icon: 'favorite', text: 'Sorteig', href: '/manage/sorteig', role: 'Manager', new : true },
        { icon: 'group', text: 'Col·laboradors', href: '/manage/partners', role: 'Manager', new : true },
        {icon:'card_giftcard',text:'Premis',href:'/manage/prizes',role:'Manager', new: true}
      ]
    }
  },
  props: {
    drawer: {
      Type: Boolean,
      default: false
    }
  },
  watch: {
    dataDrawer (drawer) {
      this.$emit('input', drawer)
    },
    drawer (drawer) {
      this.dataDrawer = drawer
    }
  },
  model: {
    prop: 'drawer',
    event: 'input'
  },
  methods: {
    checkRoles(item) {
      if (item.role) {
        return this.$store.getters.roles.find(function (role) {
          return role == item.role // eslint-disable-line
        })
      }
      return true
    },
    setSelectedItem () {
      const currentPath = window.location.pathname
      const selected = this.items.indexOf(this.items.find(item => item.href === currentPath))
      if (this.items[selected]) this.items[selected].selected = true
    },
    selectedStyle (item) {
      if (item.selected) {
        return {
          'border-left': '5px solid #F0B429',
          'background-color': '#F0F4F8',
          'font-size': '1em'
        }
      }
    }
  },
  created () {
    this.setSelectedItem()
  }
}
</script>
