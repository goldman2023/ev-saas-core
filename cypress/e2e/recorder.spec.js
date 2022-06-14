describe('Cypress Recording', () => {
    it('Redirects to feed', () => {
        cy.visit('http://foxask.localhost:8000/');
        cy.get('[data-test=we-login-email]').click();
        cy.get('[data-test=we-login-email]').type('{backspace}');
        cy.get('[data-test=we-login-email]').type('{backspace}');
        cy.get('[data-test=we-login-email]').type('customer@eim.solutions');
        cy.get('[data-test=we-login-remember]').click();
        cy.get('[data-test=we-login-submit]').click();
        cy.url().should('contains', 'http://foxask.localhost:8000/feed');
    });

});


