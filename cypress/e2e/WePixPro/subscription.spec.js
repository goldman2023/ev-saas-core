describe('logged in user, should be able to access dashboard', () => {
    it('Shows dashboard page for admin', () => {

        cy.visit('https://new.pix-pro.com');


        expect(cy.url().should('include', '/dashboard'));

    })

})
