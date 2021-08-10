// login.spec.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test

describe('Login Test', () => {
  /* Tests should Cover all the user stories provided in user stories for specific feature */
  it('Works!', () => {
    expect(true).to.equal(true)
  })

  it('Shows login page', () => {
    cy.visit('/');

    cy.get('[data-test="header.login"]').click();
    cy.url().should('include', '/login');
  })

})
