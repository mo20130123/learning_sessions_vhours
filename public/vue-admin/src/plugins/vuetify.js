import Vue from 'vue';
import Vuetify from 'vuetify/lib';

Vue.use(Vuetify);

export default new Vuetify({
    theme: {
        // dark: true,
        themes: {
            light: {
                background: '#F2F2F2'
            },
            dark: {
                background: '#0b0a0d',
                black: 'white'
            },
        },
        options: {
           customProperties: true
        },
    },

});
