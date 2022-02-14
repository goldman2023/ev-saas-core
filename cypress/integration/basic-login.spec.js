
describe('unauthentificated user, should not be able to access dashboard', () => {
    it('Does not do much!', () => {

        cy.visit({
            route: 'dashboard'
        });

        cy.contains('users/login');

    })
})
