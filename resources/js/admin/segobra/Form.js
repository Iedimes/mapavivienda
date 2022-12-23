import AppForm from '../app-components/Form/AppForm';

Vue.component('segobra-form', {
    mixins: [AppForm],
    data: function() {
        return {
            mediaCollections: ['gallery'],
            form: {

            }
        }
    }

});
