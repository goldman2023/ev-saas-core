describe('User can create a product', () => {
    it('Shows a validation errors if only 2 fields are completed', () => {
        cy.visit('/');

        cy.login('team@eim.solutions');

        /* TODO: Laravel factories like this doesn't
         * really work because of something, generating
         * dynamci data would be good
         * */
        // var data = cy.create('App\\Models\\Product', { name: 'My First Post' });
        // console.log(data);
        var product = {
            name: 'Product Title',
            excerpt: "Short description",
            description: "Long description, lorem ipsum dolor amet",
            current_stock: 1,
            sku: 'demo_sku_' + Date.now(),
        };



        cy.visit('/dashboard/products/create/');

        Object.keys(product).forEach(key => {
            /* TODO: Maybe consider creating product object with another skip option for each entry */
            if (key !== 'description') {
                cy.get('[name="product.' + key + '"]').clear().type(product[key])
                    .should('have.value', product[key]);
            }
        });

        /*   product.each(((key, value) => {
              cy.get('[name="product.`key`"]').type(value)
                  .should('have.value', value);
          })); */


        /*     cy.get('[name="product.name"]').type(product.name)
                .should('have.value', product.name); */

        /* Workaround for toast ui editor */
        cy.get('.js-toast-ui-editor').click().type(product.description);
        /* This does not work, because original element gets display none rule */
        /* cy.get('[name="product.description"]').type(product.description)
        .should('have.value', product.description); */


        cy.get('[data-test="we-product-submit"]').click();
        /* Test the validation rules */
        expect(cy.contains('The selected categories field is required.'));
        expect(cy.contains('The thumbnail field is required.'));


    })
})
