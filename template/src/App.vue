<template>
  <div id="app">
    {{#router}}
    <app-header />
    <main>
      <router-view/>
    </main>
    <app-footer />
    {{else}}
    <Index/>
    {{/router}}
  </div>
</template>

<script>
{{#unless router}}
import Index from './components/pages/Index'

{{/unless}}
export default {
  name: 'App'{{#router}}{{else}},
  components: {
    Index
  }{{/router}}
}
</script>
