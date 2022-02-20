describe('User can logout and see success message', () => {
    it('Shows success message after logout', () => {
        cy.login('team@eim.solutions');


        cy.logout();
        // var container = cy.get('.app-layout-container');
        // expect(container).to.have.text('You have sucefully logged out!')
        expect(cy.contains('You have sucefully logged out!'));

    })
})
