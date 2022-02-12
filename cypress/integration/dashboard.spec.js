
describe('My First Test', () => {
    it.only('Does not do much!', () => {
      expect(true).to.equal(true)
    })



  });

  describe('authenticated users can see the dashboard', () => {

    it('Can go to laravel route!', () => {
        cy.visit('/dashboard').contains('Welcome Back, JohnDoe!');

    })
  });

  describe('this is click test', () => {
    it.only('Can click on the button', () => {
        cy.visit({
            route: 'login'
        });

        cy.contains('type').click()

        // Should be on a new URL which includes '/commands/actions'
        // cy.url().should('include', '/commands/actions')

        // Get an input, type into it and verify that the value has been updated
        cy.get('#email')
          .type('fake@email.com')
          .should('have.value', 'fake@email.com')
    })
  });

