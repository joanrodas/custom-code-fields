import Alpine from 'alpinejs';

window.addEventListener( 'DOMContentLoaded', () => {

    Alpine.magic('parent', (el, { Alpine }) => {
        return Alpine.mergeProxies(
            Alpine.closestDataStack(el).slice(1)
        )
    })

    Alpine.data( 'initSection', ( product_id: number ) => ( {
        init()
        {
            fetch( CCF_PARAMS.api_url + '/getFields/' + product_id,
              {
                  // eslint-disable-line
                  method: 'GET',
                  mode: 'cors',
                  credentials: 'same-origin',
                  redirect: 'follow',
                  referrerPolicy: 'no-referrer',
                  headers: {
                      'X-WP-Nonce': CCF_PARAMS.restNonce, // eslint-disable-line
                  }
              }
            ).then(response => response.json())
            .then( ( response ) => {
              this.section_fields = response.fields;
            } );

        },
        field_name: '',
        section_fields: []
    } ) );

    window.Alpine = Alpine;
    Alpine.start();
} );
