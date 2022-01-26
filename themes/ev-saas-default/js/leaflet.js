import { OpenStreetMapProvider } from 'leaflet-geosearch';

window.EV.leaflet = {
    geosearch: {
        provider: new OpenStreetMapProvider(),
        getResults: async function(search_query) {
            return await window.EV.leaflet.geosearch.provider.search({ query: search_query });
        }
    }

};
