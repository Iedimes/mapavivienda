import AppListing from '../app-components/Listing/AppListing';

Vue.component('segobra-listing', {
    mixins: [AppListing],
    data: function data() {
        return {
            orderBy: {
                column: 'SEOBId',
                direction: 'asc'
            },
        }
    }
});
