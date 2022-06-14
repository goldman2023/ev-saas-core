describe('logged in user, should be able to access dashboard', () => {
    it('Shows dashboard page for admin', () => {

        cy.login('team@eim.solutions');


        expect(cy.url().should('include', '/dashboard'));

    })

    it('Shows error for invalid credentials', () => {

        cy.visit({
            route: 'user.login'
        });

        /* Get the header login button on desktop */
        // cy.get('[data-test="we-login-header"]')
        //     .click()

        cy.get('[data-test="we-login-email"]')
            .type('team@eim.solutions')

        cy.get('[data-test="we-login-password"]')
            .type('123456')

        cy.get('[data-test="we-login-submit"]')
            .click()

        expect(cy.contains('Invalid credentials'));

    })
})


describe('unauthentificated user, should not be able to access dashboard', () => {
    it('Does not allow user to preview dashboard without logging in', () => {

        // cy.visit('/dashboard', {failOnStatusCode: false});

        /* WE can use laravel route names inside a visit function like this */
        cy.visit({
            route: 'dashboard'
        });
        expect(cy.url().should('include', '/users/login'));
    })
})
